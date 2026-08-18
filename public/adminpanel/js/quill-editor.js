/**
 * Quill Editor - Universal for all pages
 * Hỗ trợ nhiều editor với các format lưu khác nhau (HTML hoặc Delta)
 */
document.addEventListener("DOMContentLoaded", function () {
    if (typeof Quill === "undefined") return;

    // Cấu hình các editor với format lưu khác nhau
    const editorConfigs = [
        // Service description editors - lưu HTML format
        {
            editorId: "svc-desc-editor",
            inputId: "svc-desc",
            saveFormat: "html", // Lưu HTML thay vì Delta
        },
        {
            editorId: "editor-service-description",
            inputId: "service-description-content",
            saveFormat: "html",
        },
        // Settings editors - lưu HTML format
        {
            editorId: "editor-announcement",
            inputId: "announcement-content",
            saveFormat: "html",
        },
        {
            editorId: "editor-terms",
            inputId: "terms-content",
            saveFormat: "html",
        },
    ];

    // Quill toolbar config
    const toolbarConfig = [
        ["bold", "italic", "underline", "strike"],
        ["blockquote", "code-block"],
        [
            {
                list: "ordered",
            },
            {
                list: "bullet",
            },
        ],
        [
            {
                align: [],
            },
        ],
        ["link"],
        [
            {
                color: [],
            },
            {
                background: [],
            },
        ],
        [
            {
                size: ["small", false, "large", "huge"],
            },
        ],
        [
            {
                header: [1, 2, 3, 4, 5, 6, false],
            },
        ],
    ];

    // Khởi tạo từng editor
    editorConfigs.forEach((config) => {
        const el = document.getElementById(config.editorId);
        const input = document.getElementById(config.inputId);

        if (!el) return;
        if (el.__quill) return; // Tránh khởi tạo 2 lần

        const quill = new Quill(el, {
            theme: "snow",
            modules: {
                toolbar: toolbarConfig,
            },
        });

        el.__quill = quill;
        quill.__config = config; // Lưu config để dùng trong text-change

        // Load dữ liệu từ hidden input
        const raw = input ? input.value.trim() : "";
        if (raw) {
            try {
                const delta = JSON.parse(raw);
                if (delta.ops && Array.isArray(delta.ops)) {
                    quill.setContents(delta);
                } else {
                    quill.root.innerHTML = raw;
                    quill.update();
                }
            } catch (e) {
                quill.root.innerHTML = raw;
                quill.update();
            }
        }

        // Sync hidden input khi editor thay đổi
        quill.on("text-change", () => {
            if (input) {
                const html = quill.root.innerHTML;
                const delta = quill.getContents();

                // Lưu theo format được cấu hình
                if (config.saveFormat === "html") {
                    // Lưu HTML format
                    input.value = html;
                } else {
                    // Lưu Delta format (mặc định)
                    input.value = JSON.stringify(delta);
                }

                // Lưu thêm các attribute hỗ trợ
                input.setAttribute("data-html", html);
                input.setAttribute(
                    "data-plain-text",
                    delta.ops
                        .map((op) =>
                            typeof op.insert === "string" ? op.insert : "",
                        )
                        .join("")
                        .trim(),
                );
            }
        });

        // Lưu reference để dùng sau
        if (config.editorId === "svc-desc-editor") {
            window.serviceDescriptionEditor = quill;
        }
    });
});
