import csv
import html
import json
import queue
import re
import threading
import urllib.error
import urllib.parse
import urllib.request
from datetime import datetime, timedelta, timezone
from decimal import Decimal
from html.parser import HTMLParser
import tkinter as tk
from tkinter import filedialog, messagebox, ttk


API_URL = "https://smmtop.com/api/system/history/list"
DEFAULT_API_KEY = "d447e5c307213a69eccc9946e0706f1d"
TIMEZONE = timezone(timedelta(hours=7), "UTC+07")
PAGE_SIZE = 1000
MAX_PAGES = 250
DATE_FORMAT = "%Y-%m-%d %H:%M:%S"
CHANGE_RE = re.compile(
    r"(-?(?:\d{1,3}(?:,\d{3})+|\d+)(?:\.\d+)?)\s*([+-])\s*"
    r"(-?(?:\d{1,3}(?:,\d{3})+|\d+)(?:\.\d+)?)\s*=\s*"
    r"(-?(?:\d{1,3}(?:,\d{3})+|\d+)(?:\.\d+)?)"
)

FIELDS = [
    ("id", ""),
    ("id", "action"),
    ("object_id", "object_id"),
    ("quantity", "quantity"),
    ("price_change", "price_change"),
    ("notes", "notes"),
    ("time", "time"),
    ("owner", "owner"),
]


class TextOnlyParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.parts = []

    def handle_data(self, data):
        self.parts.append(data)


def html_text(value):
    parser = TextOnlyParser()
    parser.feed(html.unescape(str(value or "")))
    return " ".join(" ".join(parser.parts).split())


def parse_api_time(value):
    try:
        return datetime.strptime(value, "%Y/%m/%d %H:%M:%S").replace(tzinfo=TIMEZONE)
    except (TypeError, ValueError):
        return None


def classify_and_check(raw):
    notes = html_text(raw.get("notes"))
    lower_notes = notes.lower()
    if "refund" in lower_notes:
        kind = "refund"
    elif "purchase" in lower_notes:
        kind = "purchase"
    elif any(marker in lower_notes for marker in (
        "deposit", "add funds", "added funds", "top up", "top-up", "recharge",
    )):
        kind = "deposit"
    else:
        kind = "other"
    change_text = html_text(raw.get("price_change"))
    match = CHANGE_RE.search(change_text)
    anomalies = []
    change = None

    if not match:
        anomalies.append("Không đọc được price_change")
    else:
        before = Decimal(match.group(1).replace(",", ""))
        operator = match.group(2)
        amount = Decimal(match.group(3).replace(",", ""))
        after = Decimal(match.group(4).replace(",", ""))
        expected = before + amount if operator == "+" else before - amount
        change = {
            "before": before,
            "operator": operator,
            "amount": amount,
            "after": after,
        }
        if abs(expected - after) > Decimal("0.00011"):
            anomalies.append("Phép tính số dư không khớp")
        if after < Decimal("-0.00001"):
            anomalies.append("Số dư sau giao dịch âm")
        if (kind == "refund" and operator != "+") or (
            kind == "purchase" and operator != "-"
        ):
            anomalies.append("Dấu biến động không khớp loại giao dịch")

    parsed_time = parse_api_time(raw.get("time"))
    if not parsed_time:
        return None

    quantity = raw.get("quantity")
    try:
        quantity = float(quantity) if quantity not in (None, "") else None
    except (TypeError, ValueError):
        quantity = None

    return {
        "id": raw.get("id", ""),
        "object_id": str(raw.get("object_id", "")),
        "quantity": quantity,
        "notes": notes,
        "owner": str(raw.get("owner", "")),
        "role": str(raw.get("role", "")),
        "time": parsed_time,
        "kind": kind,
        "change": change,
        "anomalies": anomalies,
    }


def make_payload(key, start, draw):
    payload = {"draw": draw}
    for index, (data, name) in enumerate(FIELDS):
        payload.update({
            f"columns[{index}][data]": data,
            f"columns[{index}][name]": name,
            f"columns[{index}][searchable]": "true",
            f"columns[{index}][orderable]": "true",
            f"columns[{index}][search][value]": "",
            f"columns[{index}][search][regex]": "false",
        })
    payload.update({
        "order[0][column]": "6",
        "order[0][dir]": "desc",
        "order[0][name]": "time",
        "start": start,
        "length": PAGE_SIZE,
        "search[value]": "",
        "search[regex]": "false",
        "key": key,
    })
    return payload


