<div class="card mb-6">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-fixed position-relative">
                    @if (!empty($config->logo_square))
                        <img alt="" class="settings-logo-square"
                            src="{{ asset('assets/media/' . basename($config->logo_square)) }}?v={{ optional($config->updated_at)->timestamp ?? time() }}"
                            alt="">
                    @else
                        <img class="settings-logo-square"
                            src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22100%22 height=%22100%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 fill=%22%23999%22 text-anchor=%22middle%22 dy=%22.3em%22%3ELogo%20Square%3C/text%3E%3C/svg%3E"
                            alt="">
                    @endif
                </div>
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="javascript:;"
                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $config->domain_main ?? 'Domain' }}: {{ $config->title ?? 'Title' }}</a>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <span class="text-gray-500">{{ $config->description ?? '' }}</span>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                        <span><i class="fa-solid fa-language"></i>
                            @php $lang = $languages?->firstWhere('code', $config->default_lang ?? 'en'); @endphp
                            {{ $lang?->name ?? 'English' }}
                        </span>
                        <span class="ms-10"><i class="fa-solid fa-dollar-sign"></i>
                            @php $cur = isset($currencies) ? $currencies->firstWhere('code', $config->default_currency ?? 'USD') : null; @endphp
                            {{ $cur?->code ?? ($config->default_currency ?? 'USD') }}
                            @if($cur?->name)
                                - {{ $cur->name }}
                            @endif
                        </span>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" id="settingsTabs">
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/general" data-tab="general" data-lang="General">Tổng quan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/theme" data-tab="theme">Theme</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/design" data-tab="design" data-lang="Design">Giao diện</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/price" data-tab="price" data-lang="Price">Giá bán</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/service" data-tab="service" data-lang="Service">Dịch vụ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/language" data-tab="language" data-lang="Language">Ngôn ngữ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/currency" data-tab="currency" data-lang="Currency">Tiền tệ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/support" data-tab="support" data-lang="Support">Hỗ trợ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/security" data-tab="security" data-lang="Security">Bảo mật</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/smtp" data-tab="smtp">SMTP</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ms-0 me-6" href="/admin/settings/modules" data-tab="modules" data-lang="Modules">Tiện ích</a>
            </li>
        </ul>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const currentPath = window.location.pathname;
                const tabs = document.querySelectorAll('#settingsTabs .nav-link');
                
                tabs.forEach(tab => {
                    const href = tab.getAttribute('href');
                    if (currentPath === href || currentPath.includes(href)) {
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });
            });
        </script>
    </div>
</div>
