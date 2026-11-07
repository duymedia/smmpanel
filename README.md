# Design Skill: 1MM.ME SMM Dashboard

> Hướng dẫn thiết kế dashboard Social Media Marketing dựa trên HTML tham chiếu “1MM.ME - Marketing in a Minute”. Dùng tài liệu này để các màn hình mới có cùng ngôn ngữ thiết kế, cách tổ chức và hành vi.

## Sản phẩm và người dùng

1MM.ME là dashboard đặt và theo dõi dịch vụ SMM. Người dùng chính là chủ tài khoản, reseller và người vận hành thường xuyên cần tìm dịch vụ, tạo đơn, theo dõi giao dịch, nạp tiền và xử lý hỗ trợ.

Ưu tiên công việc:

- Đặt đơn chính xác với ít bước: chọn dịch vụ, nhập liên kết và số lượng, xem giá, xác nhận.
- Tìm nhanh dịch vụ trong danh mục lớn.
- Nắm rõ số dư, trạng thái đơn, thời gian xử lý và cảnh báo giá.
- Điều hướng nhất quán giữa đơn hàng, tài chính, hỗ trợ và công cụ.

## Nguyên tắc thiết kế

- Thiết kế cho thao tác lặp lại, không phải quảng cáo. Ưu tiên thứ tự, nhãn dễ quét và trạng thái rõ ràng.
- Dành vùng chính cho tác vụ đang làm; thông tin phụ như thời gian trung bình, hướng dẫn và trạng thái nằm gần tác vụ liên quan.
- Dùng teal cho thương hiệu và hành động chính. Màu vàng/cam chỉ báo cảnh báo; đỏ dành cho lỗi hoặc hành động nguy hiểm.
- Giữ bố cục nhiều thông tin nhưng tránh xếp nhiều cấp card. Dùng khoảng cách, đường phân cách và tiêu đề để thể hiện cấu trúc.
- Nội dung dùng động từ trực tiếp, câu ngắn và đúng ngôn ngữ người dùng. Mỗi nhãn chỉ thực hiện một nhiệm vụ.
- Chỉ dùng chuyển động khi nó phản hồi thao tác hoặc làm rõ thay đổi trạng thái. Tôn trọng `prefers-reduced-motion`.

## Nhận diện trực quan

### Màu tham chiếu

Các giá trị dưới đây lấy từ trang tham chiếu. Duy trì chúng thành token, không rải màu tuỳ ý trong từng component.

| Token | Giá trị | Vai trò |
| --- | --- | --- |
| `--color-primary` | `#0f8a7d` | Màu thương hiệu và điểm nhấn chính ở giao diện sáng |
| `--color-primary-dark` | `#0c6e64` | Hover và trạng thái nhấn |
| `--color-primary-light` | `#43c6b8` | Điểm nhấn nhẹ, không dùng cho chữ nhỏ trên nền sáng |
| `--db-primary` (dark) | `#14b8a6` | Màu hành động chính ở giao diện tối |
| `--db-primary-dark` (dark) | `#0e8174` | Hover ở giao diện tối |
| `--db-primary-light` (dark) | `#8adcd3` | Điểm nhấn nhẹ ở giao diện tối |
| `--db-primary-bg` | `rgba(15, 138, 125, 0.08)` | Nền chọn/làm nổi ở giao diện sáng |
| `--db-primary-bg` (dark) | `rgba(20, 184, 166, 0.12)` | Nền chọn/làm nổi ở giao diện tối |
| `--db-nav-start` / `--db-nav-end` | `#0f8a7d` / `#0c6e64` | Chuyển sắc teal của điều hướng nếu layout đang dùng |
| Dark shell | `#0f172a` | Nền tối chính trong dashboard |
| Neutral | `#f1f5f9`, `#f8fafc` | Nền sáng, vùng phụ và bề mặt trung tính |
| Action on light | `#0c6e64` | Nền nút có chữ trắng khi cần contrast AA |
| Action on dark | `#0e8174` | Nền nút có chữ trắng trong dark theme |
| Warning | `#f59e0b`, `#fffbeb`; text `#b45309` | Cảnh báo, thông tin cần xác nhận |
| Danger | `#ef4444`; text `#b91c1c` | Lỗi và hành động nguy hiểm |

