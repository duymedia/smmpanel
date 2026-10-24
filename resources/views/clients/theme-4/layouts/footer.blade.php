<div id="notify-wrapper" class="alert alert-success mb-3 hidden" style="display: none;"></div>

<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-4/global/6k54ozpzw8o83xr3.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-4/global/jq8derbjf313z5ai.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-4/global/wnz4cikxqalrs02w.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-4/global/0ud5szi4ocdmm9ep.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-4/global/w9z8nk0wkyg9w246.js') }}"></script>

<script type="text/javascript">
    window.modules.select = [];
</script>
<script type="text/javascript">
    window.modules.alerts = {
        "alerts": []
    };
</script>

<script>
// Shared currency switcher
function initCurrencySwitcher(updateUrl, csrfToken) {
    const items   = document.querySelectorAll('.currencies-item');
    const display = document.getElementById('balance-display');
    if (!display || !items.length) return;

    items.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            if (this.classList.contains('active')) return;

            const { currencyCode, currencySymbol, currencyName, symbolPosition } = this.dataset;

            fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ currency_code: currencyCode, currency_symbol: currencySymbol, currency_name: currencyName })
            })
            .then(r => r.json())
            .then(res => {
                if (!res.success) return;
                const zero = ['VND','JPY','KRW'].includes(currencyCode) ? '0' : '0.00';
                display.textContent = res.data?.formatted_balance ||
                    (symbolPosition === 'before' ? currencySymbol + zero : zero + ' ' + currencySymbol);
                items.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                setTimeout(() => window.location.reload(), 500);
            })
            .catch(err => console.error('Currency update error:', err));
        });
    });
}
</script>

<script src="{{ asset('storage.perfectcdn.com/theme-4/global/language.js') }}?v={{ filemtime(public_path('assets/client/language.js')) }}"></script>
<script>
(function () {
    function startLanguage() {
        if (typeof LANGUAGE === 'undefined') return;
        var lang = localStorage.getItem('data-lang') || @json(auth()->user()?->lang ?? app()->getLocale() ?? 'en');
        var catalog = lang === 'vi' ? LANGUAGE.language : LANGUAGE.core;
        var path = window.location.pathname.replace(/\/$/, '') || '/';
        var reverse = {};
        Object.keys(catalog || {}).forEach(function (group) {
            Object.keys(catalog[group] || {}).forEach(function (key) {
                var value = String(catalog[group][key]);
                if (value && !reverse[value]) reverse[value] = key.indexOf('::') >= 0 ? key : group + '.' + key;
            });
        });
        document.querySelectorAll('[data-lang]').forEach(function (el) {
            var key = el.getAttribute('data-lang');
            var parts = key.indexOf('::') >= 0 ? key.split('::') : key.split('.');
            var group = parts.length > 1 ? parts[0] : path;
            var shortKey = parts.length > 1 ? parts.slice(1).join('::') : key;
            var value = (catalog[group] && (catalog[group][key] || catalog[group][shortKey])) ||
                (catalog.menu && (catalog.menu[key] || catalog.menu[shortKey]));
            if (value) el.innerHTML = value;
        });
        document.querySelectorAll('body *:not(script):not(style)').forEach(function (el) {
            if (el.children.length || el.hasAttribute('data-lang')) return;
            var text = el.textContent.trim();
            var key = reverse[text];
            if (!key) return;
            var parts = key.indexOf('::') >= 0 ? key.split('::') : key.split('.');
            var value = parts.length > 1 && catalog[parts[0]] ? catalog[parts[0]][parts.slice(1).join('::')] : null;
            if (value) { el.setAttribute('data-lang', key); el.innerHTML = value; }
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startLanguage); else startLanguage();
})();
</script>@stack('scripts')

<!-- Event Component -->
@include('clients.theme-4.layouts.event')

</body>

</html>
