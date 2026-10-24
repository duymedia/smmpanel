<!DOCTYPE html>
<html lang="{{ Auth::user()?->lang ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trình kéo thả giao diện đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/admin/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/style.css') }}?v={{ config('app.version') }}">
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/libs/font-awesome/6.7.2/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --blue:#2463eb; --border:#e4e8f0; --muted:#8190ad; --ink:#202b48; }
        * { box-sizing:border-box; } body { margin:0; font-family:'Barlow', serif; color:var(--ink); background:#eef2f8; overflow:hidden; }
        .editor { height:100vh; display:grid; grid-template-columns:80px 300px minmax(0,1fr); }
        .rail,.panel { background:#fff; border-right:1px solid var(--border); } .rail { padding:18px 8px; display:flex; flex-direction:column; align-items:center; gap:14px; }
        .rail a,.rail button { width:64px; border:0; padding:10px 3px; border-radius:8px; background:transparent; color:var(--muted); display:grid; gap:5px; justify-items:center; text-decoration:none; font:700 10px/1 'Barlow', serif; text-transform:uppercase; }
        .rail a:hover,.rail button:hover,.rail button.active { background:#edf3ff; color:var(--blue); } .rail i { font-size:18px; } .rail .save { margin-top:auto; color:#fff; background:var(--blue); }
        .panel { padding:22px 14px; overflow:auto; } .panel h1 { margin:0 4px 6px; font-size:17px; } .panel p { margin:0 4px 20px; color:var(--muted); font-size:13px; line-height:1.5; }
        .editor-search { width:100%; padding:11px 10px; margin-bottom:22px; border:0; border-radius:5px; background:#f2f4f8; color:var(--ink); }
        .page-list { border-top:1px solid var(--border); } .page-item,.style-item,.language-item { width:100%; padding:12px 8px; border:0; border-bottom:1px solid var(--border); background:#fff; color:#34415e; text-align:left; font-size:14px; } .page-item { display:flex; justify-content:space-between; } .page-item.active { color:var(--blue); background:#e9f2ff; border-bottom:2px solid var(--blue); font-weight:700; } .page-item i { cursor:pointer; } .add-page { border:0; padding:16px 8px; background:#fff; color:#2871b8; font-weight:700; } .style-item i { width:24px; color:#7c91b5; } .language-item { display:flex; justify-content:space-between; align-items:center; } .language-item.active { color:var(--blue); background:#edf3ff; } .language-item small { color:var(--blue); } .language-edit { color:#7185a6; opacity:0; } .language-item:hover .language-edit,.language-item.active .language-edit { opacity:1; }
        .block-list { border-top:1px solid var(--border); } .block-item { display:flex; align-items:center; gap:10px; width:100%; padding:14px 8px; border:0; border-bottom:1px solid var(--border); background:#fff; color:#34415e; text-align:left; cursor:grab; font-size:14px; } .block-item:active { cursor:grabbing; } .block-item.dragging { opacity:.45; background:#edf3ff; } .block-item .handle { color:#9ba8c0; }
        .translation-editor { margin-top:18px; border:1px solid var(--border); background:#fff; border-radius:6px; overflow:hidden; } .translation-header { display:flex; justify-content:space-between; align-items:center; padding:12px; border-bottom:1px solid var(--border); } .translation-header input { width:150px; border:0; background:#f3f5f8; padding:8px; border-radius:4px; } .translation-body { display:grid; grid-template-columns:110px 1fr; min-height:300px; } #translation-groups { border-right:1px solid var(--border); } #translation-groups button { display:block; width:100%; border:0; background:#fff; padding:9px; color:#2871b8; text-align:left; font-size:12px; } #translation-groups button.active { background:#edf3ff; font-weight:700; } #translation-fields { padding:10px; max-height:340px; overflow:auto; } .translation-field { margin-bottom:12px; } .translation-field label { display:block; color:#8190ad; font-size:11px; margin-bottom:5px; } .translation-field textarea { width:100%; min-height:38px; border:0; border-radius:4px; padding:9px; background:#f3f5f8; color:#34415e; resize:vertical; } .translation-save { width:100%; border:0; padding:11px; background:#2463eb; color:#fff; font-weight:700; }
        .translation-editor { margin-top:18px; border:1px solid var(--border); background:#fff; border-radius:6px; overflow:hidden; } .translation-header { display:flex; justify-content:space-between; align-items:center; padding:12px; border-bottom:1px solid var(--border); } .translation-header input { width:150px; border:0; background:#f3f5f8; padding:8px; border-radius:4px; } .translation-body { display:grid; grid-template-columns:110px 1fr; min-height:300px; } #translation-groups { border-right:1px solid var(--border); } #translation-groups button { display:block; width:100%; border:0; background:#fff; padding:9px; color:#2871b8; text-align:left; font-size:12px; } #translation-groups button.active { background:#edf3ff; font-weight:700; } #translation-fields { padding:10px; max-height:340px; overflow:auto; } .translation-field { margin-bottom:12px; } .translation-field label { display:block; color:#8190ad; font-size:11px; margin-bottom:5px; } .translation-field textarea { width:100%; min-height:38px; border:0; border-radius:4px; padding:9px; background:#f3f5f8; color:#34415e; resize:vertical; } .translation-save { width:100%; border:0; padding:11px; background:#2463eb; color:#fff; font-weight:700; }
        .seo-preview { padding:12px; margin-top:12px; border:1px solid var(--border); border-radius:4px; } .seo-title { color:#91a0bd; font-size:20px; } .seo-url { margin:5px 0; color:#16833d; font-size:13px; } .seo-description { color:#91a0bd; font-size:12px; } .seo-button { border:0; background:transparent; color:#2871b8; font-weight:700; cursor:pointer; } .seo-fields { display:none; } .seo-fields.is-open { display:block; } .save-page-settings { width:100%; margin-top:18px; padding:11px; border:0; border-radius:4px; background:#2463eb; color:#fff; font-weight:700; }
        .helper { padding:14px 8px; background:#f7f9fc; color:var(--muted); font-size:12px; line-height:1.55; } .helper strong { color:#45506c; }
        .editor-field { margin:0 8px 15px; } .editor-field label { display:block; margin-bottom:6px; color:#65728f; font-size:12px; } .editor-field input:not([type="color"]),.editor-field textarea,.editor-field select { width:100%; padding:9px; border:0; border-radius:4px; background:#f3f5f8; color:#34415e; } .editor-field input[type="color"] { width:100%; height:36px; padding:3px; border:1px solid var(--border); border-radius:4px; background:#fff; }
        .page-settings { position:fixed; z-index:20; top:72px; left:380px; width:400px; max-height:calc(100vh - 90px); overflow:auto; padding:18px; background:#fff; border-radius:8px; box-shadow:0 14px 40px rgba(26,39,68,.22); } .page-settings[hidden] { display:none; } .page-settings h2 { margin:0 -18px 16px; padding:0 18px 16px; border-bottom:1px solid var(--border); text-align:center; font-size:15px; } .page-settings label { display:block; margin:14px 0 6px; color:#414d6b; font-size:13px; } .page-settings input:not([type="checkbox"]),.page-settings textarea { width:100%; padding:10px; border:0; border-radius:4px; background:#f3f5f8; color:#34415e; } .page-settings textarea { min-height:85px; resize:vertical; } .page-settings .close-settings { float:right; border:0; background:transparent; color:#7f8eaa; font-size:18px; } .form-row { display:flex; justify-content:space-between; align-items:center; } .page-settings .switch { width:38px; height:20px; accent-color:#80b4dc; }
        .image-import { display:flex; gap:8px; margin-top:8px; } .image-import button { flex:0 0 auto; border:1px solid var(--border); border-radius:4px; background:#fff; color:#34415e; padding:8px 10px; cursor:pointer; } .image-import span { align-self:center; color:var(--muted); font-size:12px; }
        .page-settings { position:fixed; z-index:20; top:72px; left:380px; width:400px; max-height:calc(100vh - 90px); overflow:auto; padding:18px; background:#fff; border-radius:8px; box-shadow:0 14px 40px rgba(26,39,68,.22); } .page-settings[hidden] { display:none; } .page-settings h2 { margin:0 -18px 16px; padding:0 18px 16px; border-bottom:1px solid var(--border); text-align:center; font-size:15px; } .page-settings label { display:block; margin:14px 0 6px; color:#414d6b; font-size:13px; } .page-settings input:not([type="checkbox"]),.page-settings textarea { width:100%; padding:10px; border:0; border-radius:4px; background:#f3f5f8; color:#34415e; } .page-settings textarea { min-height:85px; resize:vertical; } .page-settings .close-settings { float:right; border:0; background:transparent; color:#7f8eaa; font-size:18px; } .form-row { display:flex; justify-content:space-between; align-items:center; } .page-settings .switch { width:38px; height:20px; accent-color:#80b4dc; }
        .code-settings { position:fixed; z-index:30; top:72px; left:380px; width:400px; background:#fff; border-radius:8px; box-shadow:0 14px 40px rgba(26,39,68,.22); overflow:hidden; } .code-settings[hidden] { display:none; } .code-header { height:49px; display:flex; align-items:center; justify-content:center; border-bottom:1px solid var(--border); text-transform:uppercase; letter-spacing:.5px; } .code-header button { position:absolute; left:0; width:50px; height:49px; border:0; background:transparent; color:#929fb7; font-size:32px; line-height:1; } .code-body { padding:12px; } .code-body label { display:block; margin-bottom:8px; color:#414d6b; font-size:13px; } .code-body textarea { width:100%; min-height:180px; padding:10px; border:1px solid var(--border); border-radius:4px; resize:vertical; font-family:monospace; } .code-footer { padding:12px; border-top:1px solid var(--border); } .code-footer button { width:100%; border:0; padding:11px; border-radius:4px; background:#2463eb; color:#fff; font-weight:700; }
        .preview { padding:18px; min-width:0; overflow:auto; } .preview-header { min-height:46px; display:flex; justify-content:space-between; align-items:center; gap:12px; padding:5px 8px 5px 12px; margin-bottom:12px; border:1px solid var(--border); border-radius:7px; background:#fff; font-size:13px; } .preview-actions { display:flex; align-items:center; gap:10px; } .preview-actions [role="status"] { color:var(--muted); } .save-action,.restore-action { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:38px; padding:0 15px; border:1px solid transparent; border-radius:6px; font:700 13px 'Barlow',serif; cursor:pointer; transition:background .16s ease,box-shadow .16s ease,transform .16s ease; } .save-action { background:var(--blue); color:#fff; box-shadow:0 3px 8px rgba(36,99,235,.2); } .save-action:hover { background:#174fc9; box-shadow:0 5px 12px rgba(36,99,235,.25); transform:translateY(-1px); } .restore-action { border-color:var(--border); background:#fff; color:#53617b; } .restore-action:hover { background:#f3f5f8; color:var(--ink); } .save-action:disabled,.restore-action:disabled { opacity:.65; cursor:wait; transform:none; } .preview-frame { height:calc(100% - 58px); overflow:hidden; background:#fff; border:1px solid var(--border); border-radius:7px; } iframe { width:100%; height:100%; border:0; background:#fff; }
        .editor-save-button { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:38px; padding:0 14px; border:1px solid #2463eb; border-radius:6px; background:#2463eb; color:#fff; box-shadow:0 3px 8px rgba(36,99,235,.2); font:700 13px 'Barlow',Arial,sans-serif; cursor:pointer; transition:background .16s ease,box-shadow .16s ease,transform .16s ease; }
        .editor-save-button:hover { background:#174fc9; color:#fff; box-shadow:0 5px 12px rgba(36,99,235,.25); transform:translateY(-1px); }
        .editor-save-button:disabled { opacity:.65; cursor:wait; transform:none; }
        .editor-save-button > i { display:inline-grid; flex:0 0 14px; width:14px; height:14px; place-items:center; color:#fff !important; font-size:14px; }
        .editor-save-button:focus-visible { outline:3px solid rgba(36,99,235,.25); outline-offset:2px; }
        @media(max-width:768px) { .editor{grid-template-columns:66px minmax(0,1fr)} .panel{display:none}.rail a,.rail button{width:52px} }
    </style>
</head>
<body>
<main class="editor">
    <nav class="rail" aria-label="Công cụ chỉnh sửa">
        <a href="{{ route('admin.settings.theme') }}" title="Quay lại"><i class="fa-solid fa-arrow-left"></i></a>
        <button class="active" type="button" data-editor-tab="pages"><i class="fa-solid fa-file-lines"></i><span>Trang</span></button>
        <button type="button" data-editor-tab="blocks"><i class="fa-solid fa-layer-group"></i><span>Khối</span></button>
        <button type="button" data-editor-tab="styles"><i class="fa-solid fa-sliders"></i><span>Kiểu</span></button>
        <button type="button" data-editor-tab="language"><i class="fa-solid fa-language"></i><span>Ngôn ngữ</span></button>
    </nav>
    <aside class="panel">
        <input class="editor-search" type="search" placeholder="Tìm kiếm">
        <section class="editor-tab-content" data-tab-content="pages">
            <h1 data-lang="">Trang</h1>
            <div class="page-list">
                @foreach ($pages as $pageKey => $pageLabel)
                    <button class="page-item {{ $pageKey === $page ? 'active' : '' }}" type="button"
                        data-auth-page="{{ $pageKey }}">
                        <span data-lang="">{{ $pageLabel }}</span>
                        @if ($pageKey === $page)<i class="fa-solid fa-gear"></i>@endif
                    </button>
                @endforeach
            </div>
            <div class="helper">Mỗi trang được lưu riêng theo tên miền và giao diện đăng nhập.</div>
        </section>
        <section class="editor-tab-content" data-tab-content="blocks" hidden>
            <h1>Khối trang</h1>
            <p>Kéo và thả các khối để thay đổi thứ tự hiển thị. Không chỉnh sửa mã HTML.</p>
            <div id="block-list" class="block-list">
            <button class="block-item" draggable="true" data-block="title" type="button"><i class="fa-solid fa-grip-vertical handle"></i>Tiêu đề</button>
            <button class="block-item" draggable="true" data-block="description" type="button"><i class="fa-solid fa-grip-vertical handle"></i>Mô tả</button>
            <button class="block-item" draggable="true" data-block="image" type="button"><i class="fa-solid fa-grip-vertical handle"></i>Hình ảnh</button>
            <button class="block-item" draggable="true" data-block="form" type="button"><i class="fa-solid fa-grip-vertical handle"></i>Biểu mẫu đăng nhập</button>
            </div>
            <div class="helper" id="block-order-notice"><strong>Mẹo:</strong> thay đổi được xem ngay ở bên phải. Liên kết và biểu mẫu trong bản xem trước bị khóa để không chuyển trang.</div>
        </section>
        <section class="editor-tab-content" data-tab-content="styles" hidden>
            <h1>Nội dung và giao diện</h1>
            <div class="editor-field">
                <label for="editor-title">Tiêu đề</label>
                <textarea id="editor-title" rows="2"></textarea>
            </div>
            <div class="editor-field">
                <label for="editor-description">Mô tả</label>
                <textarea id="editor-description" rows="3"></textarea>
            </div>
            <div class="editor-field">
                <label for="editor-background">Ảnh nền (URL)</label>
                <input id="editor-background" type="url" placeholder="https://...">
            </div>
            <div class="editor-field">
                <label>Ảnh minh họa</label>
                <input id="editor-image" type="hidden">
                <div class="image-import">
                    <button type="button" id="import-theme-image"><i class="fa-solid fa-upload me-1"></i>Chọn ảnh từ máy</button>
                    <input type="file" id="theme-image-file" accept="image/png,image/jpeg,image/webp,image/gif,image/avif" hidden>
                </div>
                <div id="image-upload-status" class="mt-2 text-muted fs-8" role="status">Ảnh được lưu cùng giao diện sau khi bấm Lưu thay đổi.</div>
            </div>
            <div class="editor-field">
                <label for="editor-background-color">Màu nền</label>
                <input id="editor-background-color" type="color" value="#ffffff">
            </div>
            <div class="editor-field">
                <label for="editor-text-color">Màu chữ</label>
                <input id="editor-text-color" type="color" value="#202b48">
            </div>
            <div class="editor-field">
                <label for="editor-accent-color">Màu nhấn</label>
                <input id="editor-accent-color" type="color" value="#2463eb">
            </div>
            <div class="editor-field">
                <label for="editor-font">Phông chữ</label>
                <select id="editor-font">
                    <option>Inter</option>
                    <option>Arial</option>
                    <option>Georgia</option>
                    <option>Roboto</option>
                    <option>system-ui</option>
                </select>
            </div>
        </section>
        <section class="editor-tab-content" data-tab-content="language" hidden>
            <h1>Ngôn ngữ</h1><p>Chọn ngôn ngữ nội dung hiển thị trong bản xem trước.</p>
            <div id="language-list">
                @foreach (($languages ?? collect()) as $language)
                    <button class="language-item" type="button" data-language-code="{{ $language->code }}">
                        <span><i class="fi {{ $language->flag }} me-2"></i>{{ $language->name }}</span>
                        <i class="fa-solid fa-pen-to-square language-edit" title="Chỉnh sửa"></i>
                    </button>
                @endforeach
            </div>
            <div class="translation-editor" id="translation-editor" hidden>
                <div class="translation-header"><strong id="translation-language">ENGLISH</strong><input id="translation-search" type="search" placeholder="Tìm bản dịch..."></div>
                <div class="translation-body"><nav id="translation-groups"></nav><div id="translation-fields"></div></div>
                <button id="save-translations" class="translation-save" type="button">LƯU THAY ĐỔI</button>
            </div>
        </section>
    </aside>
    <section class="page-settings" id="page-settings" hidden>
        <button class="close-settings" type="button" aria-label="Đóng">&times;</button>
        <h2>CÀI ĐẶT TRANG</h2>
        <label for="seo-title-input">Tiêu đề trình duyệt</label>
        <input id="seo-title-input" maxlength="255">
        <label for="seo-description-input">Mô tả tìm kiếm</label>
        <textarea id="seo-description-input" maxlength="500"></textarea>
        <div class="seo-preview">
            <div class="seo-title" id="seo-title-preview">Đăng nhập</div>
            <div class="seo-url">{{ url('/signin') }}</div>
            <div class="seo-description" id="seo-description-preview"></div>
        </div>
        <button type="button" class="save-page-settings">Lưu thay đổi</button>
    </section>
    <section class="preview">
        <div class="preview-header">
            <span>Đang chỉnh sửa: <strong>{{ $theme }}</strong></span>
            <div class="preview-actions">
                <span id="save-status" role="status" aria-live="polite"></span>
                <button class="restore-action" id="restore-theme" type="button" title="Khôi phục giao diện gốc">
                    <i class="fa-solid fa-rotate-left" aria-hidden="true"></i><span>Khôi phục gốc</span>
                </button>
                <button type="button" class="editor-save-button" id="save-theme">
                    <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i><span>Lưu thay đổi</span>
                </button>
            </div>
        </div>
        <div class="preview-frame"><iframe id="signin-preview" title="Xem trước giao diện đăng nhập"></iframe></div>
    </section>
</main>
<script src="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/admin/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/admin/language.js') }}?v={{ filemtime(public_path('assets/admin/language.js')) }}"></script>
<script>
    const languageCode = String(document.documentElement.lang || 'en').toLowerCase().split('-')[0];
    const languageCatalog = languageCode === 'vi' ? LANGUAGE.language : LANGUAGE.core;
    LANGUAGE.language = languageCatalog;
    window.applyAdminTranslations = function (root) {
        (root || document).querySelectorAll('[data-lang]').forEach(element => {
            const key = element.getAttribute('data-lang') || element.innerText.trim();
            const parts = key.includes('::') ? key.split('::') : [];
            const group = parts.length > 1 ? parts[0] : '/settings';
            const lookupKey = parts.length > 1 ? parts.slice(1).join('::') : key;
            const value = languageCatalog?.[group]?.[key]
                || languageCatalog?.[group]?.[lookupKey]
                || LANGUAGE.core?.[group]?.[key]
                || LANGUAGE.core?.[group]?.[lookupKey]
                || key;

            if (element.matches('input, textarea')) {
                if (element.hasAttribute('value')) element.value = value;
                else if (element.hasAttribute('placeholder')) element.placeholder = value;
            } else {
                element.innerHTML = value;
            }
        });
    };
    document.querySelectorAll([
        '.rail [data-editor-tab] > span',
        '.panel h1',
        '.panel p',
        '.page-item > span',
        '.editor-field label',
        '#image-upload-status',
        '.translation-save',
        '.page-settings h2',
        '.page-settings label',
        '.save-page-settings',
        '#save-theme span'
    ].join(',')).forEach(element => {
        if (!element.hasAttribute('data-lang')) element.setAttribute('data-lang', '');
    });
    document.querySelectorAll('.editor-search, #translation-search').forEach(element => {
        element.setAttribute('data-lang', 'Search...');
    });
    window.applyAdminTranslations();
    if (window.jQuery) {
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
    }
</script>
<script src="{{ asset('assets/app.js') }}?v={{ config('app.version') }}"></script>
<script>
(() => {
    document.querySelectorAll('[data-editor-tab]').forEach(button => button.addEventListener('click', () => {
        const tab = button.dataset.editorTab;
        document.querySelectorAll('.rail [data-editor-tab]').forEach(item => item.classList.toggle('active', item === button));
        document.querySelectorAll('[data-tab-content]').forEach(panel => { panel.hidden = panel.dataset.tabContent !== tab; });
    }));
    const list = document.getElementById('block-list');
    let dragging = null;
    const frame = document.getElementById('signin-preview');
    let savedCustomize = @json($customize ?? []);
    let currentPage = @json($page);
    const pages = @json($pages);
    // Assign srcdoc from a JSON string instead of putting escaped HTML in an
    // attribute. This keeps the preview as a rendered page, not source text.
    frame.srcdoc = @json($previewHtml);
    const settingsPanel = document.getElementById('page-settings');
    const saveStatus = document.getElementById('save-status');
    document.querySelector('.page-list').addEventListener('click', async event => {
        const button = event.target.closest('[data-auth-page]');
        if (!button || button.dataset.authPage === currentPage) {
            if (event.target.closest('.fa-gear')) {
                event.stopPropagation();
                settingsPanel.hidden = false;
            }
            return;
        }

        const nextPage = button.dataset.authPage;
        if (!await saveTheme(false)) return;
        saveStatus.textContent = 'Đang tải trang...';
        try {
            const result = await app.ajax('Setting-loadSignInHTML', {
                theme: @json($theme),
                page: nextPage
            }, false);
            if (result?.error || !result?.success) {
                throw new Error(result?.error || 'Không thể tải trang giao diện.');
            }
            currentPage = nextPage;
            savedCustomize = result.page_customize || {};
            seoTitle.value = savedCustomize.seo_title || '';
            seoDescription.value = savedCustomize.seo_description || '';
            savedLayout = Array.isArray(savedCustomize.layout) ? savedCustomize.layout : [];
            layoutInitialized = false;
            document.querySelectorAll('.page-item').forEach(item => {
                const active = item.dataset.authPage === currentPage;
                item.classList.toggle('active', active);
                item.querySelector('i')?.remove();
                if (active) item.insertAdjacentHTML('beforeend', '<i class="fa-solid fa-gear"></i>');
            });
            document.querySelector('[data-tab-content="blocks"] h1').textContent = 'Khối trang ' + (pages[currentPage] || '');
            document.getElementById('seo-title-preview').textContent = savedCustomize.seo_title || pages[currentPage];
            frame.srcdoc = result.success;
            saveStatus.textContent = '';
        } catch (error) {
            saveStatus.textContent = 'Không tải được trang';
            await app.alert(error?.message || 'Không thể tải trang giao diện.', 'danger');
        }
    });
    settingsPanel.querySelector('.close-settings').addEventListener('click', () => { settingsPanel.hidden = true; });
    const seoTitle = document.getElementById('seo-title-input');
    const seoDescription = document.getElementById('seo-description-input');
    const seoTitlePreview = document.getElementById('seo-title-preview');
    const seoDescriptionPreview = document.getElementById('seo-description-preview');
    seoTitle.value = savedCustomize.seo_title || '';
    seoDescription.value = savedCustomize.seo_description || '';
    seoTitlePreview.textContent = seoTitle.value || pages[currentPage] || 'Đăng nhập';
    seoDescriptionPreview.textContent = seoDescription.value;
    seoTitle.addEventListener('input', () => { seoTitlePreview.textContent = seoTitle.value || pages[currentPage] || 'Đăng nhập'; });
    seoDescription.addEventListener('input', () => { seoDescriptionPreview.textContent = seoDescription.value; });
    settingsPanel.querySelector('.save-page-settings').addEventListener('click', async () => {
        if (await saveTheme()) settingsPanel.hidden = true;
    });
    const languageData = {};
    const languageList = document.getElementById('language-list');
    const languageEditor = document.getElementById('translation-editor');
    const languageGroups = document.getElementById('translation-groups');
    const languageFields = document.getElementById('translation-fields');
    const translationSearch = document.getElementById('translation-search');
    let selectedLanguage = null;
    let selectedGroup = null;
    let languageSources = {};
    function renderGroups() {
        const data = languageSources[selectedLanguage] || {}; const groups = Object.keys(data).filter(key => data[key] && typeof data[key] === 'object'); selectedGroup = selectedGroup && groups.includes(selectedGroup) ? selectedGroup : groups[0];
        languageGroups.innerHTML = groups.map(group => `<button type="button" class="${group === selectedGroup ? 'active' : ''}" data-group="${group}">${group}</button>`).join('');
        languageGroups.querySelectorAll('button').forEach(button => button.addEventListener('click', () => { selectedGroup = button.dataset.group; renderGroups(); })); renderFields();
    }
    function renderFields() {
        const entries = Object.entries((languageSources[selectedLanguage] || {})[selectedGroup] || {}); const query = translationSearch.value.toLowerCase(); languageFields.innerHTML = entries.filter(([key, value]) => `${key} ${value}`.toLowerCase().includes(query)).map(([key, value]) => `<div class="translation-field"><label>${key}</label><textarea data-key="${key}">${String(value ?? '')}</textarea></div>`).join('');
    }
    translationSearch.addEventListener('input', renderFields);
    languageList.querySelectorAll('.language-item').forEach(button => button.addEventListener('click', async (event) => {
        const code = button.dataset.languageCode;
        document.querySelectorAll('.language-item').forEach(item => item.classList.remove('active'));
        button.classList.add('active');
        if (!event.target.closest('.language-edit')) return;
        const response = await fetch('{{ url('/admin/settings/language/load') }}/' + encodeURIComponent(code), { headers: { 'Accept': 'application/json' } });
        const payload = await response.json();
        if (!payload.success) return alert(payload.error || 'Không thể tải dữ liệu ngôn ngữ.');
        selectedLanguage = code;
        languageSources = { [code]: payload[code] || payload.core || {} };
        languageEditor.hidden = false;
        document.getElementById('translation-language').textContent = code.toUpperCase();
        renderGroups();
    }));
    document.getElementById('save-translations').addEventListener('click', async () => {
        languageFields.querySelectorAll('textarea').forEach(field => { languageSources[selectedLanguage][selectedGroup][field.dataset.key] = field.value; });
        const selectedButton = document.querySelector('.language-item.active');
        const response = await fetch('{{ route('admin.settings.language.save') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: JSON.stringify({ code: selectedLanguage, name: selectedButton?.innerText?.trim() || selectedLanguage, flag: selectedButton?.querySelector('.fi')?.className || '', data: languageSources[selectedLanguage] })
        });
        const result = await response.json();
        alert(result.success || result.error || 'Không thể lưu bản dịch.');
    });
    const blockSelectors = { title: '.block-signin-text__block-text-title h1,.block-signin__title,h1', description: '.block-signin__description,.block-signin-text__block-text-description,h1 + p,.auth-description', image: '[data-auth-theme-image],.cmz-background1,img.background1,.block-signin-text img,.block-signin__content img', form: 'form' };
    const order = () => [...list.querySelectorAll('.block-item')].map(item => item.dataset.block);
    let savedLayout = Array.isArray(savedCustomize.layout) ? savedCustomize.layout : [];
    const blockOrderNotice = document.getElementById('block-order-notice');
    let supportsBlockOrder = false;
    let layoutInitialized = false;
    function applyOrder() {
        const doc = frame.contentDocument;
        if (!doc) return;
        const elements = Object.fromEntries(Object.entries(blockSelectors).map(([key, selector]) => [key, doc.querySelector(selector)]));
        const items = Object.values(elements);
        const parent = items.every(Boolean) && items.every(element => element.parentElement === items[0].parentElement)
            ? items[0].parentElement
            : null;
        supportsBlockOrder = Boolean(parent);
        list.querySelectorAll('.block-item').forEach(item => { item.draggable = supportsBlockOrder; });
        blockOrderNotice.textContent = supportsBlockOrder
            ? 'Kéo các khối để sắp xếp lại. Liên kết và biểu mẫu trong bản xem trước bị khóa.'
            : 'Giao diện này giữ cố định vị trí khối để bảo toàn bố cục.';
        if (!parent) return;
        if (!layoutInitialized) {
            savedLayout.concat(order()).forEach(key => {
                const item = list.querySelector(`[data-block="${key}"]`);
                if (item) list.appendChild(item);
            });
            layoutInitialized = true;
        }
        order().forEach(key => { if (elements[key]) parent.appendChild(elements[key]); });
    }
    list.addEventListener('dragstart', event => { dragging = event.target.closest('.block-item'); if (dragging) dragging.classList.add('dragging'); });
    list.addEventListener('dragend', () => { dragging?.classList.remove('dragging'); dragging = null; applyOrder(); });
    list.addEventListener('dragover', event => { event.preventDefault(); const target = event.target.closest('.block-item'); if (!dragging || !target || target === dragging) return; const rect = target.getBoundingClientRect(); list.insertBefore(dragging, event.clientY < rect.top + rect.height / 2 ? target : target.nextSibling); });
    const editorFields = {
        title: document.getElementById('editor-title'),
        description: document.getElementById('editor-description'),
        background: document.getElementById('editor-background'),
        image: document.getElementById('editor-image'),
        backgroundColor: document.getElementById('editor-background-color'),
        textColor: document.getElementById('editor-text-color'),
        accentColor: document.getElementById('editor-accent-color'),
        font: document.getElementById('editor-font')
    };
    const imageFileInput = document.getElementById('theme-image-file');
    const imageUploadStatus = document.getElementById('image-upload-status');
    let pendingImageFile = null;
    let pendingImagePreviewUrl = null;
    document.getElementById('import-theme-image').addEventListener('click', () => imageFileInput.click());
    imageFileInput.addEventListener('change', async () => {
        const file = imageFileInput.files?.[0];
        if (!file) return;
        pendingImageFile = file;
        if (pendingImagePreviewUrl) URL.revokeObjectURL(pendingImagePreviewUrl);
        pendingImagePreviewUrl = URL.createObjectURL(file);
        editorFields.image.value = pendingImagePreviewUrl;
        updatePreview();
        imageUploadStatus.textContent = file.name + ' · Xem trước tạm thời, ảnh sẽ được lưu khi bấm Lưu thay đổi.';
        imageFileInput.value = '';
    });
    const colorToHex = color => {
        const values = String(color || '').match(/\d+/g);
        if (values && values.length > 3 && Number(values[3]) === 0) return '';
        return values && values.length >= 3
            ? '#' + values.slice(0, 3).map(value => Number(value).toString(16).padStart(2, '0')).join('')
            : '';
    };
    function syncEditorFields() {
        const doc = frame.contentDocument;
        if (!doc) return;
        const hiddenValue = selector => doc.querySelector(selector)?.value || '';
        const styles = savedCustomize.styles || {};
        seoTitle.value = savedCustomize.seo_title || doc.title || pages[currentPage] || '';
        seoDescription.value = savedCustomize.seo_description
            || doc.querySelector('meta[name="description"]')?.content
            || '';
        seoTitlePreview.textContent = seoTitle.value;
        seoDescriptionPreview.textContent = seoDescription.value;
        editorFields.title.value = hiddenValue('.title') || doc.querySelector(blockSelectors.title)?.textContent?.trim() || '';
        editorFields.description.value = hiddenValue('.description') || doc.querySelector(blockSelectors.description)?.textContent?.trim() || '';
        editorFields.background.value = hiddenValue('.background');
        editorFields.image.value = hiddenValue('.background1');
        editorFields.backgroundColor.value = styles.background_color || colorToHex(doc.defaultView.getComputedStyle(doc.body).backgroundColor) || '#ffffff';
        editorFields.textColor.value = styles.text_color || colorToHex(doc.defaultView.getComputedStyle(doc.body).color) || '#202b48';
        editorFields.accentColor.value = styles.accent_color || '#2463eb';
        editorFields.font.value = styles.font_family
            || doc.defaultView.getComputedStyle(doc.body).fontFamily.split(',')[0].replace(/["']/g, '')
            || 'Inter';
        applyOrder();
    }
    function updatePreview() {
        const doc = frame.contentDocument;
        if (!doc) return;
        const value = field => field.value.trim();
        const title = doc.querySelector(blockSelectors.title);
        const description = doc.querySelector(blockSelectors.description);
        const image = doc.querySelector(blockSelectors.image);
        const imageContainer = image ? null : doc.querySelector('.block-signin-text,.block-signin__content,.bgi-size-cover');
        const hidden = selector => doc.querySelector(selector);
        if (title) title.textContent = value(editorFields.title);
        if (description) description.textContent = value(editorFields.description);
        if (image && value(editorFields.image)) image.src = value(editorFields.image);
        if (imageContainer && value(editorFields.image)) {
            imageContainer.style.backgroundImage = `url(${JSON.stringify(value(editorFields.image))})`;
            imageContainer.style.backgroundSize = 'cover';
            imageContainer.style.backgroundPosition = 'center';
        }
        const backgroundUrl = value(editorFields.background);
        doc.body.style.backgroundImage = backgroundUrl
            ? `url(${JSON.stringify(backgroundUrl)})`
            : '';
        const hiddenImage = doc.querySelector('.background1');
        if (hiddenImage) hiddenImage.value = value(editorFields.image);
        doc.body.style.backgroundColor = value(editorFields.backgroundColor);
        doc.body.style.color = value(editorFields.textColor);
        doc.body.style.fontFamily = value(editorFields.font);
        doc.documentElement.style.setProperty('--signin-accent', value(editorFields.accentColor));
        let accentStyle = doc.getElementById('customizer-accent-style');
        if (!accentStyle) {
            accentStyle = doc.createElement('style');
            accentStyle.id = 'customizer-accent-style';
            doc.head.appendChild(accentStyle);
        }
        accentStyle.textContent = '.btn-primary,button[type="submit"],input[type="submit"]{background-color:' + value(editorFields.accentColor) + '!important;border-color:' + value(editorFields.accentColor) + '!important}';
        if (hidden('.title')) hidden('.title').value = value(editorFields.title);
        if (hidden('.description')) hidden('.description').value = value(editorFields.description);
        if (hidden('.background')) hidden('.background').value = value(editorFields.background);
        if (hidden('.background1')) hidden('.background1').value = value(editorFields.image);
        const meta = doc.querySelector('meta[name="description"]');
        if (meta) meta.content = value(seoDescription);
        doc.title = value(seoTitle) || doc.title;
        seoTitlePreview.textContent = value(seoTitle) || 'Đăng nhập';
        seoDescriptionPreview.textContent = value(seoDescription);
    }
    Object.values(editorFields).forEach(field => {
        field.addEventListener('input', updatePreview);
        field.addEventListener('change', updatePreview);
    });
    seoTitle.addEventListener('input', updatePreview);
    seoDescription.addEventListener('input', updatePreview);
    frame.addEventListener('load', () => {
        syncEditorFields();
        const doc = frame.contentDocument;
        const previewImage = doc.querySelector(blockSelectors.image);
        if (previewImage) {
            previewImage.style.cursor = 'pointer';
            previewImage.title = 'Chọn ảnh từ máy tính';
            previewImage.addEventListener('click', event => {
                event.preventDefault();
                event.stopPropagation();
                imageFileInput.click();
            });
        }
        const title = doc.querySelector(blockSelectors.title);
        const description = doc.querySelector(blockSelectors.description);
        title?.addEventListener('input', () => { editorFields.title.value = title.textContent.trim(); });
        description?.addEventListener('input', () => { editorFields.description.value = description.textContent.trim(); });
        doc.querySelector('.background')?.addEventListener('input', event => { editorFields.background.value = event.target.value; });
        doc.querySelector('.background1')?.addEventListener('input', event => { editorFields.image.value = event.target.value; });
    });
    async function saveTheme(showFeedback = true) {
        if (!frame.contentDocument) return false;
        const customize = {
            background: editorFields.background.value.trim(),
            background1: editorFields.image.value.trim(),
            title: editorFields.title.value.trim(),
            description: editorFields.description.value.trim(),
            seo_title: seoTitle.value.trim(),
            seo_description: seoDescription.value.trim(),
            styles: {
                background_color: editorFields.backgroundColor.value,
                text_color: editorFields.textColor.value,
                accent_color: editorFields.accentColor.value,
                font_family: editorFields.font.value
            },
            layout: supportsBlockOrder ? order() : savedLayout
        };
        const saveButton = document.getElementById('save-theme');
        const saveLabel = saveButton.querySelector('span');
        saveButton.disabled = true;
        if (showFeedback) saveLabel.textContent = 'Đang lưu...';
        saveStatus.textContent = showFeedback ? '' : 'Đang lưu trang...';
        try {
            const formData = new FormData();
            formData.append('theme', @json($theme));
            formData.append('page', currentPage);
            formData.append('customize', JSON.stringify(customize));
            if (pendingImageFile) {
                formData.append('image', pendingImageFile);
            }
            const response = await fetch(@json(route('admin.settings.theme.editor.save')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const result = await response.json();
            if (!response.ok || !result?.success) {
                throw new Error(result?.error || 'Không thể lưu giao diện đăng nhập.');
            }
            if (result.image_url) {
                editorFields.image.value = result.image_url;
                pendingImageFile = null;
                if (pendingImagePreviewUrl) URL.revokeObjectURL(pendingImagePreviewUrl);
                pendingImagePreviewUrl = null;
                updatePreview();
                imageUploadStatus.textContent = 'Ảnh đã lưu trong public/images/auth.';
            }
            saveStatus.textContent = '';
            if (showFeedback) await app.alert(result.success, 'success');
            return true;
        } catch (error) {
            const message = error?.error?.error || error?.error?.message || error?.message || 'Không thể kết nối để lưu thay đổi.';
            saveStatus.textContent = 'Lưu thất bại';
            if (showFeedback) await app.alert(message, 'danger');
            return false;
        } finally {
            saveButton.disabled = false;
            if (showFeedback) saveLabel.textContent = 'Lưu thay đổi';
        }
    }
    document.getElementById('save-theme').addEventListener('click', saveTheme);
    document.getElementById('restore-theme').addEventListener('click', async event => {
        try {
            await app.confirm('Khôi phục trang này về giao diện đăng nhập gốc?');
        } catch {
            return;
        }

        const button = event.currentTarget;
        button.disabled = true;
        try {
            const response = await fetch(@json(route('admin.settings.theme.editor.reset')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ theme: @json($theme), page: currentPage })
            });
            const result = await response.json();
            if (!response.ok || result.error) throw new Error(result.error || 'Không thể khôi phục giao diện.');

            const loaded = await app.ajax('Setting-loadSignInHTML', {
                theme: @json($theme),
                page: currentPage
            }, false);
            if (loaded?.error || !loaded?.success) throw new Error(loaded?.error || 'Không thể tải lại giao diện gốc.');

            savedCustomize = loaded.page_customize || {};
            savedLayout = Array.isArray(savedCustomize.layout) ? savedCustomize.layout : [];
            layoutInitialized = false;
            pendingImageFile = null;
            if (pendingImagePreviewUrl) URL.revokeObjectURL(pendingImagePreviewUrl);
            pendingImagePreviewUrl = null;
            seoTitle.value = savedCustomize.seo_title || '';
            seoDescription.value = savedCustomize.seo_description || '';
            frame.srcdoc = loaded.success;
            await app.alert(result.success || 'Đã khôi phục giao diện gốc.', 'success');
        } catch (error) {
            await app.alert(error?.message || 'Không thể khôi phục giao diện.', 'danger');
        } finally {
            button.disabled = false;
        }
    });
})();
</script>
</body>
</html>