Dùng màu trạng thái theo nghĩa nhất quán. Đảm bảo chữ thường đạt contrast tối thiểu 4.5:1; không truyền đạt trạng thái chỉ bằng màu.

### Typography

- `Nunito Sans` dùng cho nội dung và điều khiển giao diện.
- `Rubik` dùng cho tiêu đề và điểm nhấn có phân cấp.
- Dùng weight 400 cho nội dung, 500-600 cho nhãn và điều hướng, 600-700 cho tiêu đề và hành động.
- Giữ cỡ chữ nội dung dễ đọc; chú thích có thể nhỏ hơn nhưng không dùng cỡ siêu nhỏ cho thông tin quan trọng.
- Căn trái nội dung form, bảng và trang nghiệp vụ. Tránh ALL CAPS, chữ giãn tracking và monospace trang trí.

### Hình khối và biểu tượng

- Dùng bo góc nhẹ và thống nhất; card và modal không quá 8px.
- Ưu tiên bề mặt phẳng, đường viền mảnh và phân cấp bằng khoảng cách. Chỉ thêm bóng khi cần phân biệt lớp nổi.
- Dùng icon cho thao tác quen thuộc và ghép icon với nhãn khi hành động có thể gây nhầm lẫn.
- Không thêm gradient, glow, orb hoặc ảnh trang trí cho vùng thao tác. Hình ảnh chỉ xuất hiện khi giúp nhận diện dịch vụ, nền tảng hoặc sản phẩm.

## Bố cục

### Desktop

- Header giữ thương hiệu và tiện ích thường dùng: tìm kiếm, thông báo, ngôn ngữ, số dư và tài khoản.
- Sidebar giữ điều hướng cấp một; chia theo nhóm nghiệp vụ: tài khoản, tài chính, đơn hàng, hỗ trợ, công cụ và tích hợp.
- Main content căn trái, dùng chiều rộng để form và bảng dễ so sánh. Không căn giữa các trang vận hành.
- Trang đặt đơn ưu tiên form; thông tin dịch vụ và giá là vùng phụ gần nút xác nhận.

```text
┌────────────────────────────────────────────────────────────────────┐
│ Brand    Search services                    Notifications  Account │
├──────────────┬─────────────────────────────────────────────────────┤
│ Sidebar      │ Page title, purpose, current balance                │
│ grouped nav  ├───────────────────────────────────┬─────────────────┤
│              │ Order fields and primary action   │ Service details │
│              │                                   │ Rate / timing   │
└──────────────┴───────────────────────────────────┴─────────────────┘
```

### Mobile

- Chuyển sidebar thành drawer có nút mở/đóng dễ chạm; giữ backdrop và trạng thái focus hợp lý.
- Xếp form theo một cột, giữ thứ tự chọn dịch vụ → thông tin đơn → xác nhận.
- Bảng lớn nằm trong vùng cuộn ngang có dấu hiệu cuộn; không làm toàn trang tràn ngang.
- Giữ nút chính nhìn thấy được sau các trường cần thiết; không để số dư, toolbar hoặc nhãn chồng lên tiêu đề.

## Thành phần nghiệp vụ

### Tạo đơn

- Cho phép tìm nhanh và chọn nền tảng, danh mục, dịch vụ theo thứ tự.
- Sau khi chọn dịch vụ, hiển thị tên, giới hạn tối thiểu/tối đa, thời gian trung bình và mô tả trước trường nhập đơn.
- Trường link và số lượng phải giữ trạng thái dễ nhận biết; các biến thể như multi-link, comments, schedule, loop và coupon chỉ hiện khi áp dụng.
- Hiển thị giá ước tính gần trường số lượng và cập nhật ngay khi dữ liệu thay đổi.
- Nút xác nhận mô tả kết quả thực tế, ví dụ “Submit order” hoặc bản dịch tương ứng.
- Khi giá tăng, thông tin thay đổi phải nêu rõ giá mới và yêu cầu xác nhận trước khi đặt.

