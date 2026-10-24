@if (isChildPanel())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allowed = @json(panelAccessPages());
            const showAll = @json(in_array('*', panelAccessPages(), true));
            const restrictedChildPages = ['ticket-subjects'];
            const links = document.querySelectorAll('#kt_header_navs a[href]');
            const keep = function (link) {
                const path = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '');
                // path is "/admin/orders", allowed items are "orders", "services", etc.
                const page = path.replace(/^\/admin\/?/, '') || 'dashboard';
                if (page === 'dashboard' || page === 'cron-jobs' || page.startsWith('cron-jobs/')) {
                    link.closest('.menu-item')?.remove();
                    return false;
                }
                if (showAll) return true;
                if (restrictedChildPages.some(prefix => page === prefix || page.startsWith(prefix + '/'))) {
                    link.closest('.menu-item')?.remove();
                    return false;
                }
                const visible = allowed.some(prefix => {
                    if (prefix === '*') return true;
                    const cleaned = prefix.replace(/^\/admin\/?/, '');
                    return page === cleaned || page.startsWith(cleaned + '/');
                });
                if (!visible) {
                    link.closest('.menu-item')?.remove();
                }
                return visible;
            };

            links.forEach(keep);

            // Remove empty dropdown groups after their restricted children are hidden.
            document.querySelectorAll('#kt_header_navs .menu-item').forEach(function (item) {
                if (!item.querySelector('a[href]')) item.remove();
            });
        });
    </script>
