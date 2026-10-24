</div>
<div class="py-4 footer d-flex flex-lg-column" id="kt_footer">
   <!--begin::Container-->
   <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
      <!--begin::Copyright-->
      <div class="order-2 text-gray-900 order-md-1">
         <span class="text-muted fw-semibold me-1">2026©</span>
         <a href="/" target="_blank" class="text-gray-800 text-hover-primary">Smmkay.com: Cheapest SMM Services Provider in Vietnam.</a>
      </div>
      <!--end::Copyright-->
      <!--begin::Menu-->
      <ul class="order-1 menu menu-gray-600 menu-hover-primary fw-semibold">
         <li class="menu-item">
            <a href="/admin/orders" class="px-2 menu-link">Orders</a>
         </li>
         <li class="menu-item">
            <a href="/admin/payments" class="px-2 menu-link">Payments</a>
         </li>
         <li class="menu-item">
            <a href="/admin/settings" class="px-2 menu-link">Settings</a>
         </li>
      </ul>
      <!--end::Menu-->
   </div>
   <!--end::Container-->
</div>
<!--end::Footer-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Root-->
<!--Sticky note-->
<div class="hidden sticky-note" id="stickyNotes" data-popper-placement="bottom" data-x="1072.60009765625" data-y="213.80003356933594" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(660px, 213px); width: 228.5px; height: 105.05px;">
   <div class="note-header">
      <h3 class="m-0 text-gray-600"><span data-page="message" data-lang="Sticky Note">Ghi chú</span> <span class="fs-9 fst-italic note-save-status"></span></h3>
      <span class="text-gray-600 btn-hide-note close-btn" id="closeBtn">✖</span>
   </div>
   <div class="note-body ms-5 me-5">
      <textarea class="p-0 form-control form-control-flush" id="txa-sticky-note" data-kt-autosize="true" placeholder="Note" data-kt-initialized="1" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 44px;"></textarea>
   </div>
</div>
<!--end::Main-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
   <i class="ki-duotone ki-arrow-up">
   <span class="path1"></span>
   <span class="path2"></span>
   </i>
</div>

<!--end::Scrolltop-->
<!--begin::Javascript-->
<!--begin::Language-->
<script src="{{ asset('assets/admin/language.js') }}?v={{ filemtime(public_path('assets/admin/language.js')) }}"></script>
<script>
    var adminLanguage = String(
        @json(Auth::user()?->lang) || document.documentElement.getAttribute('lang') || 'en'
    ).toLowerCase().split('-')[0];
    var catalog = adminLanguage === 'vi' ? LANGUAGE.language : LANGUAGE.core;
    var path = window.location.pathname.split('/'), page = `/${path[2] || ''}`;

    // app.js reads LANGUAGE.language for dynamic toast/modal messages.
    LANGUAGE.language = catalog;

    document.querySelectorAll('[data-lang]').forEach(function (element) {
        var currentPage = element.getAttribute('data-page') || page;
        var key = element.getAttribute('data-lang') || element.innerText.trim();
        var parts = key.includes('::') ? key.split('::') : [];
        var group = parts.length > 1 ? parts[0] : currentPage;
        var lookupKey = parts.length > 1 ? parts.slice(1).join('::') : key;
        var value = catalog?.[group]?.[key]
            || catalog?.[group]?.[lookupKey]
            || LANGUAGE.core?.[group]?.[key]
            || LANGUAGE.core?.[group]?.[lookupKey]
            || key;

        if (element.matches('input, textarea')) {
            if (element.hasAttribute('value')) element.value = value;
            else if (element.hasAttribute('placeholder')) element.placeholder = value;
        } else if (element.getAttribute('data-bs-toggle') === 'tooltip') {
            element.setAttribute('title', value);
            element.setAttribute('aria-label', value);
            element.setAttribute('data-bs-original-title', value);
        } else {
            element.innerHTML = value;
        }
    });
</script>
<!--end::Language-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/admin/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('cdn.whoispanel.com/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/1/plugins/custom/jqueryui/jquery-ui.js') }}?v=2"></script>
<script src="{{ asset('cdn.whoispanel.com/1/plugins/custom/uploadfile/jquery.uploadfile.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/libs/Sortable/1.15.0/Sortable.min.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/libs/jquery.blockUI/2.70/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/libs/popper.js/2.9.2/umd/popper.min.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/libs/interact.js/1.10.27/interact.min.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/libs/gsap/3.12.5/gsap.min.js') }}"></script>
<!--end::Vendors Javascript-->
<script src="{{ asset('assets/app.js') }}?v={{ config('app.version') }}"></script>
<script src="{{ asset('assets/admin/admin.js') }}?v={{ config('app.version') }}"></script>
@stack('scripts')
<!--end::Javascript-->

{{-- Webhook notifications are intentionally rendered in the admin area only. --}}
@if ($adminNotice)
    <div class="modal fade" tabindex="-1" id="admin-webhook-notification" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="admin-webhook-notification-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <div class="modal-content">
                @if ($adminNotice['title'] !== '')
                    <div class="modal-header py-4">
                        <h4 class="modal-title" id="admin-webhook-notification-title">{{ $adminNotice['title'] }}</h4>
                    </div>
                @endif
                <div class="modal-body ql-editor">{!! $adminNotice['content'] !!}</div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function () {
            var key = 'admin_webhook_notice_read';
            var version = @json($adminNotice['version']);
            if (window.localStorage.getItem(key) === version) return;

            window.addEventListener('load', function () {
                var modal = document.getElementById('admin-webhook-notification');
                if (modal && window.bootstrap?.Modal) {
                    bootstrap.Modal.getOrCreateInstance(modal).show();
                } else if (window.jQuery) {
                    $('#admin-webhook-notification').modal('show');
                }
                modal?.addEventListener('hidden.bs.modal', function () {
                    window.localStorage.setItem(key, version);
                }, { once: true });
            });
        })();
    </script>
@endif

{{-- Admin accounts must enable 2FA before continuing to use the panel. --}}
@if (Auth::check() && Auth::user()->isAdmin() && !Auth::user()->hasTwoFactorEnabled())
    <div class="modal fade" tabindex="-1" id="modal-enable-2fa" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="modal-enable-2fa-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <div class="modal-content">
                <div class="modal-body text-danger fw-bolder fs-1 p-10 text-center">
                    <p class="mb-10" id="modal-enable-2fa-title" data-page="message"
                        data-lang="Please enable 2FA for account security!">
                        Vui lòng kích hoạt 2FA để bảo mật tài khoản!
                    </p>
                    <a href="{{ url('/settings') }}" class="btn btn-outline btn-outline-primary text-uppercase btn-sm"
                        data-page="message" data-lang="Enable now">
                        Kích hoạt ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function () {
            var modal = document.getElementById('modal-enable-2fa');
            if (modal && window.bootstrap?.Modal) {
                bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        });
    </script>
@endif
</body>
<!--end::Body-->
</html>
