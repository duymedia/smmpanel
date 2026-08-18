<div id="notify-wrapper" class="alert alert-success mb-3 hidden" style="display: none;"></div>

<script type="text/javascript" src="https://storage.perfectcdn.com/global/6k54ozpzw8o83xr3.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/jq8derbjf313z5ai.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/wnz4cikxqalrs02w.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/0ud5szi4ocdmm9ep.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/w9z8nk0wkyg9w246.js"></script>

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

@stack('scripts')

<!-- Event Component -->
@include('clients.theme-default.layouts.event')

</body>

</html>
