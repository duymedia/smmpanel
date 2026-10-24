<!doctype html>
<html lang="{{ Auth::user()?->lang ?? 'vi' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chỉnh sửa giao diện người dùng</title>
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/admin/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/libs/font-awesome/6.7.2/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --blue:#2463eb; --border:#e4e8f0; --muted:#8190ad; --ink:#202b48; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:#eef2f8; font:14px 'Barlow',Arial,sans-serif; }
        .theme-editor { height:100vh; display:grid; grid-template-rows:56px minmax(0,1fr); }
        .editor-header { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:0 18px; background:#fff; border-bottom:1px solid var(--border); }
        .editor-heading,.header-actions { display:flex; align-items:center; gap:10px; }
        .editor-heading a { display:grid; place-items:center; width:34px; height:34px; border-radius:5px; background:#f3f5f8; color:#53617b; text-decoration:none; }
        .editor-heading h1 { margin:0; font-size:15px; font-weight:700; }
        .editor-heading span { color:var(--muted); font-size:12px; }
        .header-actions { display:flex; align-items:center; gap:9px; }
        .editor-save-button,.editor-reset-button { min-height:38px; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:0 14px; border:1px solid transparent; border-radius:6px; font:700 13px 'Barlow',Arial,sans-serif; cursor:pointer; transition:background .16s ease,box-shadow .16s ease,transform .16s ease; }
        .editor-save-button { border-color:#2463eb; background:#2463eb; color:#fff; box-shadow:0 3px 8px rgba(36,99,235,.2); }
        .editor-save-button:hover { background:#174fc9; box-shadow:0 5px 12px rgba(36,99,235,.25); transform:translateY(-1px); }
        .editor-save-button > i { display:inline-grid; flex:0 0 14px; width:14px; height:14px; place-items:center; font-size:14px; }
        .editor-reset-button { border-color:var(--border); background:#fff; color:#53617b; }
        .editor-reset-button:hover { background:#f3f5f8; color:var(--ink); }
        .editor-save-button:disabled,.editor-reset-button:disabled { opacity:.65; cursor:wait; transform:none; }
        .editor-main { min-height:0; display:grid; grid-template-columns:260px minmax(0,1fr) minmax(360px,1fr); }
        .file-panel { min-height:0; overflow:auto; padding:22px 14px; background:#fff; border-right:1px solid var(--border); }
        .file-panel h2 { margin:0 4px 6px; font-size:17px; }
        .file-panel p { margin:0 4px 18px; color:var(--muted); font-size:13px; }
        .file-list { border-top:1px solid var(--border); }
        .folder-toggle { display:flex; align-items:center; justify-content:space-between; gap:8px; width:100%; padding:11px 9px; border:0; border-bottom:1px solid var(--border); background:#f7f9fc; color:#34415e; text-align:left; font:600 13px 'Barlow',Arial,sans-serif; cursor:pointer; }
        .folder-toggle:hover,.folder-toggle[aria-expanded="true"] { color:var(--blue); background:#edf3ff; }
        .folder-name { display:flex; align-items:center; gap:9px; min-width:0; }
        .folder-name span { overflow:hidden; text-overflow:ellipsis; }
        .folder-count { margin-left:auto; color:var(--muted); font:11px 'Barlow',Arial,sans-serif; }
        .folder-content[hidden] { display:none; }
        .folder-content { padding-left:10px; border-bottom:1px solid var(--border); }
        .file-item { display:flex; align-items:center; gap:9px; width:100%; padding:9px 9px; border:0; border-bottom:1px solid #edf0f5; background:#fff; color:#34415e; text-align:left; font:13px 'Barlow',Arial,sans-serif; overflow-wrap:anywhere; cursor:pointer; }
        .file-item i { flex:0 0 16px; color:#8190ad; }
        .file-item:hover,.file-item.active { background:#edf3ff; color:var(--blue); }
        .source-panel { min-width:0; min-height:0; display:grid; grid-template-rows:42px minmax(0,1fr); gap:8px; padding:12px; }
        .source-title { display:flex; align-items:center; min-width:0; padding:0 12px; border:1px solid var(--border); border-radius:5px; background:#fff; color:#53617b; font:12px Consolas,'Courier New',monospace; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        #source-code { width:100%; height:100%; min-height:0; padding:14px; border:1px solid var(--border); border-radius:5px; outline:none; background:#fff; color:#26324b; font:13px/1.6 Consolas,'Courier New',monospace; tab-size:4; white-space:pre; overflow:auto; resize:none; }
        #source-code:focus { border-color:#9bb9ff; box-shadow:0 0 0 2px rgba(36,99,235,.08); }
        .preview-panel { min-width:0; min-height:0; display:grid; grid-template-rows:42px minmax(0,1fr); gap:8px; padding:12px 12px 12px 0; }
        .preview-title { display:flex; align-items:center; justify-content:space-between; gap:8px; padding:0 12px; border:1px solid var(--border); border-radius:5px; background:#fff; color:#53617b; font-size:12px; }
        .preview-title [role="status"] { color:var(--muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .preview-frame { min-height:0; overflow:hidden; border:1px solid var(--border); border-radius:5px; background:#fff; }
        #client-theme-preview { display:block; width:100%; height:100%; border:0; background:#fff; }
        @media(max-width:760px) {
            .editor-main { grid-template-columns:150px minmax(0,1fr); grid-template-rows:minmax(300px,1fr) minmax(320px,1fr); overflow:auto; }
            .file-panel { padding:16px 8px; }
            .source-panel { padding:8px; }
            #source-code { font-size:12px; }
            .editor-heading h1 { font-size:13px; }
            .editor-heading span { display:none; }
            .preview-panel { grid-column:1 / -1; padding:0 8px 8px; }
        }
    </style>
</head>
<body>
<main class="theme-editor">
    <header class="editor-header">
        <div class="editor-heading">
            <a href="{{ route('admin.settings.theme') }}" title="Quay lại"><i class="fa-solid fa-arrow-left"></i></a>
            <h1>Chỉnh sửa giao diện người dùng <span>#{{ $theme === 'default' ? 'Default' : $theme }}</span></h1>
        </div>
        <div class="header-actions">
            <button type="button" class="editor-reset-button" id="restore-source" title="Khôi phục giao diện gốc">
                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i><span>Khôi phục gốc</span>
            </button>
            <button type="button" class="editor-save-button" id="save-source">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i><span>Lưu thay đổi</span>
            </button>
        </div>
    </header>
    <div class="editor-main">
        <aside class="file-panel">
            <h2>Source files</h2>
            <p>{{ count($files) }} tệp trong giao diện đang áp dụng</p>
            <nav class="file-list" aria-label="Tệp giao diện">
                @foreach ($fileGroups as $folder => $groupFiles)
                    @php
                        $folderId = 'theme-files-' . $loop->index;
                        $folderOpen = $groupFiles->contains($selectedFile);
                    @endphp
                    <button type="button" class="folder-toggle" aria-expanded="{{ $folderOpen ? 'true' : 'false' }}"
                        aria-controls="{{ $folderId }}">
                        <span class="folder-name">
                            <i class="fa-regular {{ $folderOpen ? 'fa-folder-open' : 'fa-folder' }}" aria-hidden="true"></i>
                            <span>{{ $folder !== '' ? $folder : 'Root' }}</span>
                        </span>
                        <span class="folder-count">{{ $groupFiles->count() }}</span>
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="folder-content" id="{{ $folderId }}" {{ $folderOpen ? '' : 'hidden' }}>
                        @foreach ($groupFiles as $file)
                            @php
                                $relativeFile = $folder !== '' ? substr($file, strlen($folder) + 1) : $file;
                                $fileLabel = str_replace(['.blade.php', '/'], ['', ' / '], $relativeFile);
                            @endphp
                            <button type="button" class="file-item {{ $file === $selectedFile ? 'active' : '' }}"
                                data-file="{{ $file }}">
                                <i class="fa-regular fa-file-code" aria-hidden="true"></i><span>{{ $fileLabel }}</span>
                            </button>
                        @endforeach
                    </div>
                @endforeach
            </nav>
        </aside>
        <section class="source-panel">
            <div class="source-title" id="source-title">{{ $selectedFile }}</div>
            <textarea id="source-code" spellcheck="false" wrap="off" aria-label="Source Blade">{{ $source }}</textarea>
        </section>
        <section class="preview-panel">
            <div class="preview-title">
                <strong>Xem trước giao diện</strong>
                <span id="preview-status" role="status" aria-live="polite"></span>
            </div>
            <div class="preview-frame">
                <iframe id="client-theme-preview" title="Xem trước giao diện người dùng"></iframe>
            </div>
        </section>
    </div>
</main>
<script src="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/app.js') }}?v={{ config('app.version') }}"></script>
@php
    $previewRoutes = [
        'new.blade.php' => route('clients.new'),
        'addfunds/index.blade.php' => route('clients.addfunds.index'),
        'account/index.blade.php' => route('clients.account.index'),
        'account/edit.blade.php' => route('clients.account.index'),
        'account/notifications.blade.php' => route('clients.notifications.index'),
        'settings/index.blade.php' => route('clients.settings.index'),
        'orders/index.blade.php' => route('clients.orders.index'),
        'orders/show.blade.php' => route('clients.orders.index'),
        'services/index.blade.php' => route('clients.services.index'),
        'products/index.blade.php' => route('clients.products.index'),
        'products/show.blade.php' => route('clients.products.index'),
        'tickets/index.blade.php' => route('clients.tickets.index'),
        'tickets/show.blade.php' => route('clients.tickets.index'),
        'refill/index.blade.php' => route('clients.refill.refill'),
        'cashflow/index.blade.php' => route('clients.cashflow.index'),
        'mass/index.blade.php' => route('clients.mass.index'),
        'affiliates/index.blade.php' => route('clients.affiliates.index'),
        'childpanel/index.blade.php' => route('clients.childpanel.index'),
        'cooperate/index.blade.php' => route('clients.cooperate.index'),
        'api/index.blade.php' => route('clients.api.index'),
    ];
@endphp
<script>
(() => {
    const editor = document.getElementById('source-code');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const saveUrl = @json(route('admin.settings.client-theme.editor.save', ['theme' => $theme]));
    const resetUrl = @json(route('admin.settings.client-theme.editor.reset', ['theme' => $theme]));
    const previewUrl = @json(route('admin.settings.client-theme.editor.preview', ['theme' => $theme]));
    const pagePreviewUrl = @json(route('clients.new'));
    const previewRoutes = @json($previewRoutes);
    const previewFrame = document.getElementById('client-theme-preview');
    const previewStatus = document.getElementById('preview-status');
    let selectedFile = @json($selectedFile);
    let dirty = false;
    let previewTimer;
    let previewRevision = 0;

    function refreshPreviewFrame() {
        const url = new URL(previewRoutes[selectedFile] || pagePreviewUrl, window.location.href);
        url.searchParams.set('_theme_preview', String(Date.now()));
        previewFrame.src = url.toString();
    }

    async function updatePreview() {
        const revision = ++previewRevision;
        previewStatus.textContent = 'Đang cập nhật...';
        try {
            const response = await fetch(previewUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ file: selectedFile, source: editor.value })
            });
            const result = await response.json();
            if (!response.ok || result.error) throw new Error(result.error || 'Không thể cập nhật preview.');
            if (revision !== previewRevision) return;

            refreshPreviewFrame();
            previewStatus.textContent = 'Đã cập nhật';
        } catch (error) {
            if (revision === previewRevision) {
                previewStatus.textContent = error?.message || 'Không thể cập nhật preview';
            }
        }
    }

    editor.addEventListener('input', () => {
        dirty = true;
        clearTimeout(previewTimer);
        previewTimer = setTimeout(updatePreview, 500);
    });

    previewFrame.src = pagePreviewUrl;
    updatePreview();

    document.querySelectorAll('.folder-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            const content = document.getElementById(button.getAttribute('aria-controls'));
            button.setAttribute('aria-expanded', String(!expanded));
            content.hidden = expanded;
            const icon = button.querySelector('.folder-name i');
            icon.classList.toggle('fa-folder-open', !expanded);
            icon.classList.toggle('fa-folder', expanded);
        });
    });

    document.querySelectorAll('.file-item').forEach(button => {
        button.addEventListener('click', async () => {
            if (button.dataset.file === selectedFile) return;
            if (dirty) {
                try {
                    await app.confirm('Bạn có thay đổi chưa lưu. Rời khỏi tệp này?');
                } catch {
                    return;
                }
            }
            const url = new URL(window.location.href);
            url.searchParams.set('file', button.dataset.file);
            window.location.href = url.toString();
        });
    });

    document.getElementById('save-source').addEventListener('click', async () => {
        try {
            const response = await fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ file: selectedFile, source: editor.value })
            });
            const result = await response.json();
            if (!response.ok || result.error) throw new Error(result.error || 'Không thể lưu source.');
            dirty = false;
            refreshPreviewFrame();
            await app.alert(result.success || 'Đã lưu source giao diện.', 'success');
        } catch (error) {
            await app.alert(error?.message || 'Không thể lưu source giao diện.', 'danger');
        }
    });

    document.getElementById('restore-source').addEventListener('click', async event => {
        try {
            await app.confirm('Khôi phục toàn bộ giao diện người dùng về bản gốc đã lưu?');
        } catch {
            return;
        }

        const button = event.currentTarget;
        button.disabled = true;
        try {
            const response = await fetch(resetUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                }
            });
            const result = await response.json();
            if (!response.ok || result.error) throw new Error(result.error || 'Không thể khôi phục giao diện.');
            await app.alert(result.success || 'Đã khôi phục giao diện gốc.', 'success');
            window.location.reload();
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