def fetch_history(key, start_date, end_date, notify_page):
    rows = []
    pages = 0
    for page in range(MAX_PAGES):
        payload = urllib.parse.urlencode(
            make_payload(key, page * PAGE_SIZE, page + 1)
        ).encode("utf-8")
        request = urllib.request.Request(
            API_URL,
            data=payload,
            headers={
                "Accept": "application/json",
                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                "X-Requested-With": "XMLHttpRequest",
                "User-Agent": "Mozilla/5.0 (compatible; HistoryAudit/1.0)",
            },
            method="POST",
        )
        try:
            with urllib.request.urlopen(request, timeout=45) as response:
                body = json.loads(response.read().decode("utf-8"))
        except urllib.error.HTTPError as exc:
            raise RuntimeError(f"API trả về HTTP {exc.code}.") from None
        except (urllib.error.URLError, TimeoutError, json.JSONDecodeError) as exc:
            reason = getattr(exc, "reason", None)
            raise RuntimeError(f"Không thể đọc dữ liệu từ API: {reason or exc}") from None

        if not isinstance(body, dict) or not body.get("success") or not isinstance(body.get("data"), list):
            raise RuntimeError("Phản hồi không hợp lệ hoặc API key không đúng.")

        page_rows = body["data"]
        pages += 1
        if not page_rows:
            notify_page(pages, [], len(rows))
            break

        oldest = None
        matched_rows = []
        for raw in page_rows:
            if not isinstance(raw, dict):
                continue
            row = classify_and_check(raw)
            if not row:
                continue
            if oldest is None or row["time"] < oldest:
                oldest = row["time"]
            if start_date <= row["time"] <= end_date:
                rows.append(row)
                matched_rows.append(row)

        matched_rows.sort(key=lambda item: item["time"], reverse=True)
        notify_page(pages, matched_rows, len(rows))
        if len(page_rows) < PAGE_SIZE or (oldest and oldest < start_date):
            break

    rows.sort(key=lambda item: item["time"], reverse=True)
    return rows, pages, pages >= MAX_PAGES


class HistoryAuditApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Đối soát lịch sử SMMTop")
        self.root.geometry("1420x850")
        self.root.minsize(980, 620)
        self.root.configure(bg="#f3f5f7")
        self.results = []
        self.messages = queue.Queue()
        self._build_ui()
        self._poll_messages()

    def _build_ui(self):
        style = ttk.Style()
        style.theme_use("clam")
        style.configure("Treeview", rowheight=30, font=("Segoe UI", 9))
        style.configure("Treeview.Heading", font=("Segoe UI", 9, "bold"))
        style.configure("TButton", padding=(12, 8))
        style.configure("Stat.TLabel", font=("Segoe UI", 16, "bold"))

        shell = ttk.Frame(self.root, padding=20)
        shell.pack(fill="both", expand=True)
        ttk.Label(shell, text="Đối soát biến động số dư", font=("Segoe UI", 20, "bold")).pack(anchor="w")
        ttk.Label(
            shell,
            text="Lịch sử SMMTop · giờ Việt Nam (UTC+7)",
            foreground="#667085",
        ).pack(anchor="w", pady=(2, 16))

        controls = ttk.LabelFrame(shell, text="Nguồn dữ liệu và khoảng thời gian", padding=12)
        controls.pack(fill="x", pady=(0, 14))
        controls.columnconfigure(1, weight=1)
        controls.columnconfigure(3, weight=1)
        ttk.Label(controls, text="API key").grid(row=0, column=0, sticky="w", padx=(0, 8), pady=5)
        self.key_var = tk.StringVar(value=DEFAULT_API_KEY)
        self.key_entry = ttk.Entry(controls, textvariable=self.key_var, show="•")
        self.key_entry.grid(row=0, column=1, sticky="ew", padx=(0, 18), pady=5)
        ttk.Label(controls, text="Từ (YYYY-MM-DD HH:MM:SS)").grid(row=0, column=2, sticky="w", padx=(0, 8), pady=5)
        self.from_var = tk.StringVar(value="2026-10-10 06:29:01")
        ttk.Entry(controls, textvariable=self.from_var).grid(row=0, column=3, sticky="ew", padx=(0, 18), pady=5)
        ttk.Label(controls, text="Đến (giờ Việt Nam)").grid(row=0, column=4, sticky="w", padx=(0, 8), pady=5)
        self.to_var = tk.StringVar(value=datetime.now(TIMEZONE).strftime(DATE_FORMAT))
        ttk.Entry(controls, textvariable=self.to_var, width=21).grid(row=0, column=5, sticky="ew", pady=5)

        actions = ttk.Frame(controls)
        actions.grid(row=1, column=0, columnspan=6, sticky="ew", pady=(8, 0))
        self.fetch_button = ttk.Button(actions, text="Tải và đối soát", command=self.start_fetch)
        self.fetch_button.pack(side="left")
        ttk.Label(actions, text="API key chỉ dùng trong lần tải này, không được ghi ra tệp.", foreground="#667085").pack(side="left", padx=12)
        self.status_var = tk.StringVar(value="Sẵn sàng")
        ttk.Label(actions, textvariable=self.status_var, foreground="#475467").pack(side="right")

        stats = ttk.Frame(shell)
        stats.pack(fill="x", pady=(0, 14))
        self.stat_vars = {}
        for name, label in [
            ("count", "Bản ghi"),
            ("purchase", "Mua"),
            ("refund", "Hoàn tiền"),
            ("deposit", "Nạp"),
            ("other", "Khác"),
            ("anomaly", "Bất thường"),
            ("pages", "Trang đã tải"),
        ]:
            box = ttk.LabelFrame(stats, text=label, padding=(12, 8))
            box.pack(side="left", fill="x", expand=True, padx=(0, 8))
            value = tk.StringVar(value="—")
            self.stat_vars[name] = value
            ttk.Label(box, textvariable=value, style="Stat.TLabel").pack(anchor="w")

        totals = ttk.Frame(shell)
        totals.pack(fill="x", pady=(0, 14))
        for name, label in [
            ("purchase_total", "Doanh thu gộp / tiền đã dùng"),
            ("refund_total", "Tổng tiền đã hoàn"),
            ("deposit_total", "Tổng tiền đã nạp"),
            ("net_total", "Doanh thu ròng sau hoàn"),
        ]:
            box = ttk.LabelFrame(totals, text=label, padding=(12, 8))
            box.pack(side="left", fill="x", expand=True, padx=(0, 8))
            value = tk.StringVar(value="$0")
            self.stat_vars[name] = value
            ttk.Label(box, textvariable=value, style="Stat.TLabel").pack(anchor="w")

        table_bar = ttk.Frame(shell)
        table_bar.pack(fill="x", pady=(0, 8))
        ttk.Label(table_bar, text="Lọc").pack(side="left", padx=(0, 6))
        self.filter_var = tk.StringVar(value="Tất cả")
        filter_box = ttk.Combobox(
            table_bar,
            textvariable=self.filter_var,
            values=("Tất cả", "Mua", "Hoàn tiền", "Nạp", "Khác", "Bất thường"),
            state="readonly",
            width=15,
        )
        filter_box.pack(side="left")
        filter_box.bind("<<ComboboxSelected>>", lambda _event: self.render_table())
        ttk.Button(table_bar, text="Xuất CSV", command=self.export_csv).pack(side="right")

        columns = ("time", "kind", "notes", "object", "quantity", "change", "owner", "check")
        self.tree = ttk.Treeview(shell, columns=columns, show="headings")
        headings = {
            "time": ("Thời gian", 145),
            "kind": ("Loại", 85),
            "notes": ("Ghi chú", 300),
            "object": ("Đối tượng", 240),
            "quantity": ("Số lượng", 95),
            "change": ("Biến động số dư", 210),
            "owner": ("Chủ tài khoản", 110),
            "check": ("Kiểm tra", 260),
        }
        for key, (label, width) in headings.items():
            self.tree.heading(key, text=label)
            self.tree.column(key, width=width, minwidth=75, anchor="w", stretch=key in ("notes", "object", "check"))
        self.tree.tag_configure("anomaly", background="#fff0ee", foreground="#982b20")
        self.tree.tag_configure("refund", foreground="#087e8b")
        yscroll = ttk.Scrollbar(shell, orient="vertical", command=self.tree.yview)
        xscroll = ttk.Scrollbar(shell, orient="horizontal", command=self.tree.xview)
        self.tree.configure(yscrollcommand=yscroll.set, xscrollcommand=xscroll.set)
        self.tree.pack(fill="both", expand=True, side="top")
        self.tree.bind("<Double-1>", self.copy_object_link)
        xscroll.pack(fill="x")
        yscroll.place(in_=self.tree, relx=1, rely=0, relheight=1, anchor="ne")

    def copy_object_link(self, event):
        if self.tree.identify_column(event.x) != "#4":
            return
        item = self.tree.identify_row(event.y)
        if not item:
            return
        link = self.tree.item(item, "values")[3]
        if not link or link == "—":
            return
        self.root.clipboard_clear()
        self.root.clipboard_append(link)
        self.status_var.set("Đã sao chép link vào clipboard")

    def start_fetch(self):
        key = self.key_var.get().strip()
        try:
            start_date = datetime.strptime(self.from_var.get().strip(), DATE_FORMAT).replace(tzinfo=TIMEZONE)
            end_date = datetime.strptime(self.to_var.get().strip(), DATE_FORMAT).replace(tzinfo=TIMEZONE)
        except ValueError:
            messagebox.showerror("Thời gian không hợp lệ", f"Nhập thời gian theo mẫu {DATE_FORMAT}.")
            return
        if len(key) < 8 or len(key) > 256:
            messagebox.showerror("API key không hợp lệ", "Nhập API key từ 8 đến 256 ký tự.")
            return
        if start_date > end_date or end_date > datetime.now(TIMEZONE):
            messagebox.showerror("Khoảng thời gian không hợp lệ", "Thời điểm bắt đầu/kết thúc chưa hợp lệ.")
            return

        self.fetch_button.configure(state="disabled")
        self.status_var.set("Đang tải trang 1…")
        self.results = []
        self.active_range = (start_date, end_date)
        self._update_stats(0, False)
        self.render_table()
        threading.Thread(
            target=self._fetch_worker,
            args=(key, start_date, end_date),
            daemon=True,
        ).start()

    def _fetch_worker(self, key, start_date, end_date):
        try:
            rows, pages, truncated = fetch_history(
                key,
                start_date,
                end_date,
                lambda page, page_rows, count: self.messages.put(
                    ("page", page, page_rows, count)
                ),
            )
            self.messages.put(("done", pages, truncated))
        except Exception as exc:
            self.messages.put(("error", str(exc)))

    def _poll_messages(self):
        try:
            while True:
                message = self.messages.get_nowait()
                if message[0] == "page":
                    _, pages, page_rows, count = message
                    out_of_order = bool(
                        self.results
                        and page_rows
                        and page_rows[0]["time"] > self.results[-1]["time"]
                    )
                    self.results.extend(page_rows)
                    self._update_stats(pages, False)
                    if out_of_order:
                        self.results.sort(key=lambda row: row["time"], reverse=True)
                        self.render_table()
                    else:
                        for row in page_rows:
                            if self._matches_filter(row):
                                self._insert_row(row)
                    self.status_var.set(
                        f"Đã tải {pages} trang · {count:,} bản ghi trong khoảng"
                    )
                    self.root.update_idletasks()
                elif message[0] == "done":
                    _, pages, truncated = message
                    self._update_stats(pages, truncated)
                    self.status_var.set("Hoàn tất" + (" · chạm giới hạn trang" if truncated else ""))
                    self.fetch_button.configure(state="normal")
                elif message[0] == "error":
                    self.status_var.set("Tải dữ liệu thất bại")
                    self.fetch_button.configure(state="normal")
                    messagebox.showerror("Không thể tải lịch sử", message[1])
        except queue.Empty:
            pass
        self.root.after(100, self._poll_messages)

    def _filtered_rows(self):
        rows = self._period_rows()
        return [row for row in rows if self._matches_filter(row)]

    def _matches_filter(self, row):
        selected = self.filter_var.get()
        if selected == "Mua":
            return row["kind"] == "purchase"
        if selected == "Hoàn tiền":
            return row["kind"] == "refund"
        if selected == "Nạp":
            return row["kind"] == "deposit"
        if selected == "Khác":
            return row["kind"] == "other"
        if selected == "Bất thường":
            return bool(row["anomalies"])
        return True

    def _period_rows(self):
        period = getattr(self, "active_range", None)
        if not period:
            return self.results
        start_date, end_date = period
        return [
            row for row in self.results
            if start_date <= row["time"] <= end_date
        ]

    def render_table(self):
        rows = self._filtered_rows()
        self.tree.delete(*self.tree.get_children())
        for row in rows:
            self._insert_row(row)

    def _insert_row(self, row):
        change = row["change"]
        if change:
            change_text = (
                self._fmt_money(change["before"])
                + f' {change["operator"]} {self._fmt_money(change["amount"])}'
                + f' = {self._fmt_money(change["after"])}'
            )
        else:
            change_text = "Không phân tích được"
        kind_label = {
            "purchase": "Mua",
            "refund": "Hoàn tiền",
            "deposit": "Nạp",
            "other": "Khác",
        }[row["kind"]]
        check = "; ".join(row["anomalies"]) if row["anomalies"] else "Hợp lệ"
        tags = ("anomaly",) if row["anomalies"] else (("refund",) if row["kind"] == "refund" else ())
        self.tree.insert(
            "",
            "end",
            values=(
                row["time"].strftime(DATE_FORMAT),
                kind_label,
                row["notes"],
                row["object_id"],
                self._fmt_number(row["quantity"]),
                change_text,
                f'{row["owner"]} ({row["role"]})'.strip(" ()"),
                check,
            ),
            tags=tags,
        )

    def _update_stats(self, pages, truncated):
        period_rows = self._period_rows()

        def total_for(kind):
            return sum(
                (
                    row["change"]["amount"]
                    for row in period_rows
                    if row["kind"] == kind and row["change"]
                ),
                Decimal("0"),
            )

        purchase_total = total_for("purchase")
        refund_total = total_for("refund")
        counts = {
            "count": len(period_rows),
            "purchase": sum(row["kind"] == "purchase" for row in period_rows),
            "refund": sum(row["kind"] == "refund" for row in period_rows),
            "deposit": sum(row["kind"] == "deposit" for row in period_rows),
            "other": sum(row["kind"] == "other" for row in period_rows),
            "anomaly": sum(bool(row["anomalies"]) for row in period_rows),
            "pages": f"{pages:,}" + ("+" if truncated else ""),
            "purchase_total": purchase_total,
            "refund_total": refund_total,
            "deposit_total": total_for("deposit"),
            "net_total": purchase_total - refund_total,
        }
        for key, value in counts.items():
            if key.endswith("_total"):
                self.stat_vars[key].set(self._fmt_money(value))
            else:
                self.stat_vars[key].set(f"{value:,}" if isinstance(value, int) else value)

    @staticmethod
    def _fmt_money(value):
        if value is None:
            value = Decimal("0")
        elif not isinstance(value, Decimal):
            value = Decimal(str(value))
        return "$" + f"{value:,.8f}".rstrip("0").rstrip(".")

    @staticmethod
    def _fmt_number(value):
        if value is None:
            return "—"
        return f"{value:,.8f}".rstrip("0").rstrip(".")

    def export_csv(self):
        if not self.results:
            messagebox.showinfo("Chưa có dữ liệu", "Hãy tải lịch sử trước khi xuất CSV.")
            return
        path = filedialog.asksaveasfilename(
            title="Lưu báo cáo CSV",
            defaultextension=".csv",
            initialfile="smmtop-history-audit.csv",
            filetypes=[("CSV", "*.csv")],
        )
        if not path:
            return
        fields = [
            "id", "time", "kind", "owner", "role", "quantity",
            "before", "operator", "amount", "after", "notes", "object_id", "anomalies",
        ]
        try:
            with open(path, "w", newline="", encoding="utf-8-sig") as output:
                writer = csv.DictWriter(output, fieldnames=fields)
                writer.writeheader()
                for row in self.results:
                    change = row["change"] or {}
                    writer.writerow({
                        "id": row["id"],
                        "time": row["time"].strftime(DATE_FORMAT),
                        "kind": row["kind"],
                        "owner": row["owner"],
                        "role": row["role"],
                        "quantity": row["quantity"],
                        "before": change.get("before"),
                        "operator": change.get("operator"),
                        "amount": change.get("amount"),
                        "after": change.get("after"),
                        "notes": row["notes"],
                        "object_id": row["object_id"],
                        "anomalies": "; ".join(row["anomalies"]),
                    })
        except OSError as exc:
            messagebox.showerror("Không thể lưu CSV", str(exc))
            return
        self.status_var.set(f"Đã xuất {len(self.results):,} dòng: {path}")


def main():
    root = tk.Tk()
    HistoryAuditApp(root)
    root.mainloop()


if __name__ == "__main__":
    main()
