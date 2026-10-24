    @extends('clients.theme-default.layouts.app')
    @section('title', 'Add Funds')

    @section('content')
        <div class="content flex-column-fluid" id="kt_content">
            <!--begin::Toolbar-->
            @include('clients.theme-default.layouts.toolbar', [
                'title' => 'Add Funds',
                'langKey' => 'Add funds',
            ])
            <!--end::Toolbar-->

            <!--begin::Post-->
            <div class="post" id="kt_post">
                <div class="row g-5 mb-5">

                    {{-- Card 1: Hạng thành viên --}}
                    <div class="col-md-4 col-12">
                        <div class="card border-hover-primary h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <div class="d-flex flex-column">
                                    <span
                                        class="fw-bold fs-2x lh-1 ls-2">{{ match (auth()->user()->role) {1 => 'Admin',6 => 'Nhân viên',4 => 'Đại lý',5 => 'Nhà phân phối',default => 'Khách lẻ'} }}</span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-7 text-gray-500" data-lang="Member Level">Hạng
                                            thành viên</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Tổng tiền nạp --}}
                    <div class="col-md-4 col-12">
                        <div class="card border-hover-primary h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <div class="d-flex flex-column">
                                    <span class="text-primary fw-bold fs-2x lh-1 ls-2">
                                        @php
                                            $totalDeposit = $transactions->where('status', 'completed')->sum(function ($t) {
                                                return $t->exchange_rate > 0 ? $t->amount / $t->exchange_rate : $t->amount;
                                            });
                                        @endphp
                                        {{ formatCurrencyAmount($totalDeposit, $currency, $nonDecimalCodes) }}
                                    </span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-7 text-gray-500" data-lang="Total deposit">Tổng
                                            tiền nạp</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Tổng tiền thưởng --}}
                    <div class="col-md-4 col-12">
                        <div class="card border-hover-primary h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <div class="d-flex flex-column">
                                    <span class="text-warning fw-bold fs-2x lh-1 ls-2">
                                        @php
                                            $totalBonus = $transactions->where('status', 'completed')->sum(function ($t) {
                                                return $t->exchange_rate > 0
                                                    ? $t->bonus_amount / $t->exchange_rate
                                                    : $t->bonus_amount;
                                            });
                                        @endphp
                                        {{ formatCurrencyAmount($totalBonus, $currency, $nonDecimalCodes) }}
                                    </span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-7 text-gray-500" data-lang="Total bonus">Tổng tiền
                                            thưởng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Col trái: Chọn phương thức --}}
                    <div class="col-md-5 col-12">
                        <div class="card">
                            <div class="card-body">

                                {{-- Select phương thức thanh toán --}}
                                <div class="mb-3">
                                    <label for="sl-pm-method" class="form-label" data-lang="Choose method">Phương thức
                                        thanh toán</label>
                                    <select id="sl-pm-method" class="form-select form-select-solid"
                                        onchange="_addfunds.on.change.method()">
                                        <option value="0" data-lang="Please select">Vui lòng chọn</option>
                                        @forelse($payments as $payment)
                                            @php
                                                $bonus = is_string($payment->bonus)
                                                    ? json_decode($payment->bonus, true)
                                                    : $payment->bonus;
                                                $hasBonus = is_array($bonus)
                                                    ? collect($bonus)->contains(fn($tier) => !empty($tier['percent']))
                                                    : !empty($bonus);
                                                $label = $payment->name;
                                                $rate = $payment->parsed_config['rate'] ?? '';
                                            @endphp
                                            <option value="{{ $payment->id }}" data-type="{{ $payment->type }}"
                                                data-icon="{{ $payment->image_url ?? ($payment->image ?? '') }}"
                                                data-has-bonus="{{ $hasBonus ? '1' : '0' }}"
                                                data-currency="{{ $payment->currency }}" data-rate="{{ $rate }}">
                                                {{ $label }}
                                            </option>
                                        @empty
                                            <option value="0" disabled>No payment methods available</option>
                                        @endforelse
                                    </select>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        function addFundsText(key) {
                                            return catalog?.['/addfunds']?.[key] ||
                                                LANGUAGE.core?.['/addfunds']?.[key] ||
                                                key;
                                        }

                                        $('#sl-pm-method').select2({
                                            escapeMarkup: function(markup) {
                                                return markup;
                                            },
                                            minimumResultsForSearch: -1,
                                            templateResult: formatPaymentMethod,
                                            templateSelection: formatPaymentMethod,
                                            width: '100%'
                                        });

                                        function updateCurrencyConversion() {
                                            var value = parseFloat($('.ipt-currency-value').val()) || 0;
                                            var rate = parseFloat($('.ipt-currency-rate').val()) || 1;
                                            $('#ipt-fund-amount').val(value ? (value / rate).toFixed(3).replace(/\.?0+$/, '') : '');
                                        }

                                        $('.ipt-currency-value, .ipt-currency-rate').on('input', updateCurrencyConversion);

                                        function formatPaymentMethod(option) {
                                            if (!option.element) return option.text;

                                            const icon = option.element.dataset.icon;
                                            const hasBonus = option.element.dataset.hasBonus === '1';
                                            if (!icon && !hasBonus) return option.text;

                                            const $method = $('<span class="d-inline-flex align-items-center flex-wrap"></span>');
                                            if (icon) {
                                                $('<img>', {
                                                    src: icon,
                                                    alt: '',
                                                    class: 'rounded-circle h-20px me-2'
                                                }).appendTo($method);
                                            }
                                            $('<span></span>').text(option.text).appendTo($method);
                                            if (hasBonus) {
                                                $('<span class="ms-1" data-lang="Bonus available"></span>')
                                                    .text('(' + addFundsText('Bonus available') + ')')
                                                    .appendTo($method);
                                            }

                                            return $method;
                                        }

                                        $('#sl-pm-method').on('change.binance', function() {
                                            var selectedOption = $('#sl-pm-method option:selected');
                                            var pmType = String(selectedOption.data('type') || '').toLowerCase();
                                            var pmId = this.value;
                                            var pm = (window.PAYMENT_METHODS || []).find(function(method) {
                                                return String(method.id) === String(pmId);
                                            });
                                            var paymentCurrency = String((pm && pm.currency) || selectedOption.data('currency') || '')
                                                .toUpperCase();
                                            var needsVndTransferCode = paymentCurrency === 'VND' &&
                                                !String(window.TRANSFER_CODE || '').trim();

                                            $('.vnd-transfer-note').toggle(paymentCurrency === 'VND');
                                            $('#vnd-transfer-code-required').hide();
                                            $('#pm-separator, .div-currency, .div-fund-amount').hide();
                                            $('.div-minmax').show();
                                            $('.div-rate, .div-bonus').hide();

                                            if (pm) {
                                                $('.div-rate').toggle(Number(pm.rate) > 0);
                                                $('.div-bonus').toggle(
                                                    Number(pm.bonus) === 1 &&
                                                    Array.isArray(pm.bonus_data) &&
                                                    pm.bonus_data.length > 0
                                                );
                                            }

                                            if (pmType === 'binance' || pmType === 'crypto') {
                                                window._currentBinancePm = pm || null;
                                                $('#ipt-binance-pm-id').val(pmId);

                                                if (pm) {
                                                    $('#fund-amount-currency').text(pm.currency || 'USD');
                                                    $('#binance-id-display-value').text(pm.binance_id || '');
                                                    $('#pm-separator').show();
                                                }
                                            } else {
                                                window._currentBinancePm = null;
                                                $('#ipt-binance-pm-id').val('');
                                                $('#binance-id-display-value').text('');


                                                if (pm && Number(pm.pma_id) === 0) {
                                                    $('.div-options.div-36').find('[name="PM_ID"]').val(pmId);
                                                    $('.div-options.div-36').show();
                                                } else if (pmId !== '0' && paymentCurrency) {
                                                    $('#pm-separator').show();
                                                    $('#fund-amount-currency').text('USD');

                                                    if (paymentCurrency !== 'USD') {
                                                        $('.currency-symbol').text(paymentCurrency);
                                                        $('.ipt-currency-rate').val(parseFloat(pm && pm.rate) || 1);
                                                        if (paymentCurrency !== 'VND') {
                                                            $('.div-currency').show();
                                                        }
                                                    }
                                                }
                                            }

                                            if (needsVndTransferCode) {
                                                $('.div-options').hide();
                                                $('#pm-separator').show();
                                                $('.div-minmax').hide();
                                                $('#vnd-transfer-code-required').show();
                                            }

                                            $('.div-fund-amount').toggle(paymentCurrency === 'USD');
                                        });

                                        const transferCodeForm = document.getElementById('vnd-transfer-code-form');
                                        if (transferCodeForm) {
                                            transferCodeForm.addEventListener('submit', async function(event) {
                                                event.preventDefault();
                                                const nameInput = document.getElementById('vnd-transfer-code-name');
                                                const submitButton = this.querySelector('button[type="submit"]');
                                                const message = document.getElementById('vnd-transfer-code-message');
                                                const name = nameInput.value.trim();

                                                if (!name) {
                                                    message.textContent = addFundsText('Please enter your bank account name.');
                                                    message.classList.remove('hidden');
                                                    nameInput.focus();
                                                    return;
                                                }

                                                message.classList.add('hidden');
                                                submitButton.disabled = true;
                                                try {
                                                    const response = await fetch(@json(url('/account/update-name')), {
                                                        method: 'POST',
                                                        headers: {
                                                            'Accept': 'application/json',
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector(
                                                                'meta[name="csrf-token"]')?.content || ''
                                                        },
                                                        body: JSON.stringify({ name })
                                                    });
                                                    const result = await response.json();
                                                    if (!response.ok || !result.success) {
                                                        throw new Error(result.message || addFundsText(
                                                            'Unable to save your bank account name.'));
                                                    }

                                                    window.TRANSFER_CODE = result.transfer_code || name;
                                                    window.location.reload();
                                                } catch (error) {
                                                    message.textContent = error.message || addFundsText(
                                                        'Unable to save your bank account name.');
                                                    message.classList.remove('hidden');
                                                } finally {
                                                    submitButton.disabled = false;
                                                }
                                            });
                                        }

                                        const modalElement = document.getElementById('binance-qr-modal');
                                        const primaryButton = document.getElementById('binance-primary-btn');
                                        if (!modalElement || !primaryButton) return;
                                        const closeButton = modalElement.querySelector('.binance-btn-close');
                                        let paymentVerified = false;
                                        let reloadAfterClose = false;

                                        const modalField = function(selector) {
                                            return modalElement.querySelector(selector);
                                        };
                                        const amountValue = modalField('#binance-top-step1 .binance-amount-value');
                                        const amountSummary = modalField('#binance-top-step2 .binance-amount-value');
                                        const currencyValues = modalElement.querySelectorAll('.binance-currency-value');
                                        const uuidInput = modalField('#binance-uuid-input');
                                        const uuidSummary = modalField('#binance-uuid-value');
                                        const orderIdInput = modalField('#binance-order-id');
                                        const step1 = modalField('#binance-top-step1');
                                        const step2 = modalField('#binance-top-step2');
                                        const stepNumber1 = modalField('#step-1');
                                        const stepNumber2 = modalField('#step-2');
                                        const qrImage = modalField('#binance-qr-code-image');
                                        const error = modalField('.binance-alert-danger');
                                        const success = modalField('.binance-alert-success');
                                        const copyButton = modalField('#copy-uuid-1');
                                        const copySummaryButton = modalField('#copy-uuid-2');

                                        if (!amountValue || !amountSummary || currencyValues.length < 2 ||
                                            !uuidInput || !uuidSummary || !orderIdInput || !step1 || !step2 ||
                                            !stepNumber1 || !stepNumber2 || !qrImage || !error || !success ||
                                            !copyButton || !copySummaryButton) return;

                                        // Binance Check → Open Modal with QR
                                        $('#btn-binance-check').on('click', function() {
                                            var pm = window._currentBinancePm;
                                            if (!pm) return;

                                            var amount = $('#ipt-fund-amount').val() || '0';
                                            if (!amount || parseFloat(amount) <= 0) {
                                                alert(addFundsText('Invalid amount'));
                                                return;
                                            }

                                            // Store amount and PM for modal
                                            window._binanceCheckoutData = {
                                                pm_id: $('#ipt-binance-pm-id').val(),
                                                amount: amount,
                                                currency: pm.binance_currency || 'USDT',
                                                method_type: pm.type || 'binance',
                                                binance_id: pm.binance_id || '',
                                                qr_image: pm.qr_image || ''
                                            };

                                            openBinanceQrModal(window._binanceCheckoutData);
                                        });

                                        function openBinanceQrModal(checkout) {
                                            const binanceId = checkout.binance_id || '';
                                            const currencyLabel = String(checkout.currency || 'USDT').toUpperCase();

                                            amountValue.textContent = checkout.amount;
                                            amountSummary.textContent = checkout.amount;
                                            currencyValues[0].textContent = currencyLabel;
                                            currencyValues[1].textContent = currencyLabel;
                                            uuidInput.value = binanceId;
                                            uuidSummary.textContent = binanceId;
                                            orderIdInput.value = '';
                                            step1.classList.remove('hidden');
                                            step2.classList.add('hidden');
                                            stepNumber1.classList.add('active');
                                            stepNumber2.classList.remove('active');
                                            error.classList.add('hidden');
                                            error.querySelector('.binance-alert-content').textContent = '';
                                            success.classList.add('hidden');
                                            success.querySelector('.binance-alert-content').textContent = '';
                                            primaryButton.textContent = addFundsText('Confirm payment');
                                            primaryButton.setAttribute('data-lang', 'Confirm payment');
                                            primaryButton.disabled = false;
                                            window._binanceModalStep = 1;
                                            paymentVerified = false;
                                            reloadAfterClose = false;

                                            qrImage.onerror = function() {
                                                qrImage.classList.add('hidden');
                                                qrImage.removeAttribute('src');
                                            };

                                            if (checkout.qr_image) {
                                                qrImage.src = checkout.qr_image;
                                                qrImage.classList.remove('hidden');
                                            } else {
                                                qrImage.removeAttribute('src');
                                                qrImage.classList.add('hidden');
                                            }

                                            bootstrap.Modal.getOrCreateInstance(modalElement).show();
                                        }

                                        if (closeButton) {
                                            closeButton.addEventListener('click', function() {
                                                reloadAfterClose = true;
                                            });
                                        }
                                        modalElement.addEventListener('hidden.bs.modal', function() {
                                            if (reloadAfterClose) window.location.reload();
                                        });

                                        primaryButton.addEventListener('click', async function() {
                                            const checkout = window._binanceCheckoutData;
                                            if (!checkout) return;
                                            if (paymentVerified) {
                                                window.location.reload();
                                                return;
                                            }

                                            if (window._binanceModalStep === 1) {
                                                window._binanceModalStep = 2;
                                                step1.classList.add('hidden');
                                                step2.classList.remove('hidden');
                                                stepNumber1.classList.remove('active');
                                                stepNumber2.classList.add('active');
                                                this.textContent = addFundsText('Verify Payment');
                                                this.setAttribute('data-lang', 'Verify Payment');
                                                orderIdInput.focus();
                                                return;
                                            }

                                            const orderId = orderIdInput.value.trim();
                                            const errorContent = error.querySelector('.binance-alert-content');
                                            const successContent = success.querySelector('.binance-alert-content');
                                            if (!orderId) {
                                                errorContent.textContent = addFundsText('Enter an Order ID from Binance');
                                                error.classList.remove('hidden');
                                                return;
                                            }

                                            error.classList.add('hidden');
                                            success.classList.add('hidden');
                                            this.disabled = true;

                                            try {
                                                if (!checkout.prepared) {
                                                    const checkoutResponse = await fetch(@json(url('/request')), {
                                                        method: 'POST',
                                                        headers: {
                                                            'Accept': 'application/json',
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector(
                                                                'meta[name="csrf-token"]').content
                                                        },
                                                        body: JSON.stringify({
                                                            action: 'Addfunds-createCheckout',
                                                            pm_id: checkout.pm_id,
                                                            amount: checkout.amount
                                                        })
                                                    });
                                                    const checkoutResult = await checkoutResponse.json();

                                                    if (!checkoutResponse.ok || !checkoutResult.success) {
                                                        throw new Error(checkoutResult.message || addFundsText(
                                                            'Unable to create Binance checkout.'));
                                                    }

                                                    checkout.prepared = true;
                                                }

                                                const endpoint = new URL(@json(url('/cron/binance/transactions')), window.location.origin);
                                                const params = {
                                                    orderId,
                                                    amount: checkout.amount,
                                                    user_id: String(@json(auth()->id()))
                                                };
                                                if (checkout.checkout_id) {
                                                    params.checkout_id = String(checkout.checkout_id);
                                                }
                                                endpoint.search = new URLSearchParams(params).toString();

                                                const response = await fetch(endpoint, {
                                                    headers: {
                                                        'Accept': 'application/json'
                                                    }
                                                });
                                                const result = await response.json();

                                                if (!response.ok || !result.success) {
                                                    const message = String(result.message || '');
                                                    const displayMessage = message.includes('API Key') || message.includes(
                                                            'Secret Key') ?
                                                        addFundsText('Payment not found. Check if the Order ID is correct.') :
                                                        (message || 'Không thể xác minh giao dịch Binance.');
                                                    throw new Error(displayMessage);
                                                }

                                                successContent.textContent = addFundsText('Payment verified successfully');
                                                success.classList.remove('hidden');
                                                paymentVerified = true;
                                                this.textContent = addFundsText('Done');
                                                this.setAttribute('data-lang', 'Done');
                                            } catch (exception) {
                                                const connectionError = exception.message === 'Failed to fetch';
                                                errorContent.textContent = connectionError ?
                                                    addFundsText('Connection error. Please try again.') :
                                                    (exception.message || addFundsText('Connection error. Please try again.'));
                                                error.classList.remove('hidden');
                                            } finally {
                                                this.disabled = false;
                                            }
                                        });

                                        const binanceForm = document.getElementById('binance-form');
                                        if (binanceForm) binanceForm.addEventListener('submit', function(event) {
                                            event.preventDefault();
                                        });

                                        copyButton.addEventListener('click', async function() {
                                            const value = uuidInput.value;
                                            if (!value) return;

                                            try {
                                                await navigator.clipboard.writeText(value);
                                                const label = this.querySelector('span:last-child');
                                                const previousLabel = label ? label.textContent : '';
                                                if (label) label.textContent = addFundsText('Copied');
                                                setTimeout(() => {
                                                    if (label) label.textContent = previousLabel;
                                                }, 1500);
                                            } catch (exception) {
                                                uuidInput.select();
                                            }
                                        });

                                        copySummaryButton.addEventListener('click', async function() {
                                            const value = uuidSummary.textContent;
                                            if (!value) return;

                                            try {
                                                await navigator.clipboard.writeText(value);
                                                this.innerHTML = '<span class="far fa-check" aria-hidden="true"></span>';
                                            } catch (exception) {
                                                return;
                                            }
                                        });
                                    });
                                </script>

                                <div class="separator my-5" id="pm-separator" style="display: none;"></div>
                                <fieldset class="div-currency border border-info rounded p-5 pt-0 mb-5" style="display: none;">
                                    <legend class="float-none w-auto mb-0 px-2">
                                        <label class="form-label text-info mb-0" data-lang="Currency conversion">Chuyển đổi tiền
                                            tệ</label>
                                    </legend>
                                    <div class="input-group input-group-solid">
                                        <input type="number" min="0" step="any"
                                            class="form-control ipt-currency-value" placeholder="0" inputmode="decimal">
                                        <input type="number" min="0" step="any"
                                            class="form-control bg-secondary ipt-currency-rate" value="1">
                                        <span class="input-group-text bg-secondary currency-symbol">USD</span>
                                    </div>
                                </fieldset>
                                <div class="div-minmax mb-1 text-center"></div>
                                <div class="div-rate mb-5 text-center" style="display: none;">
                                    <span class="fw-bolder fs-6 text-primary" id="pm-rate-text"></span>
                                </div>

                                {{-- Bảng tiền thưởng - render động bằng JS --}}
                                <div class="div-bonus mb-5 text-center" style="display: none;">
                                    <table class="table align-middle table-bordered fs-7 gy-2 gs-10 mb-0">
                                        <tbody id="bonus-tbody"></tbody>
                                    </table>
                                </div>

                                <div id="vnd-transfer-code-required" class="mb-5 text-center" style="display: none;">
                                    <form id="vnd-transfer-code-form" method="post">
                                        <div class="mb-5">
                                            <label for="vnd-transfer-code-name" class="form-label fs-3">
                                                Cập nhật tên của bạn (ghi tiếng Việt không dấu)
                                            </label>
                                            <input type="text" id="vnd-transfer-code-name"
                                                class="form-control form-control-solid border border-primary text-center"
                                                maxlength="255" autocomplete="name" required>
                                            <span class="text-danger fs-4 mt-2">Vui lòng cập nhật họ và tên của bạn giống như tên trong tài khoản ngân hàng. Ví dụ: PHAM QUOC DUY<br>Chúng tôi sẽ dùng họ và tên của bạn để làm nội dung chuyển tiền.<br>Lưu ý: KHÔNG thay đổi nội dung chuyển tiền sau khi quét mã qrcode.</span>
                                            <div id="vnd-transfer-code-message"
                                                class="alert alert-danger mt-3 hidden" role="alert"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </form>
                                </div>

                                <div class="div-fund-amount mb-5" style="display: none;">
                                    <label class="form-label" data-lang="Amount">Số lượng</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="fund-amount-currency">USD</span>
                                        <input type="number" name="PAYMENT_AMOUNT" value="100" min="0" step="any"
                                            id="ipt-fund-amount" class="form-control">
                                    </div>
                                </div>

                                {{-- Các div-options (ẩn/hiện theo JS) --}}
                                <div class="div-options div-1 div-2 div-9 div-26 div-30 div-31 text-center"
                                    style="display: none;">
                                    <img src="" class="w-250px mb-5">
                                    <div>
                                        <span id="casso_account"></span>
                                        <span class="d-block" id="casso_name"></span>
                                        <span class="d-block" id="casso_content"></span>
                                    </div>
                                </div>

                                <div class="div-options div-10 div-11 div-12 div-16 text-center" style="display: none;">
                                    <img src="" class="w-250px mb-5">
                                    <div class="mb-5">
                                        <span id="web2m_account"></span>
                                        <span class="d-block" id="web2m_content"></span>
                                    </div>
                                </div>

                                <div class="div-options div-13 text-center" style="display: none;">
                                    <img src="" class="w-250px mb-5">
                                    <div class="mb-5">
                                        <span id="web2m_momo_phone"></span>
                                        <span class="d-block" id="web2m_momo_content"></span>
                                    </div>
                                </div>

                                <div class="div-options div-19 div-20 div-21 div-29 div-37 text-center"
                                    style="display: none;">
                                    <img src="" class="w-250px mb-5">
                                    <div>
                                        <span id="web2m_webhook_account"></span>
                                        <span class="d-block" id="web2m_webhook_name"></span>
                                        <span class="d-block" id="web2m_webhook_content">Transfer note
                                            <span class="fs-6 fw-bolder text-primary">{{ auth()->user()->name ?? '' }} chuyen
                                                tien</span></span>
                                    </div>
                                    <h5 class="vnd-transfer-note text-danger fw-bold"
                                        data-lang="Note: Do not change the transfer content" style="display: none;"></h5>
                                </div>

                                {{-- div-23: sieuthicode webhook bank - render động bằng JS --}}
                                <div id="div-sieuthicode" class="div-options div-23 div-24 div-25 div-38 text-center"
                                    style="display: none;">
                                    <img src="" class="w-250px mb-5" id="sieuthicode_qr_img">
                                    <div>
                                        <span id="sieuthicode_webhook_account"></span>
                                        <span class="d-block" id="sieuthicode_webhook_name"></span>
                                        <span class="d-block" id="sieuthicode_webhook_content">Nội dung: <span
                                                class="fs-6 fw-bolder text-primary"
                                                id="sieuthicode_content_text">{{ $transferContent }}</span></span>
                                    </div>
                                    <h5 class="vnd-transfer-note text-danger fw-bold"
                                        data-lang="Note: Do not change the transfer content" style="display: none;"></h5>
                                </div>
                                <div class="div-options div-39 div-40 div-41 div-42 div-43 div-44 text-center"
                                    style="display: none;">
                                    <img src="" class="w-250px mb-5">
                                    <div>
                                        <span id="pay2s_account"></span>
                                        <span class="d-block" id="pay2s_name"></span>
                                        <span class="d-block" id="pay2s_content">Transfer note <span
                                                class="fs-6 fw-bolder text-primary">{{ $content ?? '' }} chuyen
                                                tien1</span></span>
                                    </div>
                                    <h5 class="vnd-transfer-note text-danger fw-bold"
                                        data-lang="Note: Do not change the transfer content" style="display: none;"></h5>
                                </div>

                                {{-- Binance / Crypto: use the shared amount input and open the QR modal --}}
                                <div id="div-binance" class="div-options div-33 mb-5" style="display: none;">
                                    <input type="hidden" id="ipt-binance-pm-id" value="">
                                    <button type="button" id="btn-binance-check" class="btn btn-primary w-100"
                                        data-lang="Pay Now"></button>
                                </div>

                                <div class="div-options div-36" style="display: none;">
                                    <form method="post" action="">
                                        @csrf
                                        <div class="mb-5">
                                            <label class="required form-label" data-lang="Enter amount to deposit">Số
                                                tiền</label>
                                            <input type="hidden" name="PM_ID" value="">
                                            <div class="input-group">
                                                <input type="text" name="PAYMENT_AMOUNT" id="vnd-input" value=""
                                                    placeholder="1000000" class="form-control" inputmode="numeric"
                                                    style="text-align: right;">
                                                <span class="input-group-text">VNĐ</span>
                                            </div>
                                        </div>
                                        <input type="submit" name="PAYMENT_METHOD" class="btn btn-primary w-100"
                                            data-lang="Pay Now" value="Thanh toán">
                                    </form>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Inputmask({
                                                alias: "numeric",
                                                groupSeparator: ".",
                                                radixPoint: ",",
                                                autoGroup: true,
                                                digits: 0,
                                                digitsOptional: false,
                                                prefix: "",
                                                suffix: "",
                                                rightAlign: true,
                                                removeMaskOnSubmit: true
                                            }).mask("#vnd-input");
                                        });
                                    </script>
                                </div>

                                <div class="alert alert-addfunds alert-normal mt-5 mb-5" style="display: none;"></div>
                                <script>
                                    var TRANSFER_CODE = @json(auth()->user()->transfer_code ?? '');
                                    var CONTENT = TRANSFER_CODE || @json($content ?? '');
                                </script>

                                {{-- Chi tiết phương thức --}}
                                <div class="div-details mb-5"></div>

                            </div>
                        </div>
                    </div>

                    {{-- Col phải: Lịch sử giao dịch --}}
                    <div class="col-md-7 col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="mb-3 p-8 pb-3">
                                    <label class="form-label" data-lang="Filter">Lọc</label>
                                    <input type="text" id="ipt-date" class="form-control form-control-solid ipt-date"
                                        placeholder="Select a date range" readonly>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-7 gy-2 gs-5 mb-0"
                                        id="table-history-fund">
                                        <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                            <tr>
                                                <th data-lang="Method">Phương thức</th>
                                                <th data-lang="Amount">Số tiền</th>
                                                <th data-lang="Created">Thời gian</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="transactions-tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Modal QR Binance/Crypto --}}
                <div class="modal binance-modal fade" tabindex="-1" id="binance-qr-modal" aria-hidden="true"
                    data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog binance-modal-dialog binance-modal-dialog-scrollable" role="document">
                        <form class="binance-modal-content" id="binance-form">
                            <div class="binance-modal-header">
                                <h4 class="binance-modal-title" data-lang="Binance internal transfer">
                                    Binance internal transfer
                                </h4>
                                <button type="button" class="binance-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="binance-modal-body">
                                <!-- alert -->
                                <div class="binance-alert binance-alert-danger hidden">
                                    <span class="binance-alert-content"></span>
                                </div>

                                <!-- success -->
                                <div class="binance-alert binance-alert-success hidden">
                                    <span class="binance-alert-content"></span>
                                </div>

                                <div id="binance-qr-modal-spinner" class="text-center hidden">
                                    <div class="spinner-block__wrapper spinner-block__container">
                                        <div class="spinner-block__wrapper spinner-block__high">
                                            <span class="fal fa-spinner-third"></span>
                                        </div>
                                    </div>
                                </div>

                                <div id="binance-main" class="">
                                    <!-- steps -->
                                    <div class="binance-steps" id="binance-steps">
                                        <div class="binance-step start">
                                            <div class="binance-step-line before"></div>
                                            <div class="binance-step-wrap">
                                                <span id="step-1" class="binance-step-num active">1</span>
                                                <div class="binance-step-label" data-lang="Make Payment">
                                                    Make Payment
                                                </div>
                                            </div>
                                            <div class="binance-step-line after"></div>
                                        </div>
                                        <div class="binance-step end">
                                            <div class="binance-step-line before"></div>
                                            <div class="binance-step-wrap">
                                                <span id="step-2" class="binance-step-num">2</span>
                                                <div class="binance-step-label" data-lang="Verify Payment">
                                                    Verify Payment
                                                </div>
                                            </div>
                                            <div class="binance-step-line after"></div>
                                        </div>
                                    </div>

                                    <div id="binance-top-step1">
                                        <div class="binance-amount">
                                            <span class="binance-amount-value"><strong>
                                                    1
                                                </strong></span>
                                            <span class="binance-currency-value">
                                                USDT
                                            </span>
                                        </div>
                                        <div class="binance-uuid">
                                            <div class="binance-form-group">
                                                <label class="control-label" for="binance-uuid-input"
                                                    data-lang="Send to Binance ID">
                                                    Send to Binance ID
                                                </label>
                                                <div class="binance-input-group">
                                                    <input id="binance-uuid-input" readonly=""
                                                        class="binance-form-control" value="441445584" type="text">
                                                    <div class="binance-input-group-btn">
                                                        <button class="binance-btn binance-btn-default" id="copy-uuid-1"
                                                            type="button" data-for-clip="binance-uuid-input"
                                                            data-toggle="tooltip-trigger" data-placement="top" title=""
                                                            data-bs-original-title="Copied">
                                                            <span class="fa fa-copy"></span>&nbsp;
                                                            <span data-lang="Copy">Copy</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="binance-pay-instruction" class="binance-pay-instruction">
                                            <img alt="" class="img-responsive img-fluid center-block m-auto"
                                                id="binance-qr-code-image"
                                                src="https://storage.perfectcdn.com/ehyzbm/8cq3t43ur33ax50s.jpeg">
                                            <div id="pay-instruction" class="binance-pay-instruction-text">
                                                <p data-lang="Scan the QR using Binance or send funds with Binance ID">
                                                    1. Scan the QR using the Binance app or send funds using the Binance ID.
                                                </p>
                                                <p data-lang="After payment, tap Confirm payment">
                                                    2. After completing the payment tap "Confirm payment".
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="binance-top-step2" class="hidden">
                                        <div class="binance-amount-uuid">
                                            <div class="amount-currency">
                                                <div class="amount-label" data-lang="Amount">Amount</div>
                                                <div class="amount-block">
                                                    <span class="binance-amount-value">
                                                        1
                                                    </span>
                                                    <span class="binance-currency-value">
                                                        USDT
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="uuid">
                                                <div class="uuid-label" data-lang="Send to Binance ID">
                                                    Send to Binance ID
                                                </div>
                                                <div class="uuid-block">
                                                    <span class="binance-uuid-value" id="binance-uuid-value">441445584</span>
                                                    <button id="copy-uuid-2" class="binance-uuid-value-copy" type="button"
                                                        data-for-clip="binance-uuid-value" data-toggle="tooltip-trigger"
                                                        data-placement="top" title="Copied">
                                                        <span class="far fa-copy"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="binance-order-id">
                                            <div class="binance-form-group">
                                                <label class="control-label" for="binance-order-id"
                                                    data-lang="Enter your Binance Order ID">
                                                    Enter your Binance Order ID
                                                </label>
                                                <input id="binance-order-id" class="binance-form-control">
                                            </div>
                                        </div>

                                        <div id="binance-verify-instruction" class="binance-verify-instruction">
                                            <img src="data:image/png;base64,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"
                                                alt="Payment success" class="img-responsive img-fluid center-block m-auto"
                                                id="binance-verify-image">
                                            <div id="verify-instruction" class="binance-verify-instruction-text">
                                                <p data-lang="Copy the Order ID from your successful Binance payment">
                                                    1. Copy the Order ID from the successful payment details in your Binance
                                                    account.
                                                </p>
                                                <p data-lang="Paste the Order ID above and tap Verify payment">
                                                    2. Paste it into the field above and tap "Verify payment".
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="binance-modal-footer">
                                <button id="binance-primary-btn" type="submit"
                                    class="binance-btn binance-btn-primary binance-btn-block" data-lang="Confirm payment">
                                    Confirm payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <style>
                    .div-bonus {
                        width: 100%;
                    }

                    .div-bonus>.table {
                        width: 100%;
                        table-layout: fixed;
                        margin-bottom: 0;
                    }

                    .div-bonus>.table td {
                        text-align: center;
                        vertical-align: middle;
                    }

                    @keyframes spinner {
                        to {
                            transform: rotate(360deg)
                        }
                    }

                    .hidden {
                        display: none !important;
                    }

                    .spinner-block__inline {
                        display: inline-block
                    }

                    .spinner-block__container {
                        display: block;
                        width: 100%;
                        height: 558px
                    }

                    .spinner-block__wrapper {
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center
                    }

                    .spinner-block__small {
                        width: 16px;
                        height: 16px
                    }

                    .spinner-block__small span {
                        font-size: 14px
                    }

                    .spinner-block__medium {
                        width: 24px;
                        height: 24px
                    }

                    .spinner-block__medium span {
                        font-size: 24px
                    }

                    .spinner-block__high {
                        width: 42px;
                        height: 42px;
                    }

                    .spinner-block__high span {
                        font-size: 42px;
                    }

                    .spinner-block__wrapper span {
                        animation: spinner .6s linear infinite;
                    }

                    .binance-modal .center-block {
                        display: block;
                        margin-right: auto;
                        margin-left: auto;
                    }

                    .binance-modal .binance-btn-block {
                        display: block;
                        width: 100%;
                    }

                    .binance-modal.modal {
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
                        font-size: 14px !important;
                        line-height: 1.42857143 !important;
                        color: #333 !important;
                    }

                    .modal-open .binance-modal.modal {
                        overflow-x: hidden;
                        overflow-y: auto;
                    }

                    .binance-modal .binance-modal-dialog-scrollable {
                        display: flex;
                        max-height: calc(100% - 1rem) !important;
                        height: auto !important;
                    }

                    .binance-modal .binance-modal-dialog {
                        width: calc(100% - 30px);
                        max-width: 414px;
                        margin-right: auto;
                        margin-left: auto;
                    }

                    .binance-modal .binance-alert {
                        padding: 15px;
                        margin-bottom: 20px;
                        border: 1px solid transparent;
                        border-radius: 4px;
                    }

                    .binance-modal .binance-alert-danger {
                        color: #a94442;
                        background-color: #f2dede;
                        border-color: #ebccd1;
                    }

                    .binance-modal .binance-alert-success {
                        color: #3c763d;
                        background-color: #dff0d8;
                        border-color: #d6e9c6;
                    }

                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-content {
                        background-color: #fff !important;
                        max-height: calc(100vh - 1rem);
                        overflow: hidden;
                        display: flex;
                        flex-direction: column;
                        width: 100%;
                        border: none !important;
                        border-radius: 6px;
                        outline: 0;
                        position: relative;
                        background-clip: padding-box;
                        pointer-events: auto;
                    }

                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-body {
                        background-color: #fff !important;
                        overflow-y: auto;
                        position: relative;
                        padding: 14px;
                    }

                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-header {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        min-height: 54px;
                        padding: 12px 14px;
                        border-bottom: 1px solid #E6E6E6;
                    }

                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-header .binance-btn-close {
                        float: right;
                        font-size: 21px;
                        font-weight: bold;
                        line-height: 1;
                        color: #000;
                        text-shadow: 0 1px 0 #fff;
                        filter: alpha(opacity=20);
                        opacity: .2;
                        appearance: none;
                        padding: 0;
                        cursor: pointer;
                        background: transparent;
                        border: 0;
                        margin-top: -2px;
                    }

                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-footer {
                        padding: 12px 14px;
                        text-align: center;
                        border-top: 1px solid #E6E6E6;
                    }

                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-footer,
                    .binance-modal .binance-modal-dialog-scrollable .binance-modal-header {
                        background-color: #fff !important;
                        -ms-flex-negative: 0;
                        flex-shrink: 0;
                    }

                    .binance-modal .binance-modal-title {
                        margin: 0;
                        font-size: 22px;
                        font-weight: 400;
                    }

                    .binance-modal .binance-steps {
                        display: flex;
                        align-items: center;
                        margin: 22px 2px 0;
                    }

                    .binance-modal .binance-step {
                        flex: 1 0 auto;
                        text-align: center;
                        position: relative;
                        display: flex;
                    }

                    .binance-modal .binance-step-wrap {
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        flex: 1;
                        margin-top: -12px;
                    }

                    .binance-modal .binance-step .binance-step-line {
                        flex: 1;
                        height: 1px;
                    }

                    .binance-modal .binance-step.start .binance-step-line.before {
                        background: linear-gradient(to right, white, #337AB7) !important;
                    }

                    .binance-modal .binance-step.start .binance-step-line.after {
                        flex: 0.2;
                        background: #337AB7 !important;
                    }

                    .binance-modal .binance-step.end .binance-step-line.after {
                        background: linear-gradient(to left, white, #337AB7) !important;
                    }

                    .binance-modal .binance-step.end .binance-step-line.before {
                        flex: 0.2;
                        background: #337AB7 !important;
                    }

                    .binance-modal .binance-step-num {
                        font-weight: 700;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 24px;
                        height: 24px;
                        border-radius: 50%;
                        background-color: #ADADAD !important;
                        color: #fff;
                        position: relative;
                    }

                    .binance-modal .binance-step-wrap::after,
                    .binance-modal .binance-step-wrap::before {
                        content: "";
                        position: absolute;
                        top: 12px;
                        height: 1px;
                        background: #337AB7 !important;
                    }

                    .binance-modal .binance-step-wrap::before {
                        left: 0;
                        width: 35%;
                    }

                    .binance-modal .binance-step-wrap::after {
                        right: 0;
                        width: 35%;
                    }

                    .binance-modal .binance-step-num.active {
                        background-color: #337AB7 !important;
                    }

                    .binance-modal .binance-step-num.success {
                        background: transparent;
                        border: 1.5px solid #57B18C !important;
                    }

                    .binance-modal .binance-step-num.success .fa-check {
                        color: #57B18C !important;
                        font-size: 12px;
                    }

                    .binance-modal .binance-step-label {
                        margin-top: 4px;
                        white-space: nowrap;
                    }

                    .binance-amount {
                        padding: 20px 12px 18px;
                        text-align: center;
                    }

                    .binance-amount-value {
                        font-weight: 700;
                        font-size: 32px;
                    }

                    .binance-currency-value {
                        font-weight: 500;
                        font-size: 24px;
                    }

                    .binance-pay-instruction,
                    .binance-verify-instruction {
                        background-color: #F2F2F2;
                        padding: 22px 13px;
                        border-radius: 4px;
                    }

                    .binance-pay-instruction img {
                        width: 140px;
                        height: 140px;
                        object-fit: contain;
                    }

                    .binance-verify-instruction img {
                        width: 183px;
                        height: 200px;
                        object-fit: contain;
                    }

                    .binance-pay-instruction-text,
                    .binance-verify-instruction-text {
                        margin-top: 18px;
                    }

                    .binance-pay-instruction-text p:last-child {
                        margin-bottom: 0px;
                    }

                    .binance-verify-instruction p:last-child {
                        margin-bottom: 0px;
                    }

                    .binance-amount-uuid {
                        margin-top: 24px;
                        margin-bottom: 16px;
                        padding: 8px 16px;
                        display: flex;
                        align-items: center;
                        background-color: #F2F2F2;
                        border-radius: 4px;
                    }

                    .binance-amount-uuid .amount-currency,
                    .binance-amount-uuid .uuid {
                        flex: 1;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                    }

                    .binance-amount-uuid .amount-currency .amount-label,
                    .binance-amount-uuid .uuid .uuid-label {
                        font-size: 10px !important;
                        color: #767676 !important;
                        margin-bottom: 4px;
                    }

                    .binance-amount-uuid .amount-currency .amount-block .binance-amount-value,
                    .binance-amount-uuid .amount-currency .amount-block .binance-currency-value {
                        font-size: 14px !important;
                        word-break: break-all;
                        font-weight: 400 !important;
                    }

                    .binance-amount-uuid .uuid .uuid-block {
                        font-size: 14px !important;
                    }

                    .binance-amount-uuid .uuid .binance-uuid-value-copy {
                        display: inline-block;
                        margin-left: 6px;
                        padding: 0px;
                        outline: none;
                        border: none;
                        margin: 0;
                        box-shadow: none;
                        color: #337AB7;
                    }

                    .binance-modal .binance-btn {
                        display: inline-block;
                        padding: 6px 12px;
                        margin-bottom: 0;
                        font-size: 14px;
                        font-weight: normal;
                        line-height: 1.42857143;
                        text-align: center;
                        white-space: nowrap;
                        vertical-align: middle;
                        -ms-touch-action: manipulation;
                        touch-action: manipulation;
                        cursor: pointer;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                        background-image: none;
                        border: 1px solid transparent;
                        border-radius: 4px;
                    }

                    .binance-modal .binance-btn.disabled {
                        pointer-events: none;
                        box-shadow: none;
                        opacity: 0.65;
                    }

                    .binance-modal .binance-btn-block {
                        display: block;
                        width: 100%;
                    }

                    .binance-modal .binance-btn-primary {
                        color: #fff;
                        background-color: #337ab7;
                        border-color: #2e6da4;
                    }

                    .binance-modal .binance-modal-footer .binance-btn {
                        min-height: 32px;
                        padding: 5px 12px;
                    }

                    .binance-modal .binance-btn-primary:hover {
                        background-color: #286090;
                        border-color: #204d74;
                    }

                    .binance-modal .binance-btn-default {
                        color: #333;
                        background-color: #fff;
                        border-color: #ccc;
                    }

                    .binance-modal .binance-btn-default:hover {
                        color: #333;
                        border-color: #8c8c8c;
                    }

                    .binance-modal button[type='submit'] {
                        .fa-spinner-third {
                            animation: spinner .6s linear infinite;
                        }
                    }

                    .binance-modal button[type='submit'] .fa-spinner-third {
                        margin-right: 8px;
                    }

                    .binance-modal .binance-input-group>.binance-input-group-btn {
                        padding: 0 !important;
                        width: 1%;
                        white-space: nowrap;
                        vertical-align: middle;
                        position: relative;
                        font-size: 0;
                        display: table-cell;
                    }

                    .binance-modal .binance-input-group-btn:last-child>.binance-btn {
                        z-index: 2;
                        margin-left: -1px;
                        border-top-left-radius: 0;
                        border-bottom-left-radius: 0;
                    }

                    .binance-modal .binance-form-group {
                        margin-bottom: 15px;
                    }

                    .binance-modal .binance-form-group .binance-input-group {
                        position: relative;
                        display: table;
                        border-collapse: separate;
                    }

                    .binance-modal label {
                        display: inline-block;
                        max-width: 100%;
                        margin-bottom: 5px;
                        font-weight: bold;
                    }

                    .binance-modal .binance-form-control {
                        display: block;
                        width: 100%;
                        height: 34px;
                        padding: 6px 12px;
                        font-size: 14px;
                        line-height: 1.42857143;
                        color: #555;
                        background-color: #fff;
                        background-image: none;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                    }

                    .binance-modal .binance-form-control:focus {
                        border-color: #66afe9;
                        outline: 0;
                        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
                    }

                    .binance-modal .binance-form-control:read-only {
                        background-color: #eee;
                        opacity: 1;
                    }

                    .binance-modal .binance-input-group .binance-form-control {
                        position: relative;
                        z-index: 2;
                        float: left;
                        width: 100%;
                        margin-bottom: 0;
                    }

                    .binance-modal .binance-input-group .binance-form-control {
                        display: table-cell;
                    }

                    .binance-input-group .binance-form-control:first-child {
                        border-top-right-radius: 0;
                        border-bottom-right-radius: 0;
                    }

                    @media (max-width: 420px) {
                        .binance-modal .binance-modal-dialog {
                            width: calc(100% - 20px);
                        }
                    }
                </style>

                {{-- Modal hạng thành viên --}}
                <div class="modal fade" id="modal-memberlevel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-4">
                                <h4 class="modal-title" data-lang="Member Level">Hạng thành viên</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                                    <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                        <tr>
                                            <td></td>
                                            <th class="text-center" data-lang="Total deposits">Tổng tiền nạp</th>
                                            <th class="text-center" data-lang="Bonus Deposit">% tiền thưởng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>NEWBIE</th>
                                            <td class="text-center text-primary fw-bolder">&gt;= $0</td>
                                            <td class="text-center text-warning fw-bolder">0%</td>
                                        </tr>
                                        <tr>
                                            <th>JUNIOR</th>
                                            <td class="text-center text-primary fw-bolder">&gt;= $1000</td>
                                            <td class="text-center text-warning fw-bolder">0%</td>
                                        </tr>
                                        <tr>
                                            <th>ELITE</th>
                                            <td class="text-center text-primary fw-bolder">&gt;= $5000</td>
                                            <td class="text-center text-warning fw-bolder">0%</td>
                                        </tr>
                                        <tr>
                                            <th>FREQUENT</th>
                                            <td class="text-center text-primary fw-bolder">&gt;= $10000</td>
                                            <td class="text-center text-warning fw-bolder">0%</td>
                                        </tr>
                                        <tr>
                                            <th>VIP</th>
                                            <td class="text-center text-primary fw-bolder">&gt;= $20000</td>
                                            <td class="text-center text-warning fw-bolder">0%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var PAYMENT_METHODS = @json($paymentMethodsForDashboard);
                </script>

                @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            if (typeof _addfunds === 'undefined') return;

                            _addfunds.init();
                        });
                    </script>
                @endpush
            </div>
        </div>
    @endsection
