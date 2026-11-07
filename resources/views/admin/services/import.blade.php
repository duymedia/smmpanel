@extends('admin.layouts.app')
@section('title', 'Services')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <span class="title d-none">Import</span>
        <div class="mb-5 shadow-sm card">
            <div class="card-body">
                <div class="row g-5 g-xl-5 align-items-end">
                    <div class="col-lg-3">
                        <select class="form-select form-select-sm form-select-solid sl-provider" id="providerSelect"
                            data-kt-select2="true" data-placeholder="Chọn nhà cung cấp">
                            <option value="0" data-page="/services" data-lang="Choose provider">Chọn nhà cung cấp</option>
                            @foreach ($providers as $pro)
                                <option value="{{ $pro->id }}" data-fixed-decimal="{{ $pro->fixed_decimal ?? 10 }}"
                                data-rate="{{ $pro->rate_api ?: 1 }}">{{ $pro->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-outline btn-outline-primary btn-sm w-100"
                            onclick="_services.on.click.serviceOfProvider()" data-page="/services" data-lang="List services">Tải dịch vụ</button>
                    </div>

                    <div class="col-lg-5">
                        <select class="form-select form-select-sm form-select-solid sl-category"
                            data-placeholder="Chọn danh mục" data-page="/services" data-lang-placeholder="Choose category">
                            <option value="0" data-page="/services" data-lang="Choose category">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" data-icon="{{ $category->image }}">
                                    {{ $category->platform->name ?? '' }} | {{ $category->getName() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-primary btn-sm w-100"
                            onclick="_services.on.click.import(document.querySelector('.sl-provider').value, document.querySelector('.sl-category').value)"
                            data-lang="button::Import">Nhập</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="shadow-sm card">
            <div class="p-0 card-body">
                <script>
                    var provider_rate, provider_fixed_decimal;
                </script>
                <script>
                    var percent_inc_service = {{ number_format((float) ($markupConfig['markup_retail'] ?? 110), 2, '.', '') }},
                        percent_inc_service_1 = {{ number_format((float) ($markupConfig['markup_agent'] ?? 108), 2, '.', '') }},
                        percent_inc_service_2 = {{ number_format((float) ($markupConfig['markup_distributor'] ?? 105), 2, '.', '') }};
                </script>
                <div class="table-responsive service-import-table-wrap">
                    <table class="table align-middle table-row-bordered fs-7 gy-2 gs-3 service-import-table"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        var languages = @json($languages);
        var table = document.querySelector('.service-import-table');
        if (!table || !languages.length) return;

        function addLanguageEditor(row) {
            var checkbox = row.querySelector('.cb-service[data-info]');
            var cell = checkbox && checkbox.closest('td');
            var nameLine = checkbox && checkbox.parentElement;
            var nameLabel = nameLine && nameLine.querySelector('label');
            if (!cell || !nameLine || !nameLabel || cell.querySelector('.service-import-language-editor')) return;

            var wrapper = document.createElement('div');
            wrapper.className = 'service-import-language-editor dropdown d-inline-block position-relative ms-1';

            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-icon btn-sm btn-light border border-gray-300 p-0 d-inline-flex align-items-center justify-content-center w-30px h-30px';
            button.setAttribute('data-bs-toggle', 'dropdown');
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', document.documentElement.lang.toLowerCase().startsWith('vi')
                ? 'Thêm tên theo ngôn ngữ'
                : 'Add translated name');
            button.title = button.getAttribute('aria-label');

            var icon = document.createElement('i');
            icon.className = 'las la-globe-asia fs-5 text-primary';
            icon.setAttribute('aria-hidden', 'true');
            button.appendChild(icon);

            var menu = document.createElement('div');
            menu.className = 'dropdown-menu dropdown-menu-end p-1';
            menu.style.width = '420px';
            menu.style.maxWidth = 'calc(100vw - 24px)';
            menu.style.maxHeight = '340px';
            menu.style.overflowY = 'auto';

            var menuHeader = document.createElement('div');
            menuHeader.className = 'px-3 py-2 text-muted fw-bold fs-9 text-uppercase';
            menuHeader.textContent = document.documentElement.lang.toLowerCase().startsWith('vi')
                ? 'Chọn ngôn ngữ'
                : 'Choose language';

            var options = document.createElement('div');
            options.className = 'd-flex flex-column gap-1';

            var fields = document.createElement('div');
            fields.className = 'service-import-language-fields border-top mt-2 pt-2';
            fields.hidden = true;

            function showTranslationField(language, event) {
                event.preventDefault();
                event.stopPropagation();
                var code = language.code;
                var field = Array.from(fields.children).find(function (item) {
                    return item.dataset.languageCode === code;
                });

                if (!field) {
                    var language = languages.find(function (item) {
                        return item.code === code;
                    });
                    field = document.createElement('div');
                    field.className = 'input-group input-group-sm mt-2';
                    field.dataset.languageCode = code;

                    var languageCode = document.createElement('span');
                    languageCode.className = 'input-group-text fw-semibold text-uppercase';
                    languageCode.textContent = code;
                    languageCode.title = language.name;

                    var input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'form-control service-import-name-translation';
                    input.dataset.languageCode = code;
                    input.placeholder = language.name;
                    input.setAttribute('aria-label', language.name);
                    input.autocomplete = 'off';

                    var translateButton = document.createElement('button');
                    translateButton.type = 'button';
                    translateButton.className = 'btn btn-light-primary btn-sm d-inline-flex align-items-center justify-content-center';
                    translateButton.title = document.documentElement.lang.toLowerCase().startsWith('vi')
                        ? 'Tự dịch từ English'
                        : 'Translate from English';
                    translateButton.setAttribute('aria-label', translateButton.title);

                    var translateIcon = document.createElement('i');
                    translateIcon.className = 'las la-language fs-5';
                    translateIcon.setAttribute('aria-hidden', 'true');
                    translateButton.appendChild(translateIcon);

                    translateButton.addEventListener('click', async function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        var sourceName = '';
                        try {
                            sourceName = JSON.parse(decodeURIComponent(checkbox.getAttribute('data-info') || '{}')).name || '';
                        } catch (error) {
                            sourceName = '';
                        }

                        if (!sourceName.trim()) {
                            if (window.app && app.toastr) app.toastr('English service name is unavailable.', 'error');
                            return;
                        }

                        translateButton.disabled = true;
                        translateIcon.className = 'las la-spinner la-spin fs-5';
                        try {
                            var result = await app.ajax('Service-translateName', {
                                text: sourceName.trim(),
                                target: code
                            }, false);
                            if (result.error) throw result.error;
                            input.value = result.translation || '';
                            input.focus();
                        } catch (error) {
                            var message = typeof error === 'string'
                                ? error
                                : error && (error.message || error.error?.message || error.error) ||
                                    'Translation failed. Try again later.';
                            if (window.app && app.toastr) app.toastr(message, 'error');
                        } finally {
                            translateButton.disabled = false;
                            translateIcon.className = 'las la-language fs-5';
                        }
                    });

                    field.append(languageCode, input, translateButton);
                    fields.appendChild(field);
                }

                fields.hidden = false;
                menu.classList.add('show');
                button.setAttribute('aria-expanded', 'true');
                field.querySelector('input').focus();
            }

            languages.forEach(function (language) {
                var option = document.createElement('button');
                option.type = 'button';
                option.className = 'dropdown-item d-flex align-items-center justify-content-between gap-3 rounded-2 px-3 py-2';

                var languageName = document.createElement('span');
                languageName.className = 'text-gray-800 text-truncate';
                languageName.textContent = language.name;

                var languageCode = document.createElement('span');
                languageCode.className = 'badge badge-light-primary text-uppercase fs-9 flex-shrink-0';
                languageCode.textContent = language.code;

                option.append(languageName, languageCode);
                option.addEventListener('click', function (event) {
                    showTranslationField(language, event);
                });
                options.appendChild(option);
            });

            menu.append(menuHeader, options, fields);
            wrapper.append(button, menu);
            nameLine.insertBefore(wrapper, nameLabel.nextSibling);
        }

        function scanRows(root) {
            if (root.matches && root.matches('tr')) addLanguageEditor(root);
            if (root.querySelectorAll) root.querySelectorAll('tr').forEach(addLanguageEditor);
        }

        scanRows(table);
        new MutationObserver(function (records) {
            records.forEach(function (record) {
                record.addedNodes.forEach(function (node) {
                    if (node.nodeType === Node.ELEMENT_NODE) scanRows(node);
                });
            });
        }).observe(table, { childList: true, subtree: true });

        if (window.app && typeof app.ajax === 'function') {
            var originalAjax = app.ajax;
            app.ajax = function (action, data, showLoading) {
                if (action === 'Service-add' && data && data.provider_sid) {
                    var serviceCheckbox = Array.from(table.querySelectorAll('.cb-service[data-info]'))
                        .find(function (item) {
                            return item.getAttribute('data-service') === String(data.provider_sid);
                        });
                    var serviceRow = serviceCheckbox && serviceCheckbox.closest('tr');
                    var translations = {};

                    if (serviceRow) {
                        serviceRow.querySelectorAll('.service-import-name-translation').forEach(function (input) {
                            var value = input.value.trim();
                            if (value) translations[input.dataset.languageCode] = value;
                        });
                    }

                    data = Object.assign({}, data, { name_translated: translations });
                }

                var request = originalAjax.call(this, action, data, showLoading);
                if (action === 'Service-add' && data && data.provider_sid) {
                    return Promise.resolve(request).then(function (response) {
                        if (response && response.success && response.id) {
                            response.success = 'Thêm thành công. ID: ' + response.id;
                        }
                        return response;
                    });
                }

                return request;
            };
        }
    })();

    typeof _services !== 'undefined' && typeof _services.init !== 'undefined' && _services.init();
</script>
@endpush
