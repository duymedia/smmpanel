<div class="card mb-6">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-fixed position-relative">
                    @if (!empty($config->logo_square))
                        <img src="{{ asset($config->logo_square) }}" alt="logo"
                            style="width:100px;height:100px;object-fit:cover;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.12);">
                    @else
                        <div style="
                            width:100px;height:100px;border-radius:16px;
                            background:linear-gradient(135deg,#6366f1 0%,#a855f7 50%,#ec4899 100%);
                            display:flex;flex-direction:column;align-items:center;justify-content:center;
                            box-shadow:0 4px 20px rgba(99,102,241,0.35);
                            position:relative;overflow:hidden;
                        ">
                            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.15) 0%,transparent 60%);border-radius:16px;"></div>
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" style="margin-bottom:4px;">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="white" opacity="0.9"/>
                            </svg>
                            <span style="color:#fff;font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;opacity:0.85;">
                                {{ strtoupper(substr($config->title ?? 'SMM', 0, 6)) }}
                            </span>
                        </div>
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
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <span class="d-flex align-items-center fs-7 fw-semibold text-primary">
                            <i class="fa-solid fa-language me-1"></i>
                            @php $lang = $languages?->firstWhere('code', $config->default_lang ?? 'en'); @endphp
                            {{ $lang?->name ?? 'English' }}
                        </span>
                        <span class="d-flex align-items-center fs-7 fw-semibold text-warning">
                            <i class="fa-solid fa-coins me-1"></i>
                            @php $cur = isset($currencies) ? $currencies->firstWhere('code', $config->default_currency ?? 'USD') : null; @endphp
                            {{ $cur?->code ?? ($config->default_currency ?? 'USD') }}
                            @if($cur?->name)
                                <span class="text-muted fw-normal ms-1">{{ $cur->name }}</span>
                            @endif
                        </span>
                        <span class="d-flex align-items-center fs-7 fw-semibold text-info">
                            <i class="fa-solid fa-clock me-1"></i>
                            UTC{{ ($config->timezone ?? 0) >= 0 ? '+' : '' }}{{ $config->timezone ?? 0 }}
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
                <a class="nav-link ms-0 me-6" href="/admin/settings/product" data-tab="product" data-lang="Product">Sản phẩm</a>
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
