<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-xxl d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2026 ©</span>
            <a href="https://{{ getDomain() }}" target="_blank"
                class="text-gray-800 text-hover-primary">{{ $config->title ?? '' }}</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        var currentDomain = window.location.hostname;
        document.querySelectorAll('a[href]').forEach(function(link) {
            try {
                var url = new URL(link.href, window.location.origin);
                var href = link.getAttribute('href') || '';
                if (url.hostname !== currentDomain && href !== '' && href !== '#' && !href.startsWith(
                        'javascript')) {
                    link.href = '/anonym?url=' + encodeURIComponent(link.href);
                }
            } catch (e) {}
        });
    });
</script>
<script src="{{ asset('assets/client/language.js') }}?v={{ filemtime(public_path('assets/client/language.js')) }}"></script>
<script>
    // language.js exposes the same grouped catalog used by t.html. The
    // layout already renders the user's language on <html>; use that value
    // instead of localStorage or a second default here.
    var lang = (document.documentElement.getAttribute('lang') || '').toLowerCase().split('-')[0];
    var catalog = lang === 'vi' ? LANGUAGE.language : LANGUAGE.core;
    var path = window.location.pathname.split('/'), page = `/${path[1] || ''}`;
    LANGUAGE.language = catalog;
    var langs = document.querySelectorAll('[data-lang]');
    for (var i = 0; i < langs.length; i++) {
        var pagee = page;
        if (langs[i].getAttribute('data-page') != null)
            pagee = langs[i].getAttribute('data-page');

        var key = langs[i].getAttribute('data-lang');
        key = key == '' ? langs[i].innerText.trim() : key;
        path = key.includes('::') ? key.split('::')[0] : pagee;
        var lookupKey = key;
        if (!key.includes('::') && key.includes('.')) {
            var keyParts = key.split('.');
            path = keyParts.shift();
            lookupKey = keyParts.join('.');
        }
        var value = catalog?.[path]?.[key]
            || catalog?.[path]?.[lookupKey]
            || LANGUAGE.core?.[path]?.[key]
            || LANGUAGE.core?.[path]?.[lookupKey]
            || key;
        if (langs[i].tagName == 'INPUT' || langs[i].tagName == 'TEXTAREA') {
            var translateAttribute = langs[i].getAttribute('data-lang-attr');
            if (translateAttribute) {
                langs[i].setAttribute(translateAttribute, value);
            } else if (langs[i].hasAttribute('value')) {
                langs[i].value = value;
            } else if (langs[i].hasAttribute('placeholder')) {
                langs[i].setAttribute('placeholder', value)
            }
        } else {
            langs[i].innerHTML = value;
        }
    }
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

<script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<script src="{{ asset('cdn.whoispanel.com/libs/jquery.blockUI/2.70/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('assets/app.js') }}?v=16.8"></script>

<script src="{{ asset('assets/client/dashboard.js') }}?v={{ filemtime(public_path('assets/client/dashboard.js')) }}"></script>
<script src="{{ asset('assets/client/settings.js') }}?v={{ filemtime(public_path('assets/client/settings.js')) }}"></script>
<script src="{{ asset('assets/client/childpanel.js') }}?v={{ filemtime(public_path('assets/client/childpanel.js')) }}"></script>
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
