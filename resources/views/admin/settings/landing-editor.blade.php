<!doctype html>
<html lang="{{ Auth::user()?->lang ?? 'vi' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chỉnh sửa giao diện trang chủ</title>
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/admin/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn.whoispanel.com/libs/font-awesome/6.7.2/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --blue:#2463eb; --border:#e4e8f0; --muted:#8190ad; --ink:#202b48; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: #eef2f8; font: 14px 'Barlow', Arial, sans-serif; }
        .landing-editor { height: 100vh; display: grid; grid-template-rows: 56px minmax(0, 1fr); }
        .editor-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 0 18px; background: #fff; border-bottom: 1px solid var(--border); }
        .editor-heading { display: flex; align-items: center; gap: 13px; min-width: 0; }
        .editor-heading a,.icon-button { display: inline-grid; place-items: center; width: 34px; height: 34px; border: 0; border-radius: 5px; color: #53617b; background: #f3f5f8; text-decoration: none; cursor: pointer; }
        .editor-heading h1 { margin: 0; font-size: 15px; font-weight: 700; }
        .editor-heading span { color: var(--muted); font-size: 12px; }
        .header-actions { display: flex; align-items: center; gap: 9px; }
        .editor-save-button,.editor-reset-button { min-height: 38px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 0 14px; border: 1px solid transparent; border-radius: 6px; font: 700 13px 'Barlow',Arial,sans-serif; cursor: pointer; transition: background .16s ease,box-shadow .16s ease,transform .16s ease; }
        .editor-save-button { border-color: #2463eb; background: #2463eb; color: #fff; box-shadow: 0 3px 8px rgba(36,99,235,.2); }
        .editor-save-button:hover { background: #174fc9; color: #fff; box-shadow: 0 5px 12px rgba(36,99,235,.25); transform: translateY(-1px); }
        .editor-save-button > i { display: inline-grid; flex: 0 0 14px; width: 14px; height: 14px; place-items: center; font-size: 14px; }
        .editor-reset-button { border: 1px solid var(--border); background: #fff; color: #53617b; }
        .editor-reset-button:hover { background: #f3f5f8; color: var(--ink); }
        .editor-save-button:disabled,.editor-reset-button:disabled { opacity: .65; cursor: wait; transform: none; }
        .editor-main { min-height: 0; display: grid; grid-template-columns: 80px 300px minmax(0, 1fr); }
        .editor-main.code-mode { grid-template-columns: 80px minmax(0, 1fr) minmax(0, 1fr); }
        .editor-rail,.editor-panel { min-height: 0; background: #fff; border-right: 1px solid var(--border); }
        .editor-rail { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 14px 6px; }
        .editor-rail button { width: 64px; min-height: 58px; display: grid; align-content: center; justify-items: center; gap: 5px; border: 0; border-radius: 6px; color: var(--muted); background: transparent; font: 700 10px/1 'Barlow', Arial, sans-serif; text-transform: uppercase; cursor: pointer; }
        .editor-rail button i { font-size: 17px; }
        .editor-rail button.active,.editor-rail button:hover { color: var(--blue); background: #edf3ff; }
        .editor-panel { overflow: auto; padding: 22px 14px; }
        .editor-panel h2 { margin: 0 0 5px; font-size: 16px; }
        .panel-subtitle { margin: 0 0 18px; color: #8491a8; font-size: 12px; }
        .tab-panel[hidden] { display: none; }
        .page-list { display: grid; gap: 6px; }
        .page-list button { width: 100%; padding: 10px 12px; border: 1px solid #e3e8f0; border-radius: 5px; background: #fff; color: #53617b; text-align: left; cursor: pointer; }
        .page-list button.active { border-color: #2463eb; background: #edf3ff; color: #2463eb; font-weight: 600; }
        .code-toolbar { display: flex; justify-content: flex-end; margin-bottom: 10px; }
        .code-editor { display: block; width: 100%; height: calc(100vh - 170px); min-height: 200px; padding: 12px; border: 1px solid var(--border); border-radius: 4px; background: #f8f9fb; color: #26324b; font: 12px/1.55 Consolas, 'Courier New', monospace; tab-size: 4; white-space: pre; overflow: auto; resize: none; }
        .field { margin-bottom: 16px; }
        .field label { display: block; margin-bottom: 6px; color: #53617b; font-size: 12px; font-weight: 600; }
        .field input:not([type="file"]),.field textarea,.field select { width: 100%; min-height: 38px; padding: 9px 10px; border: 1px solid #e3e8f0; border-radius: 5px; background: #f8f9fb; color: #25314c; font: inherit; }
        .field textarea { min-height: 120px; resize: vertical; }
        .field input:disabled,.field textarea:disabled,.field select:disabled { opacity: .55; }
        .field small { display: block; margin-top: 5px; color: #8491a8; font-size: 11px; }
        .selection-state { display: flex; align-items: center; gap: 9px; padding: 11px; margin-bottom: 16px; border-radius: 5px; background: #f2f5fa; color: #53617b; font-size: 12px; overflow-wrap: anywhere; }
        .selection-state i { color: #2463eb; }
        .upload-row { display: flex; gap: 8px; align-items: center; }
        .upload-row input[type="file"] { display: none; }
        .upload-row .btn { white-space: nowrap; }
        .button-row { display: flex; gap: 8px; }
        .button-row .btn { flex: 1; }
        .editor-preview { min-width: 0; min-height: 0; padding: 14px; }
        .preview-frame { width: 100%; height: 100%; overflow: hidden; border: 1px solid #dfe5ee; border-radius: 6px; background: #fff; box-shadow: 0 2px 8px rgba(24, 39, 75, .06); }
        .preview-frame iframe { display: block; width: 100%; height: 100%; border: 0; background: #fff; }
        @media(max-width: 760px) {
            .editor-main { grid-template-columns: 58px minmax(0, 1fr); grid-template-rows: minmax(250px, 42vh) minmax(0, 1fr); }
            .editor-rail { grid-column: 1; grid-row: 1 / span 2; }
            .editor-panel { grid-column: 2; grid-row: 1; border-bottom: 1px solid #e3e8f0; }
            .editor-preview { grid-column: 2; grid-row: 2; padding: 8px; }
            .editor-heading span { display: none; }
            .code-editor { height: 30vh; min-height: 140px; }
            .editor-main.code-mode { grid-template-columns: 58px minmax(0, 1fr); grid-template-rows: minmax(250px, 42vh) minmax(0, 1fr); }
        }
    </style>
</head>
<body>
<main class="landing-editor">
    <header class="editor-header">
        <div class="editor-heading">
            <a href="{{ route('admin.settings.theme') }}" title="Quay lại"><i class="fa-solid fa-arrow-left"></i></a>
            <h1>Chỉnh sửa giao diện trang chủ <span>#{{ $theme }}</span></h1>
        </div>
        <div class="header-actions">
            <button class="btn btn-sm editor-reset-button" id="reset-theme" type="button" title="Khôi phục giao diện gốc">
                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                <span>Khôi phục gốc</span>
            </button>
            <button class="btn btn-sm editor-save-button" id="save-theme" type="button">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i><span>Lưu thay đổi</span>
            </button>
        </div>
    </header>
    <div class="editor-main">
        <nav class="editor-rail" aria-label="Công cụ chỉnh sửa">
            <button class="active" type="button" data-tab="content"><i class="fa-solid fa-font"></i><span>Nội dung</span></button>
            <button type="button" data-tab="media"><i class="fa-regular fa-image"></i><span>Ảnh / icon</span></button>
            <button type="button" data-tab="form"><i class="fa-solid fa-table-list"></i><span>Form</span></button>
            <button type="button" data-tab="layout"><i class="fa-solid fa-arrows-up-down-left-right"></i><span>Bố cục</span></button>
            <button type="button" data-tab="pages"><i class="fa-regular fa-file-lines"></i><span>Trang</span></button>
            <button type="button" data-tab="code"><i class="fa-solid fa-code"></i><span>Mã nguồn</span></button>
        </nav>
        <aside class="editor-panel">
            <section class="tab-panel" data-panel="code" hidden>
                <h2>Mã nguồn</h2>
                <p class="panel-subtitle">Chỉnh sửa toàn bộ HTML của trang hiện tại</p>
                <div class="code-toolbar">
                    <button type="button" class="btn btn-sm btn-primary" id="apply-source">
                        <i class="fa-solid fa-play me-1" aria-hidden="true"></i>Áp dụng mã
                    </button>
                </div>
                <textarea id="source-editor" class="code-editor" spellcheck="false" wrap="off" aria-label="Mã nguồn HTML"></textarea>
            </section>
            <section class="tab-panel" data-panel="pages" hidden>
                <h2>Trang chủ</h2>
                <p class="panel-subtitle">Chọn trang landing cần chỉnh sửa</p>
                <div class="page-list" id="landing-page-list">
                    @foreach ($landingPages as $page)
                        <button type="button" data-theme="{{ $page['id'] }}" class="{{ (string) $theme === (string) $page['id'] ? 'active' : '' }}">{{ $page['label'] }}</button>
                    @endforeach
                </div>
            </section>
            <section class="tab-panel" data-panel="content">
                <h2>Nội dung</h2>
                <p class="panel-subtitle">Phần tử đang chọn</p>
                <div class="selection-state"><i class="fa-solid fa-crosshairs"></i><span id="selection-label">Chưa chọn nội dung</span></div>
                <div class="field">
                    <label for="text-value">Văn bản</label>
                    <textarea id="text-value" disabled></textarea>
                </div>
            </section>
            <section class="tab-panel" data-panel="media" hidden>
                <h2>Ảnh và biểu tượng</h2>
                <p class="panel-subtitle">Chỉnh sửa ảnh hoặc class của icon đang chọn</p>
                <div class="field">
                    <label for="image-url">Đường dẫn ảnh</label>
                    <input id="image-url" type="url" placeholder="https://... hoặc /images/... " disabled>
                </div>
                <div class="field upload-row">
                    <button class="btn btn-sm btn-light" id="choose-image" type="button" disabled>
                        <i class="fa-solid fa-upload me-1"></i>Chọn ảnh từ máy
                    </button>
                    <input id="image-file" type="file" accept="image/png,image/jpeg,image/webp,image/gif,image/avif">
                </div>
                <div class="field">
                    <label for="image-alt">Mô tả ảnh (alt)</label>
                    <input id="image-alt" type="text" disabled>
                </div>
                <div class="field">
                    <label for="icon-class">Class biểu tượng</label>
                    <input id="icon-class" type="text" placeholder="fa-solid fa-star" disabled>
                    <small>Áp dụng cho thẻ i hoặc svg đang chọn.</small>
                </div>
            </section>
            <section class="tab-panel" data-panel="form" hidden>
                <h2>Form</h2>
                <p class="panel-subtitle">Căn chỉnh và sắp xếp form trên trang</p>
                <div class="field">
                    <label for="form-select">Form</label>
                    <select id="form-select"></select>
                </div>
                <div class="field">
                    <label for="form-align">Vị trí ngang</label>
                    <select id="form-align">
                        <option value="flex-start">Bên trái</option>
                        <option value="center">Ở giữa</option>
                        <option value="flex-end">Bên phải</option>
                    </select>
                </div>
                <div class="field">
                    <label for="form-width">Chiều rộng</label>
                    <select id="form-width">
                        <option value="">Mặc định</option>
                        <option value="100%">100%</option>
                        <option value="75%">75%</option>
                        <option value="50%">50%</option>
                    </select>
                </div>
                <div class="button-row">
                    <button type="button" class="btn btn-sm btn-light" id="form-up"><i class="fa-solid fa-arrow-up me-1"></i>Lên</button>
                    <button type="button" class="btn btn-sm btn-light" id="form-down"><i class="fa-solid fa-arrow-down me-1"></i>Xuống</button>
                </div>
            </section>
            <section class="tab-panel" data-panel="layout" hidden>
                <h2>Bố cục</h2>
                <p class="panel-subtitle">Sắp xếp khối đang chọn trong vùng chứa hiện tại</p>
                <div class="selection-state"><i class="fa-solid fa-layer-group"></i><span id="layout-label">Chưa chọn khối</span></div>
                <div class="button-row">
                    <button type="button" class="btn btn-sm btn-light" id="move-up"><i class="fa-solid fa-arrow-up me-1"></i>Lên</button>
                    <button type="button" class="btn btn-sm btn-light" id="move-down"><i class="fa-solid fa-arrow-down me-1"></i>Xuống</button>
                </div>
            </section>
        </aside>
        <section class="editor-preview">
            <div class="preview-frame"><iframe id="landing-preview" title="Xem trước giao diện trang chủ"></iframe></div>
        </section>
    </div>
</main>
<script src="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/app.js') }}?v={{ config('app.version') }}"></script>
<script>
(() => {
    let theme = @json((string) $theme);
    const preview = document.getElementById('landing-preview');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const initialHtml = @json($html);
    const sourceEditor = document.getElementById('source-editor');
    const textField = document.getElementById('text-value');
    const imageUrl = document.getElementById('image-url');
    const imageAlt = document.getElementById('image-alt');
    const iconClass = document.getElementById('icon-class');
    const formSelect = document.getElementById('form-select');
    const formAlign = document.getElementById('form-align');
    const formWidth = document.getElementById('form-width');
    const selectionLabel = document.getElementById('selection-label');
    const layoutLabel = document.getElementById('layout-label');
    let selectedElement = null;
    let selectedFormBlock = null;
    let selectedType = '';
    let forms = [];
    let switchingPage = false;
    let sourceDirty = false;
    let sourceRevision = 0;
    let sourcePreviewTimer = null;

    preview.srcdoc = initialHtml;
    document.querySelectorAll('[data-tab]').forEach(button => button.addEventListener('click', async () => {
        if (button.dataset.tab !== 'code' && document.querySelector('[data-tab="code"]').classList.contains('active') && sourceDirty) {
            try {
                await applySource();
            } catch (error) {
                await app.alert(error?.message || 'Không thể áp dụng mã nguồn.', 'danger');
                return;
            }
        }
        document.querySelectorAll('[data-tab]').forEach(item => item.classList.toggle('active', item === button));
        document.querySelectorAll('[data-panel]').forEach(panel => { panel.hidden = panel.dataset.panel !== button.dataset.tab; });
        document.querySelector('.editor-main').classList.toggle('code-mode', button.dataset.tab === 'code');
        if (button.dataset.tab === 'code' && !sourceDirty) sourceEditor.value = exportHtml();
    }));

    function setSelection(element, type) {
        const doc = preview.contentDocument;
        doc?.querySelectorAll('.__admin-landing-selected').forEach(item => item.classList.remove('__admin-landing-selected'));
        if (selectedFormBlock) {
            selectedFormBlock.removeAttribute('draggable');
            selectedFormBlock.removeAttribute('data-landing-form-block');
            selectedFormBlock.classList.remove('__admin-landing-form-draggable');
        }
        selectedFormBlock = null;
        selectedElement = element;
        selectedType = type;
        if (element) element.classList.add('__admin-landing-selected');
        const tag = element?.tagName?.toLowerCase() || '';
        selectionLabel.textContent = element ? `${tag}${element.id ? '#' + element.id : ''}` : 'Chưa chọn nội dung';
        layoutLabel.textContent = element ? `${tag}${element.id ? '#' + element.id : ''}` : 'Chưa chọn khối';
        textField.disabled = type !== 'text';
        imageUrl.disabled = type !== 'image';
        imageAlt.disabled = type !== 'image';
        document.getElementById('choose-image').disabled = type !== 'image';
        iconClass.disabled = type !== 'icon';
        textField.value = type === 'text' ? element.textContent.trim() : '';
        imageUrl.value = type === 'image' ? element.getAttribute('src') || '' : '';
        imageAlt.value = type === 'image' ? element.getAttribute('alt') || '' : '';
        iconClass.value = type === 'icon' ? element.getAttribute('class') || '' : '';
        if (type === 'form') {
            selectedFormBlock = element.closest('.row') || element.parentElement;
            selectedFormBlock.setAttribute('draggable', 'true');
            selectedFormBlock.setAttribute('data-landing-form-block', 'true');
            selectedFormBlock.classList.add('__admin-landing-form-draggable');
            const index = forms.indexOf(element);
            if (index >= 0) formSelect.value = String(index);
            formAlign.value = element.parentElement?.style.justifyContent || 'center';
            formWidth.value = element.style.width || '';
        }
        if (type === 'text') {
            element.setAttribute('contenteditable', 'true');
            element.setAttribute('spellcheck', 'false');
        }
    }

    function attachPreviewEditor() {
        const doc = preview.contentDocument;
        if (!doc) return;
        if (!sourceDirty) sourceEditor.value = exportHtml();
        const style = doc.createElement('style');
        style.id = '__admin-landing-editor-style';
        style.textContent = '.__admin-landing-selected{outline:3px solid #2463eb!important;outline-offset:2px!important;cursor:pointer!important} [contenteditable="true"]{cursor:text!important} .__admin-landing-form-draggable{cursor:move!important}';
        doc.head.appendChild(style);
        forms = [...doc.querySelectorAll('form')];
        formSelect.innerHTML = forms.map((form, index) => {
            const label = form.getAttribute('aria-label') || form.id || form.className || `Form ${index + 1}`;
            return `<option value="${index}">${String(label).replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]))}</option>`;
        }).join('');
        formSelect.disabled = forms.length === 0;
        formAlign.disabled = forms.length === 0;
        formWidth.disabled = forms.length === 0;
        document.getElementById('form-up').disabled = forms.length === 0;
        document.getElementById('form-down').disabled = forms.length === 0;
        doc.addEventListener('submit', event => event.preventDefault(), true);
        doc.addEventListener('input', event => {
            if (event.target?.isContentEditable && event.target === selectedElement) {
                textField.value = event.target.textContent;
            }
        }, true);
        let draggedFormBlock = null;
        doc.addEventListener('dragstart', event => {
            const block = event.target.closest('[data-landing-form-block="true"]');
            if (!block) return;
            draggedFormBlock = block;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', 'landing-form-block');
        });
        doc.addEventListener('dragover', event => {
            if (!draggedFormBlock) return;
            let target = event.target;
            while (target && target.parentElement !== draggedFormBlock.parentElement) target = target.parentElement;
            if (!target || target === draggedFormBlock) return;
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
        });
        doc.addEventListener('drop', event => {
            if (!draggedFormBlock) return;
            let target = event.target;
            while (target && target.parentElement !== draggedFormBlock.parentElement) target = target.parentElement;
            if (!target || target === draggedFormBlock) return;
            event.preventDefault();
            const bounds = target.getBoundingClientRect();
            const insertAfter = event.clientY > bounds.top + bounds.height / 2;
            target.parentElement.insertBefore(draggedFormBlock, insertAfter ? target.nextSibling : target);
        });
        doc.addEventListener('dragend', () => { draggedFormBlock = null; });
        doc.addEventListener('click', event => {
            const target = event.target;
            const form = target.closest('form');
            const image = target.closest('img');
            const icon = target.closest('i,svg');
            const text = target.closest('h1,h2,h3,h4,h5,h6,p,a,button,label,li,span');
            if (target.closest('a,button')) {
                event.preventDefault();
                event.stopPropagation();
            }
            if (form && (target === form || target.matches('input,select,textarea,button'))) {
                setSelection(form, 'form');
            } else if (image) {
                setSelection(image, 'image');
            } else if (icon) {
                setSelection(icon, 'icon');
            } else if (text) {
                setSelection(text, 'text');
                text.focus();
            } else {
                setSelection(target.closest('section,header,footer,article,main'), 'block');
            }
        }, true);
        setSelection(null, '');
    }
    preview.addEventListener('load', attachPreviewEditor);
    formSelect.addEventListener('change', () => setSelection(forms[Number(formSelect.value)] || null, 'form'));
    sourceEditor.addEventListener('input', () => {
        sourceDirty = true;
        const revision = ++sourceRevision;
        window.clearTimeout(sourcePreviewTimer);
        sourcePreviewTimer = window.setTimeout(() => {
            const html = sourceEditor.value;
            if (!/<html\b/i.test(html)) return;
            preview.addEventListener('load', () => {
                if (revision !== sourceRevision) return;
                sourceDirty = false;
                sourceEditor.value = exportHtml();
            }, { once: true });
            preview.srcdoc = html;
        }, 350);
    });

    textField.addEventListener('input', () => {
        if (selectedType === 'text' && selectedElement) {
            selectedElement.textContent = textField.value;
            selectedElement.setAttribute('contenteditable', 'true');
        }
    });
    imageUrl.addEventListener('input', () => {
        if (selectedType === 'image' && selectedElement) selectedElement.setAttribute('src', imageUrl.value);
    });
    imageAlt.addEventListener('input', () => {
        if (selectedType === 'image' && selectedElement) selectedElement.setAttribute('alt', imageAlt.value);
    });
    iconClass.addEventListener('input', () => {
        if (selectedType === 'icon' && selectedElement) selectedElement.setAttribute('class', iconClass.value);
    });
    document.getElementById('choose-image').addEventListener('click', () => document.getElementById('image-file').click());
    document.getElementById('image-file').addEventListener('change', async event => {
        const file = event.target.files?.[0];
        if (!file || selectedType !== 'image') return;
        const body = new FormData();
        body.append('theme', theme);
        body.append('image', file);
        try {
            const response = await fetch(@json(route('admin.settings.landing.editor.upload')), {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body
            });
            const result = await response.json();
            if (!response.ok || !result.url) throw new Error(result.error || 'Không thể tải ảnh lên.');
            imageUrl.value = result.url;
            selectedElement.setAttribute('src', result.url);
            await app.alert('Đã tải ảnh lên.', 'success');
        } catch (error) {
            await app.alert(error.message || 'Tải ảnh thất bại.', 'danger');
        } finally {
            event.target.value = '';
        }
    });

    formAlign.addEventListener('change', () => {
        const form = forms[Number(formSelect.value)];
        if (!form) return;
        form.parentElement.style.display = 'flex';
        form.parentElement.style.justifyContent = formAlign.value;
        form.style.alignSelf = formAlign.value;
    });
    formWidth.addEventListener('change', () => {
        const form = forms[Number(formSelect.value)];
        if (form) form.style.width = formWidth.value;
    });
    function moveElement(element, direction) {
        const sibling = direction < 0 ? element?.previousElementSibling : element?.nextElementSibling;
        if (!element || !sibling || !element.parentElement) return;
        if (direction < 0) element.parentElement.insertBefore(element, sibling);
        else element.parentElement.insertBefore(sibling, element);
    }
    document.getElementById('form-up').addEventListener('click', () => {
        const form = forms[Number(formSelect.value)];
        moveElement(form?.closest('.row') || form?.parentElement, -1);
    });
    document.getElementById('form-down').addEventListener('click', () => {
        const form = forms[Number(formSelect.value)];
        moveElement(form?.closest('.row') || form?.parentElement, 1);
    });
    document.getElementById('move-up').addEventListener('click', () => moveElement(selectedElement?.closest('section,header,footer,article') || selectedElement, -1));
    document.getElementById('move-down').addEventListener('click', () => moveElement(selectedElement?.closest('section,header,footer,article') || selectedElement, 1));

    function exportHtml() {
        const doc = preview.contentDocument;
        if (!doc) return '';
        const html = doc.documentElement.cloneNode(true);
        html.querySelectorAll('.__admin-landing-selected').forEach(item => item.classList.remove('__admin-landing-selected'));
        html.querySelectorAll('[contenteditable], [spellcheck="false"]').forEach(item => {
            item.removeAttribute('contenteditable');
            item.removeAttribute('spellcheck');
        });
        html.querySelectorAll('[data-landing-form-block]').forEach(item => {
            item.removeAttribute('data-landing-form-block');
            item.removeAttribute('draggable');
            item.classList.remove('__admin-landing-form-draggable');
        });
        html.querySelector('#__admin-landing-editor-style')?.remove();
        return '<!doctype html>\n' + html.outerHTML;
    }
    function applySource() {
        const html = sourceEditor.value.trim();
        if (!/<html\b/i.test(html)) throw new Error('Mã nguồn cần chứa đầy đủ thẻ HTML.');
        window.clearTimeout(sourcePreviewTimer);
        sourceRevision++;
        sourceDirty = false;
        return new Promise(resolve => {
            const fallback = window.setTimeout(resolve, 5000);
            preview.addEventListener('load', () => {
                window.clearTimeout(fallback);
                resolve();
            }, { once: true });
            preview.srcdoc = html;
        });
    }
    document.getElementById('apply-source').addEventListener('click', async () => {
        try {
            await applySource();
        } catch (error) {
            await app.alert(error?.message || 'Không thể áp dụng mã nguồn.', 'danger');
        }
    });
    async function loadTheme(nextTheme) {
        const result = await app.ajax('Setting-loadHTML', { theme: nextTheme }, false);
        if (result?.error) throw new Error(result.error);
        if (typeof result?.success !== 'string' || !result.success) throw new Error('Không thể tải nội dung trang.');
        theme = String(nextTheme);
        selectedElement = null;
        selectedType = '';
        preview.srcdoc = result.success;
        document.querySelectorAll('#landing-page-list [data-theme]').forEach(button => {
            button.classList.toggle('active', button.dataset.theme === theme);
        });
        document.querySelector('.editor-heading h1 span').textContent = `#${theme}`;
        return result.success;
    }
    document.querySelectorAll('#landing-page-list [data-theme]').forEach(button => {
        button.addEventListener('click', async () => {
            const nextTheme = button.dataset.theme;
            if (nextTheme === theme || switchingPage) return;
            switchingPage = true;
            try {
                if (sourceDirty) await applySource();
                const html = exportHtml();
                const saved = await app.ajax('Setting-saveHTML', { theme, html }, false);
                if (saved?.error) throw new Error(saved.error);
                await loadTheme(nextTheme);
            } catch (error) {
                await app.alert(error?.message || 'Không thể chuyển trang.', 'danger');
            } finally {
                switchingPage = false;
            }
        });
    });
    document.getElementById('save-theme').addEventListener('click', async () => {
        try {
            if (sourceDirty) await applySource();
        } catch (error) {
            await app.alert(error?.message || 'Không thể áp dụng mã nguồn.', 'danger');
            return;
        }
        const html = exportHtml();
        if (!html) return;
        try {
            const result = await app.ajax('Setting-saveHTML', { theme, html }, false);
            if (result?.error) throw new Error(result.error);
            preview.srcdoc = html;
            await app.alert(result?.success || 'Đã lưu giao diện.', 'success');
        } catch (error) {
            await app.alert(error?.message || 'Không thể lưu giao diện.', 'danger');
        }
    });
    document.getElementById('reset-theme').addEventListener('click', async () => {
        try {
            await app.confirm('Khôi phục giao diện này về bản mặc định?');
        } catch {
            return;
        }
        window.clearTimeout(sourcePreviewTimer);
        sourceRevision++;
        sourceDirty = false;
        try {
            const result = await app.ajax('Setting-defaultHTML', { theme }, false);
            if (result?.error) throw new Error(result.error);
            await loadTheme(theme);
            await app.alert(result?.success || 'Đã khôi phục giao diện.', 'success');
        } catch (error) {
            await app.alert(error?.message || 'Không thể khôi phục giao diện.', 'danger');
        }
    });
})();
</script>
</body>
</html>