### Điều hướng

- Giữ nguyên nhóm menu và thứ tự tác vụ giữa các trang.
- Mục hiện tại cần khác biệt rõ trong cả light và dark theme; hover không được thay thế trạng thái active.
- Tất cả nhãn lấy từ catalog `data-lang`, không mã hoá riêng tiếng Anh/Việt trong CSS hoặc JavaScript.

### Bảng, trạng thái và thông báo

- Bảng dùng hàng dễ quét, tiêu đề cột rõ, đơn vị tiền/thời gian nhất quán và trạng thái đơn có cả chữ lẫn màu.
- Empty state hướng người dùng đến bước kế tiếp; lỗi nêu nguyên nhân và cách khắc phục cụ thể.
- Cảnh báo cần hành động có nút xác nhận/huỷ rõ ràng. Không dùng modal cho thông tin chỉ mang tính tham khảo.
- Notification có loại, thời gian, mức ưu tiên và hành động đọc; badge không thay thế nội dung thông báo.

## Hành vi và khả năng tiếp cận

- Theme sáng/tối theo lựa chọn đã lưu; lần đầu có thể theo `prefers-color-scheme`.
- Các điều khiển có trạng thái hover, focus-visible, disabled, loading, success và error.
- Mọi input có label hoặc tên truy cập được; không dùng placeholder thay label.
- Giữ focus nhìn thấy rõ, vùng chạm khoảng 44px trở lên và contrast đạt WCAG AA cho nội dung thường.
- Dùng `data-lang` cho text; dùng khóa có namespace theo trang, ví dụ `new::page_title` và `new::submit_order`.
- Tôn trọng `prefers-reduced-motion`; không chạy hiệu ứng liên tục để trang trí.

## Quy tắc triển khai trong repo

- Trang tham chiếu được cung cấp là dashboard SMM của 1MM.ME. Khi cần tái tạo gần với trang đó, dùng token teal/slate ở trên làm nguồn chuẩn.
- Bản `theme-9` dùng palette graphite/cobalt/teal với hổ phách làm màu cảnh báo; style được cô lập trong `public/assets/client/theme-9.css`, chỉ bật khi `default_interface` là `9`, và không thay đổi các ID/hook JavaScript của form đặt hàng. Utility CSS dùng Tailwind, có source tại `resources/css/theme-9.css` và build bằng `npm run build:theme-9` thành `public/assets/client/theme-9.utilities.css`.
- View giao diện nằm dưới `resources/views/clients/theme-9`. Nhiều view kế thừa layout client mặc định, vì vậy giữ mọi thay đổi riêng của theme trong stylesheet có scope hoặc điều kiện bật tương ứng.
- Không đổi ID, class hook, tên input, `data-*`, route hoặc callback JavaScript đang dùng bởi luồng đặt đơn, số dư, bộ lọc và thanh toán nếu không thay đổi cả hợp đồng tích hợp.
- Dùng route helper khi có named route; giữ nguyên route hiện hành nếu form/action phụ thuộc URL cũ.
- Dữ liệu số dư, tên dịch vụ, giá và trạng thái luôn lấy từ backend. Không đưa dữ liệu mẫu cố định vào giao diện thật.

## Checklist trước khi hoàn tất

- Trang chính cho thấy ngay công việc người dùng có thể làm tiếp theo.
- Bố cục dùng được ở desktop, tablet và điện thoại, không có phần tử chồng lấp hoặc tràn toàn trang.
- Form giữ đúng thứ tự, phản hồi giá/trạng thái đúng và các hành động có kết quả rõ.
- Tất cả nội dung tĩnh đã có khóa dịch; kiểm tra tối thiểu tiếng Anh và tiếng Việt.
- Light/dark mode, keyboard focus, trạng thái trống/lỗi và reduced motion đã được rà.
- Chụp thử trang thật khi môi trường cho phép; đối chiếu cả desktop và mobile trước khi kết thúc.
