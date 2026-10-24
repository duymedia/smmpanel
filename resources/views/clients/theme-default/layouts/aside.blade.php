<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                    data-kt-drawer-width="{default:'200px', '300px': '225px'}" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_aside_toggle" data-kt-sticky="true" data-kt-sticky-name="aside-sticky"
                    data-kt-sticky-offset="{default: false, lg: '1px'}" data-kt-sticky-width="{lg: '225px'}"
                    data-kt-sticky-left="auto" data-kt-sticky-top="94px" data-kt-sticky-animation="false"
                    data-kt-sticky-zindex="95">
                    <!--begin::Aside nav-->
                    <div class="aside-menu flex-column-fluid px-4">
                    <div class="hover-scroll-overlay-y mh-100 my-5 w-100"
                        id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="true"
                        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_header"
                        data-kt-scroll-wrappers="#kt_aside" data-kt-scroll-offset="{default: '5px', lg: '75px'}">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-active-bg menu-hover-bg menu-title-gray-700 fs-6 menu-rounded w-100"
                            id="#kt_aside_menu" data-kt-menu="true">

                            {{-- ===== DỊCH VỤ ===== --}}
                            <div class="menu-item">
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Services">Services</span>
                                </div>
                            </div>

                            @auth
                            {{-- Chỉ user đã đăng nhập mới thấy New order, Mass order, Orders, Refill --}}
                            <div class="menu-item here">
                                <a class="menu-link" href="/new">
                                    <span class="menu-icon"><i class="ki-outline ki-handcart fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::New order">New order</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/mass">
                                    <span class="menu-icon"><i class="ki-outline ki-basket fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Mass order">Mass order</span>
                                </a>
                            </div>
                            @endauth
                            
                            @if(auth()->check() || !serviceOn($config, 'service_require_login'))
                            <div class="menu-item">
                                <a class="menu-link" href="/services">
                                    <span class="menu-icon"><i class="ki-outline ki-shop fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Service list">List</span>
                                </a>
                            </div>
                            @endif

                            @auth
                            <div class="menu-item">
                                <a class="menu-link" href="/orders">
                                    <span class="menu-icon"><i class="ki-outline ki-questionnaire-tablet fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Service orders">Orders</span>
                                </a>
                            </div>
                            <div class="menu-item {{ request()->routeIs('clients.loop_orders.index') ? 'here' : '' }}">
                                <a class="menu-link {{ request()->routeIs('clients.loop_orders.index') ? 'active' : '' }}"
                                    href="/loop_orders">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-arrows-circle fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </span>
                                    <span class="menu-title" data-lang="menu::Loop orders">Loop orders</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/refill">
                                    <span class="menu-icon"><i class="ki-outline ki-filter-tablet fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Service refill">Refill</span>
                                </a>
                            </div>
                            @endauth

                            {{-- ===== SẢN PHẨM (chỉ khi đăng nhập + enable_products) ===== --}}
                            @auth
                            @if(isset($config) && $config->enable_products == 1)
                            <div class="menu-item pt-5">
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Products">Products</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/products">
                                    <span class="menu-icon"><i class="ki-outline ki-parcel fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Product list">List</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/ai_video">
                                    <span class="menu-icon"><i class="ki-outline ki-add-item fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Create AI Video">Create AI Video</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/ai_image">
                                    <span class="menu-icon"><i class="ki-outline ki-add-item fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Create AI Image">Create AI Image</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/product_orders">
                                    <span class="menu-icon"><i class="ki-outline ki-questionnaire-tablet fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Product orders">Orders</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/product_refill">
                                    <span class="menu-icon"><i class="ki-outline ki-filter-tablet fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Product refill">Refill</span>
                                </a>
                            </div>
                            @endif

                            {{-- ===== QUỸ ===== --}}
                            <div class="menu-item pt-5">
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Funds">Funds</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/addfunds">
                                    <span class="menu-icon"><i class="ki-outline ki-credit-cart fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Add funds">Add funds</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/cashflow">
                                    <span class="menu-icon"><i class="ki-outline ki-finance-calculator fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Cash flow">Cash flow</span>
                                </a>
                            </div>

                            {{-- ===== HỖ TRỢ & CÀI ĐẶT ===== --}}
                            <div class="menu-item pt-5">
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Support &amp; Settings">Support &amp; Settings</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/tickets">
                                    <span class="menu-icon"><i class="ki-outline ki-question-2 fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Support">Support</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/settings">
                                    <span class="menu-icon"><i class="ki-outline ki-setting-3 fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Settings">Settings</span>
                                </a>
                            </div>

                            {{-- ===== KHÁC ===== --}}
                            <div class="menu-item pt-5">
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Others">Others</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/update">
                                    <span class="menu-icon"><i class="ki-outline ki-time fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Update">Update</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/affiliates">
                                    <span class="menu-icon"><i class="ki-outline ki-data fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Affiliate">Affiliate</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/childpanel">
                                    <span class="menu-icon"><i class="ki-outline ki-people fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Child Panel">Child Panel</span>
                                </a>
                            </div>
                            @endauth

                            {{-- API — public --}}
                            <div class="menu-item @guest pt-5 @endguest">
                                @guest
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Others">Others</span>
                                </div>
                                @endguest
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/apidoc">
                                    <span class="menu-icon"><i class="ki-outline ki-code fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::API">API</span>
                                </a>
                            </div>

                            {{-- ===== TÀI KHOẢN (chỉ hiện khi chưa đăng nhập) ===== --}}
                            @guest
                            <div class="menu-item pt-5">
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7" data-lang="menu::Account">Tài khoản</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/signin">
                                    <span class="menu-icon"><i class="ki-outline ki-entrance-right fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Sign in">Đăng nhập</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="/signup">
                                    <span class="menu-icon"><i class="ki-outline ki-profile-circle fs-2"></i></span>
                                    <span class="menu-title" data-lang="menu::Sign up">Đăng ký</span>
                                </a>
                            </div>
                            @endguest
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const currentPath = window.location.pathname;
                                    const menuLinks = document.querySelectorAll('.menu-link');

                                    menuLinks.forEach(link => {
                                        const menuPath = link.getAttribute('href');
                                        if (menuPath === currentPath) {
                                            link.classList.add('active');
                                            const menuItem = link.closest('.menu-item');
                                            if (menuItem) {
                                                menuItem.classList.add('here');
                                            }

                                            const parentAccordion = link.closest('.menu-accordion');
                                            if (parentAccordion) {
                                                parentAccordion.classList.add('show');
                                            }
                                        }
                                    });
                                });
                            </script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const currentPath = window.location.pathname;
                                    const menuLinks = document.querySelectorAll(".menu-link");

                                    menuLinks.forEach(link => {
                                        const menuPath = link.getAttribute("href");
                                        if (menuPath === currentPath) {
                                            link.classList.add("active");
                                            let menuItem = link.closest('.menu-sub');
                                            if (menuItem) {
                                                menuItem = menuItem.closest('.menu-item');
                                                if (menuItem)
                                                    menuItem.classList.add("here");
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <!--end::Menu-->
                    </div>
                    </div>
                    <!--end::Aside nav-->
                </div>

