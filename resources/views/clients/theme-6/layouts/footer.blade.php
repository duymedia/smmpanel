</div>
            </div>
            <div class="wrapper-content__footer">
</div>
</div>
</div>
<!-- Notifications wrapper -->
<div id="notify-wrapper" class="alert alert-success mb-3 hidden" style="display: none;"></div>


<script>
    (function() {
        var sc = document.createElement('script');
        sc.async = true;
        sc.src = 'https://b.sf-syn.com/badge_js?sf_id=3930786&variant_id=sf';
        var p = document.getElementsByTagName('script')[0];
        p.parentNode.insertBefore(sc, p);
    })();
</script>

<!-- JS (local) -->
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/qoy6usyny80ul09k.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/f7lw81wrmhzxhpb3.js') }}"></script>

<script type="text/javascript">
    <?php echo 'window.modules.layouts = ' . json_encode(['theme_id' => 24, 'auth' => 1, 'live' => true, 'csrftoken' => csrf_token()]) . ';'; ?>
</script>
<script type="text/javascript">
    window.modules.select = [];
</script>
<script type="text/javascript">
    window.modules.user_app_show_config = [];
</script>
<script type="text/javascript">
    window.modules.alerts = {
        "alerts": []
    };
</script>
<script type="text/javascript"></script>
<script>
    // Shared currency switcher — dùng cho mọi theme
    function initCurrencySwitcher(updateUrl, csrfToken) {
        const items = document.querySelectorAll('.currencies-item');
        const display = document.getElementById('balance-display');
        if (!display || !items.length) return;

        items.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                if (this.classList.contains('active')) return;

                const {
                    currencyCode,
                    currencySymbol,
                    currencyName,
                    symbolPosition
                } = this.dataset;

                fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.content || csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            currency_code: currencyCode,
                            currency_symbol: currencySymbol,
                            currency_name: currencyName
                        })
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) return;
                        const zero = ['VND', 'JPY', 'KRW'].includes(currencyCode) ? '0' : '0.00';
                        display.textContent = res.data?.formatted_balance ||
                            (symbolPosition === 'before' ? currencySymbol + zero : zero + ' ' +
                                currencySymbol);
                        items.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                        setTimeout(() => window.location.reload(), 500);
                    })
                    .catch(err => console.error('Currency update error:', err));
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCurrencySwitcher(
            '{{ route('clients.account.update-currency') }}',
            '{{ csrf_token() }}'
        );
    });
</script>
<script src="{{ asset('assets/client/language.js') }}?v={{ filemtime(public_path('assets/client/language.js')) }}"></script>
<script>
    (function () {
        var path = window.location.pathname.split('/'), page = `/${path[1] || ''}`;
        var userLang = @json(auth()->user()?->lang ?? 'en');
        var storageLang = localStorage.getItem('data-lang');
        var lang = storageLang || userLang;
        var languageGroup = lang === 'vi' ? LANGUAGE.language : LANGUAGE.core;
        var langs = document.querySelectorAll('[data-lang]');
        for (var i = 0; i < langs.length; i++) {
            var pagee = page;
            if (langs[i].getAttribute('data-page') != null)
                pagee = langs[i].getAttribute('data-page');

            var key = langs[i].getAttribute('data-lang');
            key = key == '' ? langs[i].innerText.trim() : key;
            var parts = key.includes('::') ? key.split('::') : [];
            // Resolve dotted theme keys (e.g. orders.request_cancel) using
            // the same group structure as the language JSON catalog.
            var group = parts.length > 1 ? parts[0] :
                (key.includes('.') ? key.split('.')[0] : (key.startsWith('navbar.') ? 'menu' : pagee));
            var shortKey = parts.length > 1 ? parts.slice(1).join('::') : (key.includes('.') ? key.substring(key.indexOf('.') + 1) : key);
            var value = languageGroup?.[group]?.[key]
                || languageGroup?.[group]?.[shortKey]
                || languageGroup?.['menu']?.[key]
                || languageGroup?.['menu']?.[shortKey]
                || languageGroup?.[pagee]?.[key]
                || languageGroup?.[pagee]?.[shortKey]
                || key;
            if (langs[i].tagName == 'INPUT' || langs[i].tagName == 'TEXTAREA') {
                if (langs[i].hasAttribute('value')) {
                    langs[i].value = value;
                } else if (langs[i].hasAttribute('placeholder')) {
                    langs[i].setAttribute('placeholder', value);
                }
            } else {
                langs[i].innerHTML = value;
            }
        }
    })();
</script>
<script>
    // Keep the same active-state behaviour as the downloaded DaoSMM shell.
    document.addEventListener('DOMContentLoaded', function () {
        var path = window.location.pathname.replace(/\/$/, '') || '/';
        document.querySelectorAll('.component-sidebar__menu-item-link, .component-navbar-nav-link').forEach(function (link) {
            var href = link.getAttribute('href');
            if (!href || href.charAt(0) !== '/') return;
            var target = href.replace(/\/$/, '') || '/';
            if (target === path || (target !== '/' && path.indexOf(target + '/') === 0)) {
                link.classList.add('component-navbar-nav-link-active__navbar-private');
                var item = link.closest('.component-sidebar__menu-item');
                if (item) item.classList.add('component-sidebar__menu-item-active');
            }
        });
    });
</script>@stack('scripts')
</body>

</html>
