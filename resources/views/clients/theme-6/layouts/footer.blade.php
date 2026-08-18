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
<!-- End SF Tag -->

<!-- End Slashdot Tag -->

<script type="text/javascript" src="https://storage.perfectcdn.com/global/niz1noemjyzfu7f9.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/hecwkrtjf5h4271l.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/9slt7wawt5z76g0n.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/zapdpw5dch3izybt.js"></script>
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

document.addEventListener('DOMContentLoaded', function () {
    initCurrencySwitcher(
        '{{ route('clients.account.update-currency') }}',
        '{{ csrf_token() }}'
    );
});
</script>
@stack('scripts')
</body>

</html>