@endif
<div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0 overflow-hidden overflow-lg-visible" id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}">
   <!--begin::Container-->
   <div class="d-lg-flex container-xxl w-100">
      <!--begin::Wrapper-->
      <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
         <!--begin::Header tab content-->
         <div class="tab-content" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto" data-kt-scroll-offset="70px">
            <!--begin::Tab panel-->
            <div class="tab-pane fade show" id="header_orders" role="tabpanel">
               <!--begin::Menu wrapper-->
               <div class="header-menu flex-column align-items-stretch flex-lg-row">
                  <!--begin::Menu-->
                  <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="kt_header_menu_orders" data-kt-menu="true">
                     <!--begin:Menu item-->
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/orders"><span class="menu-title" data-lang="menu::Orders">Đơn hàng dịch vụ</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/product_orders"><span class="menu-title" data-lang="menu::Products">Đơn hàng sản phẩm</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/refill_services"><span class="menu-title" data-lang="menu::Refill services">Bảo hành dịch vụ</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/refill_products"><span class="menu-title" data-lang="menu::Refill products">Bảo hành sản phẩm</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/cancel_services"><span class="menu-title" data-lang="menu::Cancel services">Hủy dịch vụ</span></a></div>
                     <!--end:Menu item-->
                  </div>
                  <!--end::Menu-->
               </div>
               <!--end::Menu wrapper-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-pane fade" id="header_list" role="tabpanel">
               <!--begin::Menu wrapper-->
               <div class="header-menu flex-column align-items-stretch flex-lg-row">
                  <!--begin::Menu-->
                  <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="kt_header_menu_list" data-kt-menu="true">
                     <!--begin:Menu item-->
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/accounts"><span class="menu-title" data-lang="menu::Accounts">Tài khoản</span></a></div>
                     <!--begin:Menu item-->
                     <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                        <!--begin:Menu link-->
                        <span class="menu-link py-3">
                        <span class="menu-title" data-lang="menu::Services">Dịch vụ</span>
                        <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                           <!--begin:Menu item-->
                           <div class="menu-item">
                              <a class="menu-link py-3 menu-link" href="/admin/services"><span class="menu-title" data-lang="menu::Services">Dịch vụ</span></a>
                           </div>
                           <!--end:Menu item-->
                           <!--begin:Menu item-->
                           <div class="menu-item">
                              <a class="menu-link py-3 menu-link" href="/admin/categories"><span class="menu-title" data-lang="menu::Categories">Danh mục dịch vụ</span></a>
                           </div>
                           <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                     </div>
                     <!--end:Menu item-->
                     <!--begin:Menu item-->
                     <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                        <!--begin:Menu link-->
                        <span class="menu-link py-3">
                        <span class="menu-title" data-lang="menu::Products">Sản phẩm</span>
                        <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                           <!--begin:Menu item-->
                           <div class="menu-item">
                              <a class="menu-link py-3 menu-link" href="/admin/products"><span class="menu-title" data-lang="menu::Products">Sản phẩm</span></a>
                           </div>
                           <!--end:Menu item-->
                           <!--begin:Menu item-->
                           <div class="menu-item">
                              <a class="menu-link py-3 menu-link" href="/admin/products/warehouse"><span class="menu-title" data-lang="menu::Warehouse">Kho sản phẩm</span></a>
                           </div>
                           <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                     </div>
                     <!--end:Menu item-->
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/providers"><span class="menu-title" data-lang="menu::Providers">Nhà cung cấp</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/service_sync_logs"><span class="menu-title" data-lang="menu::Sync Logs">Thông tin đồng bộ dịch vụ</span></a></div>
                     <!--end:Menu item-->
                  </div>
                  <!--end::Menu-->
               </div>
               <!--end::Menu wrapper-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-pane fade" id="header_payments" role="tabpanel">
               <!--begin::Menu wrapper-->
               <div class="header-menu flex-column align-items-stretch flex-lg-row">
                  <!--begin::Menu-->
                  <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="kt_header_menu_payments" data-kt-menu="true">
                     <!--begin:Menu item-->
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/payments/method"><span class="menu-title" data-lang="menu::Payment methods">Phương thức</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/payments/history"><span class="menu-title" data-lang="menu::Payment history">Giao dịch</span></a></div>
                     <!--end:Menu item-->
                  </div>
                  <!--end::Menu-->
               </div>
               <!--end::Menu wrapper-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-pane fade" id="header_coupons" role="tabpanel">
               <!--begin::Menu wrapper-->
               <div class="header-menu flex-column align-items-stretch flex-lg-row">
                  <!--begin::Menu-->
                  <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="kt_header_menu_coupons" data-kt-menu="true">
                     <!--begin:Menu item-->
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/coupons"><span class="menu-title" data-lang="menu::Coupon List">Danh sách</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/coupons/usage"><span class="menu-title" data-lang="menu::Coupon usage">Lịch sử</span></a></div>
                     <!--end:Menu item-->
                  </div>
                  <!--end::Menu-->
               </div>
               <!--end::Menu wrapper-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-pane fade {{ request()->is('admin/messages*') || request()->is('admin/tickets*') || request()->is('admin/news*') || request()->is('admin/ticket_statistics_by_service*') || request()->is('admin/ticket-subjects*') ? 'show active' : '' }}" id="header_support" role="tabpanel">
               <!--begin::Menu wrapper-->
               <div class="header-menu flex-column align-items-stretch flex-lg-row">
                  <!--begin::Menu-->
                  <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="kt_header_menu_support" data-kt-menu="true">
                     <!--begin:Menu item-->
                     <div class="menu-item me-0 me-lg-2 {{ request()->is('admin/messages*') ? 'here' : '' }}"><a class="menu-link py-3 menu-link" href="/admin/messages"><span class="menu-title" data-lang="menu::Messages">Tin nhắn</span>@if (($unreadMessagesCount ?? 0) > 0) <span class="badge badge-circle badge-danger badge-sm ms-2">{{ number_format($unreadMessagesCount) }}</span>@endif</a></div>
                     <div class="menu-item me-0 me-lg-2 {{ request()->is('admin/tickets*') ? 'here' : '' }}"><a class="menu-link py-3 menu-link" href="/admin/tickets"><span class="menu-title" data-lang="menu::Tickets">Phiếu hỗ trợ</span></a></div>
                     <div class="menu-item me-0 me-lg-2 {{ request()->is('admin/ticket-subjects*') ? 'here' : '' }}"><a class="menu-link py-3 menu-link" href="{{ route('admin.ticket-subjects.index') }}"><span class="menu-title" data-lang="menu::Ticket Subjects">Chủ đề hỗ trợ</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/news"><span class="menu-title" data-lang="menu::News">Thông báo</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3 menu-link" href="/admin/ticket_statistics_by_service"><span class="menu-title" data-lang="menu::Ticket Statistics by Service">Thống kê phiếu hỗ trợ theo dịch vụ</span></a></div>
                     <!--end:Menu item-->
                  </div>
                  <!--end::Menu-->
               </div>
               <!--end::Menu wrapper-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-pane fade {{ request()->is('admin/api') || request()->is('admin/api_v2') || request()->is('admin/child-panels*') ? 'show active' : '' }}" id="header_others" role="tabpanel">
               <!--begin::Menu wrapper-->
               <div class="header-menu flex-column align-items-stretch flex-lg-row">
                  <!--begin::Menu-->
                   <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
                      <div class="menu-item me-0 me-lg-2 {{ request()->is('admin/child-panels*') ? 'here' : '' }}"><a class="menu-link py-3" href="{{ route('admin.child-panels.index') }}"><span class="menu-title" data-lang="menu::Child Panels">Child Panels</span></a></div>
                     <!--begin:Menu item-->
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3" href="/admin/settings"><span class="menu-title" data-lang="menu::Settings">Cài đặt</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3" href="/admin/analytics"><span class="menu-title" data-lang="menu::Analytics">Phân tích</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3" href="/admin/reports"><span class="menu-title" data-lang="menu::Reports">Thống kê</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3" href="/admin/affiliates"><span class="menu-title" data-lang="menu::Affiliates">Tiếp thị liên kết</span></a></div>
                     <div class="menu-item me-0 me-lg-2 {{ request()->is('admin/api') ? 'here' : '' }}"><a class="menu-link py-3" href="{{ url('/admin/api') }}"><span class="menu-title">API</span></a></div>
                     <div class="menu-item me-0 me-lg-2 {{ request()->is('admin/api_v2') ? 'here' : '' }}"><a class="menu-link py-3" href="{{ url('/admin/api_v2') }}"><span class="menu-title">API v2</span></a></div>
                     <div class="menu-item me-0 me-lg-2"><a class="menu-link py-3" href="/admin/backup"><span class="menu-title" data-lang="menu::Backup">Sao lưu</span></a></div>
                     <!--end:Menu item-->
                  </div>
                  <!--end::Menu-->
               </div>
               <!--end::Menu wrapper-->
            </div>
            <!--end::Tab panel-->
         </div>
         <!--end::Header tab content-->
      </div>
      <!--end::Wrapper-->
   </div>
   <!--end::Container-->
</div>
