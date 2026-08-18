<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-xxl d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2026 ©</span>
            <a href="https://{{ getDomain() }}" target="_blank" class="text-gray-800 text-hover-primary">{{ $config->title ?? '' }}</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="/" target="_blank" class="menu-link px-2">Home</a>
            </li>
            <li class="menu-item">
                <a href="/terms" target="_blank" class="menu-link px-2">Term</a>
            </li>
            <li class="menu-item">
                <a href="/faqs" target="_blank" class="menu-link px-2">FAQs</a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div> <!--end::Footer-->
</div>
</div>
<!--end::Container-->
</div>
<!--end::Page-->
</div>
<!--end::Root-->
<!--begin::Drawers-->


<!--end::Drawers-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>
</div>
<!--end::Scrolltop-->
<!--begin::Javascript-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentDomain = window.location.hostname;
        document.querySelectorAll('a[href]').forEach(function (link) {
            try {
                var url = new URL(link.href, window.location.origin);
                var href = link.getAttribute('href') || '';
                if (url.hostname !== currentDomain && href !== '' && href !== '#' && !href.startsWith('javascript')) {
                    link.href = '/anonym?url=' + encodeURIComponent(link.href);
                }
            } catch (e) {}
        });
    });
</script>
</script>
<script>
(function () {
    var lang = document.documentElement.lang;
    var SL   = '{{ auth()->user()?->lang ?? ($config->default_lang ?? "en") }}';
    var SD   = @json($langData ?? []);
    var hasSD = SD && Object.keys(SD).length > 0;

    // Cache serverData để dùng cho lần sau
    if (hasSD) sessionStorage.setItem('lang_' + SL, JSON.stringify(SD));

    // Đã apply sớm từ head (sessionStorage cache)
    if (window.__langApplied) return;

    // Server render đúng lang
    if (lang === SL && hasSD) { window.__applyLang(SD); return; }

    // sessionStorage cache (lang khác server)
    var c = sessionStorage.getItem('lang_' + lang);
    if (c) try { window.__applyLang(JSON.parse(c)); return; } catch (e) {}

    // Fetch — ẩn [data-lang] tránh flash raw key
    var s = document.createElement('style');
    s.id = '__lh'; s.textContent = '[data-lang]{visibility:hidden}';
    document.head.appendChild(s);
    fetch('/lang/' + lang + '.json')
        .then(function (r) { return r.ok ? r.json() : null; })
        .then(function (d) {
            var data = d || (hasSD ? SD : null);
            if (data) { sessionStorage.setItem('lang_' + lang, JSON.stringify(data)); window.__applyLang(data); }
        })
        .catch(function () { if (hasSD) window.__applyLang(SD); })
        .finally(function () { var el = document.getElementById('__lh'); if (el) el.remove(); });
})();
</script>
<script async="" src="https://www.googletagmanager.com/gtag/js?id=G-EYDFWT3TGZ"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-EYDFWT3TGZ');
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/dashboard/5/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Vendors Javascript-->
<!-- <script src="https://kit.fontawesome.com/706d20f321.js" crossorigin="anonymous"></script> -->
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="{{ asset('assets/app.js') }}"></script>
<script src="{{ asset('assets/client/dashboard.js') }}"></script>
<script>
    typeof _new !== 'undefined' && typeof _new.init !== 'undefined' && _new.init();
</script>
<script src="{{ asset('js/loader.js') }}"></script>
@stack('scripts')
<div class="daterangepicker ltr single opensright">
    <div class="ranges"></div>
    <div class="drp-calendar left single" style="display: block;">
        <div class="calendar-table"></div>
        <div class="calendar-time"></div>
    </div>
    <div class="drp-calendar right" style="display: none;">
        <div class="calendar-table"></div>
        <div class="calendar-time"></div>
    </div>
    <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default"
            type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled"
            type="button">Apply</button> </div>
</div>
</body><!--end::Body-->
</html>
