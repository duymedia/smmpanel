@extends('clients.theme-6.layouts.app')

@section('title', __('addfunds.title'))

@section('content') <div id="block_106">
    <div class="block-bg"></div>

    <div class="container-fluid">
        <div class="add-funds">

            {{-- Payment Form --}}
            <div class="component_card">
                <div class="card">
                    <form id="main-payment-form" class="component_form_group" onsubmit="return false;">

                        <div class="form-group">
                            <label for="method" class="control-label">
                                {{ __('addfunds.method') }}
                            </label>

                            <select class="form-control"
                                id="method"
                                name="AddFoundsForm[type]"
                                data-select="true"
                                data-select-search="true"
                                data-select-search-placeholder="{{ __('newOrder.search') }}"
                                data-select-container="#select-method-container">

                                @foreach ($payments ?? [] as $payment)

                                @php
                                $bonusText = '';

                                if ($payment->bonus) {
                                $bonusArray = is_string($payment->bonus)
                                ? json_decode($payment->bonus, true)
                                : $payment->bonus;

                                if (is_array($bonusArray) && count($bonusArray) > 0) {
                                $firstBonus = $bonusArray[0] ?? null;

                                if (
                                $firstBonus &&
                                isset($firstBonus['min'], $firstBonus['percent'])
                                ) {
                                $bonusText =
                                ' | ' .
                                number_format($firstBonus['min'], 0) .
                                ' + ' .
                                $firstBonus['percent'] .
                                '% Bonus';
                                }
                                }
                                }

                                /*
                                * Payment config
                                */
                                $binanceId = '';
                                $qrImage = '';

                                $bankName = '';
                                $bankCode = '';
                                $accountNumber = '';
                                $accountName = '';
                                $transferContent = '';

                                if ($payment->config) {

                                $configArray = is_string($payment->config)
                                ? json_decode($payment->config, true)
                                : $payment->config;

                                $configArray = is_array($configArray)
                                ? $configArray
                                : [];

                                // Binance
                                $binanceId = $configArray['binance_id']
                                ?? ($configArray['uid'] ?? '');

                                $qrImage = $configArray['qr_image']
                                ?? '';

                                // Bank VN
                                $bankName = $configArray['bank_name']
                                ?? ($configArray['bank']
                                ?? ($configArray['name'] ?? ''));

                                $bankCode = $configArray['bank_code']
                                ?? ($configArray['code'] ?? '');

                                $accountNumber = $configArray['account_number']
                                ?? ($configArray['accountNumber']
                                ?? ($configArray['stk']
                                ?? ($configArray['account'] ?? '')));

                                $accountName = $configArray['account_name']
                                ?? ($configArray['accountName']
                                ?? ($configArray['owner']
                                ?? ($configArray['account_holder'] ?? '')));

                                $transferContent = $configArray['transfer_content']
                                ?? ($configArray['content']
                                ?? ($configArray['description'] ?? ''));

                                /*
                                * Một số hệ thống lưu QR chung trong image_url.
                                */
                                if (!$qrImage) {
                                $qrImage = $payment->image_url ?? '';
                                }
                                }

                                @endphp

                                <option
                                    value="{{ $payment->id }}"
                                    data-type="{{ $payment->type }}"
                                    data-payment-name="{{ $payment->name }}"

                                    data-qr-image="{{ $qrImage }}"
                                    data-binance-id="{{ $binanceId }}"

                                    data-bank-name="{{ $bankName }}"
                                    data-bank-code="{{ $bankCode }}"
                                    data-account-number="{{ $accountNumber }}"
                                    data-account-name="{{ $accountName }}"
                                    data-transfer-content="{{ $transferContent }}"

                                    data-currency="{{ $payment->currency ?? ($currency->code ?? '') }}"
                                    data-details="{{ $payment->details ?? '' }}"

                                    data-image="{{ $payment->image_url ?? '' }}">

                                    {{ $payment->name }}{{ $bonusText }}

                                </option>

                                @endforeach

                            </select>

                            <div id="select-method-container" class="position-relative"></div>

                            <div id="payment-details" class="form-group instruction payment-details" style="display:none;" aria-live="polite">
                                <label class="control-label">{{ __('addfunds.transfer_details') }}</label>
                                <div id="payment-details-content" class="panel-body border-solid border-rounded text-center"></div>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="amount" class="control-label">

                                <span id="amount_label">
                                    {{ __('addfunds.amount') }}
                                </span>

                                <span id="amount_label_currency" class="hidden"></span>

                            </label>

                            <input
                                type="number"
                                inputmode="decimal"
                                class="form-control"
                                name="AddFoundsForm[amount]"
                                id="amount">

                        </div>

                        <div class="component_button_submit">

                            <button
                                type="button"
                                class="btn btn-block btn-big-primary"
                                id="payButton">

                                {{ __('addfunds.pay') }}

                            </button>

                        </div>

                    </form>
                </div>
            </div>


            {{-- Transaction History --}}
            <div class="mt-4">

                <div class="table-bg component_table">

                    <div class="table-wr table-responsive">

                        <table class="table">

                            <thead>
                                <tr>
                                    <th>{{ __('addfunds.id') }}</th>
                                    <th>{{ __('addfunds.date') }}</th>
                                    <th>{{ __('addfunds.method') }}</th>
                                    <th>{{ __('addfunds.amount') }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($transactions ?? [] as $transaction)

                                @php

                                $hasBonus = $transaction->bonus_amount > 0;

                                $bonusPercent =
                                $hasBonus && $transaction->amount > 0
                                ? round(
                                ($transaction->bonus_amount /
                                $transaction->amount) *
                                100,
                                1,
                                )
                                : 0;

                                @endphp

                                <tr>

                                    <td data-label="{{ __('addfunds.id') }}">
                                        {{ $transaction->id }}
                                    </td>

                                    <td data-label="{{ __('addfunds.date') }}">

                                        <span class="nowrap">
                                            {{ $transaction->created_at->format('Y-m-d') }}
                                        </span>

                                        <span class="nowrap">
                                            {{ $transaction->created_at->format('H:i:s') }}
                                        </span>

                                    </td>

                                    <td data-label="{{ __('addfunds.method') }}">

                                        <span class="nowrap">
                                            {{ $transaction->paymentMethod->name ?? 'N/A' }}
                                        </span>

                                        @if ($hasBonus)

                                        <span class="tx-bonus-badge">
                                            +{{ $bonusPercent }}% bonus
                                        </span>

                                        @endif

                                    </td>

                                    <td data-label="{{ __('addfunds.amount') }}">

                                        <span class="nowrap">

                                            {{ number_format($transaction->amount, 2) }}
                                            {{ $transaction->currency }}

                                        </span>

                                        @if ($hasBonus)

                                        <span class="nowrap tx-bonus-amount">

                                            +{{ number_format($transaction->bonus_amount, 2) }}
                                            {{ $transaction->currency }}

                                        </span>

                                        @endif

                                    </td>

                                    <td class="add-funds-actions">

                                        @if ($transaction->status === 'completed')

                                        <div class="component_download_button">

                                            <button
                                                type="button"
                                                class="btn btn-actions download-invoice-btn"
                                                data-payment-id="{{ $transaction->id }}">

                                                {{ __('addfunds.download_invoice') ?? 'Download invoice' }}

                                            </button>

                                        </div>

                                        @endif

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="5" class="text-center py-4">

                                        <p class="nowrap">
                                            {{ __('addfunds.no_transactions') }}
                                        </p>

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="bankvn-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-university mr-2"></i>Thanh toán ngân hàng</h5>
                <button type="button" class="close" data-bankvn-close aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 mb-3">Vui lòng chuyển khoản đúng số tiền và nội dung.</div>
                <div id="bankvn-name-panel" class="form-group d-none">
                    <label for="bankvn-name-input">Họ và tên của bạn</label>
                    <input id="bankvn-name-input" class="form-control" autocomplete="name"
                        placeholder="Nhập họ và tên để tiếp tục">
                    <small class="form-text text-muted">Thông tin này sẽ được lưu vào tài khoản của bạn.</small>
                    <button type="button" id="bankvn-save-name" class="btn btn-primary btn-sm mt-2">Lưu và tiếp tục</button>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <h6 class="font-weight-bold mb-3">Thông tin chuyển khoản</h6>
                        <div class="list-group mb-3">
                            <div class="list-group-item d-flex justify-content-between"><span>Ngân hàng</span><strong><span id="bankvn-bank-name">-</span> <small id="bankvn-bank-code" class="text-muted"></small></strong></div>
                            <div class="list-group-item d-flex justify-content-between"><span>Số tài khoản</span><strong id="bankvn-account-number">-</strong></div>
                            <div class="list-group-item d-flex justify-content-between"><span>Chủ tài khoản</span><strong id="bankvn-account-name">-</strong></div>
                            <div class="list-group-item d-flex justify-content-between align-items-center"><span>Nội dung</span><span><strong id="bankvn-transfer-content">-</strong> <button type="button" class="btn btn-sm btn-light ml-2 bankvn-copy-btn" data-copy-target="bankvn-transfer-content"><i class="far fa-copy"></i></button></span></div>
                            <div class="list-group-item d-flex justify-content-between align-items-center"><span>Số tiền</span><span><strong id="bankvn-amount">0</strong> VND <button type="button" class="btn btn-sm btn-light ml-2 bankvn-copy-btn bankvn-copy-amount" data-copy-target="bankvn-amount"><i class="far fa-copy"></i></button></span></div>
                        </div>
                    </div>
                    <div class="col-md-5 text-center">
                        <h6 class="font-weight-bold mb-3">Quét mã QR</h6>
                        <div class="bankvn-qr-wrapper mb-2">
                            <div id="bankvn-qr-loading" class="bankvn-qr-loading text-muted" aria-hidden="true"><i class="fas fa-spinner fa-spin"></i></div><img id="bankvn-qr-image" src="" alt="Bank QR Code" class="img-fluid rounded" style="max-width:220px; display:none;">
                            <div id="bankvn-qr-error" class="small text-muted" style="display:none;">Không thể tải mã QR.</div>
                        </div>
                        <div id="bankvn-qr-bank-name" class="text-muted small">Ngân hàng</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><small class="text-muted mr-auto">Hệ thống sẽ tự động kiểm tra giao dịch.</small><button type="button" class="btn btn-primary" data-bankvn-close>Đã hiểu</button></div>
        </div>
    </div>
</div>

<div
    class="modal binance-modal fade"
    tabindex="-1"
    role="dialog"
    id="binance-qr-modal"
    data-backdrop="static">

    <div class="modal-dialog binance-modal-dialog binance-modal-dialog-scrollable">

        <form class="binance-modal-content" id="binance-form">

            <div class="binance-modal-header">

                <h4 class="binance-modal-title">
                    Binance internal transfer
                </h4>

                <button
                    type="button"
                    class="binance-btn-close"
                    data-dismiss="modal">

                    ×

                </button>

            </div>

            <div class="binance-modal-body">

                <div class="binance-alert binance-alert-danger hidden">
                    <span class="content"></span>
                </div>

                <div class="binance-alert binance-alert-success hidden">
                    <span class="content"></span>
                </div>

                <div id="binance-main">

                    <div class="binance-steps" id="binance-steps">

                        <div class="binance-step start">

                            <div class="binance-step-line before"></div>

                            <div class="binance-step-wrap">

                                <span
                                    id="step-1"
                                    class="binance-step-num active">
                                    1
                                </span>

                                <div class="binance-step-label">
                                    Make payment
                                </div>

                            </div>

                            <div class="step-line after"></div>

                        </div>

                        <div class="binance-step end">

                            <div class="binance-step-line before"></div>

                            <div class="binance-step-wrap">

                                <span
                                    id="step-2"
                                    class="binance-step-num">
                                    2
                                </span>

                                <div class="binance-step-label">
                                    Verify payment
                                </div>

                            </div>

                            <div class="binance-step-line after"></div>

                        </div>

                    </div>


                    <div id="binance-top-step1">

                        <div class="binance-amount">

                            <span class="binance-amount-value">
                                <strong>1</strong>
                            </span>

                            <span class="binance-currency-value">
                                USDT
                            </span>

                        </div>

                        <div class="binance-uuid">

                            <div class="binance-form-group">

                                <label>
                                    Send to Binance ID
                                </label>

                                <div class="binance-input-group">

                                    <input
                                        id="binance-uuid-input"
                                        readonly
                                        class="binance-form-control"
                                        value="">

                                    <div class="binance-input-group-btn">

                                        <button
                                            class="binance-btn binance-btn-default"
                                            type="button"
                                            data-for-clip="binance-uuid-input">

                                            <span class="fa fa-copy"></span>
                                            Copy

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="binance-pay-instruction text-center">

                            <img
                                id="binance-qr-code-image"
                                src=""
                                class="img-fluid m-auto"
                                style="max-width:140px;">

                            <div class="binance-pay-instruction-text mt-3">

                                <p>
                                    1. Scan the QR using the Binance app or
                                    send funds using the Binance ID.
                                </p>

                                <p>
                                    2. After completing the payment tap
                                    "Confirm payment".
                                </p>

                            </div>

                        </div>

                    </div>


                    <div
                        id="binance-top-step2"
                        class="hidden">

                        <div class="binance-amount-uuid">

                            <div class="amount-currency">

                                <div class="amount-label">
                                    Amount
                                </div>

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

                                <div class="uuid-label">
                                    Send to Binance ID
                                </div>

                                <div class="uuid-block">

                                    <span
                                        class="binance-uuid-value"
                                        id="binance-uuid-value">
                                    </span>

                                    <button
                                        id="copy-uuid-2"
                                        class="binance-uuid-value-copy"
                                        type="button"
                                        data-for-clip="binance-uuid-value">

                                        <span class="far fa-copy"></span>

                                    </button>

                                </div>

                            </div>

                        </div>


                        <div class="binance-order-id">

                            <div class="binance-form-group">

                                <label
                                    class="control-label"
                                    for="binance-order-id">

                                    Enter your Binance Order ID

                                </label>

                                <input
                                    id="binance-order-id"
                                    class="binance-form-control"
                                    placeholder="Order ID">

                            </div>

                        </div>


                        <div class="binance-verify-instruction text-center">

                            <div class="binance-verify-instruction-text mt-3">

                                <p>
                                    1. Copy the Order ID from the successful
                                    payment details in your Binance account.
                                </p>

                                <p>
                                    2. Paste it into the field above and tap
                                    "Verify payment".
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="binance-modal-footer">

                <button
                    id="binance-primary-btn"
                    type="button"
                    class="binance-btn binance-btn-primary binance-btn-block">

                    Confirm payment

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<style>
    .hidden {
        display: none !important;
    }



    .tx-bonus-badge {
        display: inline-block;
        margin-left: 6px;
        font-size: .72em;
        font-weight: 600;
        color: #28a745;
        background: rgba(40, 167, 69, .1);
        padding: 1px 7px;
        border-radius: 20px;
        white-space: nowrap;
        vertical-align: middle;
    }

    .tx-bonus-amount {
        display: block;
        font-size: .82em;
        color: #28a745;
        font-weight: 600;
        margin-top: 2px;
    }

    .payment-details {
        margin-top: 12px;
    }

    .payment-details .panel-body {
        padding: 12px 14px;
        color: #334155;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    /* =========================================================
       BINANCE MODAL
    ========================================================== */

    .binance-modal.modal {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
        font-size: 14px !important;
        line-height: 1.42857143 !important;
        color: #333 !important;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1060;
        display: none;
        overflow: hidden;
        outline: 0;
    }

    .binance-modal.show {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .binance-modal.show .binance-modal-dialog {
        transform: translate(0, 0);
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
        padding: 15px;
    }

    .binance-modal .binance-modal-dialog-scrollable .binance-modal-header {
        padding: 15px;
        border-bottom: 1px solid #E6E6E6;
    }

    .binance-modal .binance-modal-dialog-scrollable .binance-modal-header .binance-btn-close {
        float: right;
        font-size: 21px;
        font-weight: bold;
        line-height: 1;
        color: #000;
        opacity: .2;
        appearance: none;
        padding: 0;
        cursor: pointer;
        background: transparent;
        border: 0;
        margin-top: -2px;
    }

    .binance-modal .binance-modal-dialog-scrollable .binance-modal-footer {
        padding: 15px;
        text-align: right;
        border-top: 1px solid #E6E6E6;
    }

    .binance-modal .binance-modal-dialog-scrollable .binance-modal-footer,
    .binance-modal .binance-modal-dialog-scrollable .binance-modal-header {
        background-color: #fff !important;
        flex-shrink: 0;
    }

    .binance-modal .binance-modal-title {
        float: left;
        margin: 0;
    }

    .binance-modal .binance-steps {
        display: flex;
        align-items: center;
        margin-top: 32px;
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

    .binance-modal .binance-step-num.active {
        background-color: #337AB7 !important;
    }

    .binance-modal .binance-step-label {
        margin-top: 4px;
        white-space: nowrap;
    }

    .binance-amount {
        padding: 24px;
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
        padding: 24px 16px;
        border-radius: 4px;
    }

    .binance-pay-instruction img {
        width: 140px;
        height: 140px;
        object-fit: contain;
    }

    .binance-pay-instruction-text,
    .binance-verify-instruction-text {
        margin-top: 24px;
    }

    .binance-pay-instruction-text p:last-child,
    .binance-verify-instruction p:last-child {
        margin-bottom: 0;
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
        padding: 0;
        outline: none;
        border: none;
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
        cursor: pointer;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .binance-modal .binance-btn.disabled {
        pointer-events: none;
        box-shadow: none;
        opacity: .65;
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
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        transition: border-color ease-in-out .15s,
            box-shadow ease-in-out .15s;
    }

    .binance-modal .binance-form-control:focus {
        border-color: #66afe9;
        outline: 0;
        box-shadow:
            inset 0 1px 1px rgba(0, 0, 0, .075),
            0 0 8px rgba(102, 175, 233, .6);
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
        display: table-cell;
    }

    .binance-input-group .binance-form-control:first-child {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    @media (min-width:768px) {

        .binance-modal .modal-dialog {
            width: 460px;
            margin: 30px auto;
        }

    }

    /* Bank transfer modal: compact and responsive */
    #bankvn-modal .modal-dialog {
        width: min(760px, calc(100% - 24px));
        margin: 1.5rem auto;
    }

    #bankvn-modal .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 20px 55px rgba(15, 23, 42, .25);
    }

    #bankvn-modal .modal-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #f7f9fc, #eef4fb);
        border-bottom: 1px solid #e5e7eb;
    }

    #bankvn-modal .modal-title {
        color: #172554;
        font-size: 1.05rem;
        font-weight: 700;
    }

    #bankvn-modal .modal-body {
        padding: 1rem 1.25rem;
    }

    #bankvn-modal .alert {
        border: 0;
        border-radius: 8px;
        color: #075985;
        background: #e0f2fe;
    }

    #bankvn-modal .list-group {
        border-radius: 9px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    #bankvn-modal .list-group-item {
        min-height: 46px;
        padding: .7rem .9rem;
        border-color: #edf0f4;
        color: #475569;
        gap: 12px;
    }

    #bankvn-modal .list-group-item>span:last-child,
    #bankvn-modal .list-group-item>strong {
        color: #1e293b;
        text-align: right;
        word-break: break-word;
    }

    #bankvn-modal #bankvn-transfer-content,
    #bankvn-modal #bankvn-amount {
        color: #2563eb;
    }

    #bankvn-modal .bankvn-qr-wrapper {
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    #bankvn-modal #bankvn-qr-image {
        width: min(220px, 100%);
        height: auto;
        padding: 8px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    #bankvn-modal .modal-footer {
        padding: .8rem 1.25rem;
        background: #fafafa;
        border-top: 1px solid #edf0f4;
    }

    #bankvn-modal .modal-footer small {
        color: #64748b;
    }

    @media (max-width: 575px) {
        #bankvn-modal .modal-dialog {
            width: calc(100% - 16px);
            margin: .5rem auto;
        }

        #bankvn-modal .modal-body {
            padding: .8rem;
        }

        #bankvn-modal .modal-body .row>[class*="col-"]+[class*="col-"] {
            margin-top: 1rem;
        }

        #bankvn-modal .list-group-item {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        #bankvn-modal .list-group-item>span:last-child,
        #bankvn-modal .list-group-item>strong {
            margin-left: auto;
            max-width: 68%;
        }

        #bankvn-modal .modal-footer {
            align-items: flex-start;
            gap: 10px;
            flex-wrap: wrap;
        }

        #bankvn-modal .modal-footer small {
            flex: 1 1 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const methodSelect = document.getElementById('method');
        const amountInput = document.getElementById('amount');

        const binancePrimaryBtn =
            document.getElementById('binance-primary-btn');

        let currentBinanceStep = 1;


        /* =========================================================
           BANK VN
        ========================================================== */

        const bankModal =
            document.getElementById('bankvn-modal');

        const bankQrImage =
            document.getElementById('bankvn-qr-image');

        const bankQrWrapper =
            document.querySelector('.bankvn-qr-wrapper');
        const bankQrLoading = document.getElementById('bankvn-qr-loading');
        const bankQrError = document.getElementById('bankvn-qr-error');
        const bankNamePanel = document.getElementById('bankvn-name-panel');
        const bankNameInput = document.getElementById('bankvn-name-input');
        let currentTransferCode = @json(auth()->user()->transfer_code ?? '');
        let pendingBankData = null;
        let pendingBankAmount = null;


        function formatVnd(amount) {

            const number = Number(amount);

            if (!Number.isFinite(number)) {
                return '0';
            }

            return new Intl.NumberFormat('vi-VN', {
                maximumFractionDigits: 0
            }).format(number);

        }


        async function openBankModal(data, amount) {

            if (!bankModal) {
                return;
            }

            pendingBankData = data;
            pendingBankAmount = amount;
            bankModal.classList.add('show');
            bankModal.style.display = 'block';
            bankModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');


            const bankName =
                data.bankName ||
                'Ngân hàng';

            const bankCode =
                data.bankCode ||
                'BANK';

            const accountNumber =
                data.accountNumber ||
                '-';

            const accountName =
                data.accountName ||
                '-';

            let transferCode = currentTransferCode;
            if (!transferCode) {
                bankNamePanel?.classList.remove('d-none');
                bankNameInput?.focus();
                const name = bankNameInput?.value.trim();
                if (!name) return;
                const response = await fetch(@json(url('/account/update-name')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name
                        })
                    });
                const result = await response.json();
                if (!result.success) return alert(result.message || 'Không thể lưu họ và tên.');
                transferCode = result.transfer_code;
                currentTransferCode = transferCode;
            }

            bankNamePanel?.classList.add('d-none');
            let transferContent = (data.transferContent || transferCode || '').trim();
            transferContent = `${transferContent} CHUYEN KHOAN`.trim();


            /*
             * Nếu backend không khai báo nội dung
             * thì tạo nội dung tự động.
             */
            if (!transferContent || transferContent === '-') {

                transferContent =
                    'NAPTIEN ' +
                    Math.floor(
                        100000 +
                        Math.random() * 900000
                    );

            }


            document.getElementById(
                'bankvn-bank-name'
            ).textContent = bankName;


            document.getElementById(
                'bankvn-bank-code'
            ).textContent = bankCode;


            document.getElementById('bankvn-account-number')?.replaceChildren(document.createTextNode(accountNumber));


            document.getElementById('bankvn-account-name')?.replaceChildren(document.createTextNode(accountName));


            document.getElementById('bankvn-transfer-content')?.replaceChildren(document.createTextNode(transferContent));


            document.getElementById('bankvn-amount')?.replaceChildren(document.createTextNode(formatVnd(amount)));


            document.getElementById('bankvn-qr-bank-name')?.replaceChildren(document.createTextNode(bankName));


            /*
             * QR
             */
            const qr = data.bankCode && data.accountNumber ?
                `https://img.vietqr.io/image/${encodeURIComponent(data.bankCode)}-${encodeURIComponent(data.accountNumber)}-qr_only.jpg?amount=${Math.round(amount)}&accountName=${encodeURIComponent(accountName)}&addInfo=${encodeURIComponent(transferContent)}` :
                (data.qrImage || data.image || '');


            bankQrWrapper.classList.remove(
                'has-image'
            );
            bankQrImage.style.display = 'none';
            if (bankQrLoading) bankQrLoading.style.display = qr ? 'block' : 'none';
            if (bankQrError) bankQrError.style.display = 'none';

            bankQrImage.removeAttribute('src');


            if (qr) {

                bankQrImage.onload = function() {

                    bankQrWrapper.classList.add(
                        'has-image'
                    );
                    bankQrImage.style.display = 'block';
                    if (bankQrLoading) bankQrLoading.style.display = 'none';

                };

                bankQrImage.onerror = function() {

                    bankQrWrapper.classList.remove(
                        'has-image'
                    );
                    bankQrImage.style.display = 'none';
                    if (bankQrLoading) bankQrLoading.style.display = 'none';
                    if (bankQrError) bankQrError.style.display = 'block';

                };

                bankQrImage.src = qr;

            } else if (bankQrError) {
                bankQrError.style.display = 'block';
            }


        }

        document.getElementById('bankvn-save-name')?.addEventListener('click', function() {
            if (pendingBankData) openBankModal(pendingBankData, pendingBankAmount);
        });


        function closeBankModal() {

            if (!bankModal) {
                return;
            }

            bankModal.classList.remove('show');
            bankModal.style.display = 'none';
            bankModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');

        }


        /*
         * Close modal
         */
        document.addEventListener(
            'click',
            function(e) {

                if (
                    e.target.closest(
                        '[data-bankvn-close]'
                    )
                ) {

                    closeBankModal();

                }

            }
        );


        /*
         * ESC
         */
        document.addEventListener(
            'keydown',
            function(e) {

                if (
                    e.key === 'Escape' &&
                    bankModal &&
                    bankModal.classList.contains('show')
                ) {

                    closeBankModal();

                }

            }
        );


        /*
         * Copy Bank VN data
         */
        document.addEventListener(
            'click',
            async function(e) {

                const button =
                    e.target.closest(
                        '.bankvn-copy-btn'
                    );

                if (!button) {
                    return;
                }


                const targetId =
                    button.dataset.copyTarget;

                const target =
                    document.getElementById(
                        targetId
                    );

                if (!target) {
                    return;
                }


                let value =
                    target.textContent.trim();


                if (!value) {
                    return;
                }


                try {

                    await navigator.clipboard.writeText(
                        value
                    );

                } catch (error) {

                    const textarea =
                        document.createElement(
                            'textarea'
                        );

                    textarea.value = value;

                    textarea.style.position =
                        'fixed';

                    textarea.style.opacity = '0';

                    document.body.appendChild(
                        textarea
                    );

                    textarea.select();

                    document.execCommand(
                        'copy'
                    );

                    textarea.remove();

                }


                const original =
                    button.innerHTML;

                button.classList.add(
                    'copied'
                );

                button.innerHTML =
                    '<i class="fas fa-check"></i><span>Đã copy</span>';


                setTimeout(
                    function() {

                        button.classList.remove(
                            'copied'
                        );

                        button.innerHTML =
                            original;

                    },
                    1800
                );

            }
        );


        /* =========================================================
           PAY BUTTON
        ========================================================== */

        document.addEventListener(
            'click',
            function(e) {

                const btn =
                    e.target.closest(
                        '#payButton, .payment-action-btn'
                    );

                if (!btn) {
                    return;
                }


                let amount,
                    type,
                    data = {};


                if (btn.id === 'payButton') {

                    amount =
                        parseFloat(
                            amountInput.value
                        );


                    if (
                        isNaN(amount) ||
                        amount <= 0
                    ) {

                        return alert(@json(__('addfunds.invalid_amount') ?? 'Please enter a valid amount'));

                    }


                    const opt =
                        methodSelect.selectedOptions[0];


                    if (!opt) {

                        return alert(@json(__('addfunds.method')));

                    }


                    type =
                        (
                            opt.dataset.type ||
                            ''
                        )
                        .trim()
                        .toLowerCase();


                    data = {

                        payment_id: opt.value,

                        binance_id: opt.dataset.binanceId,

                        qr_image: opt.dataset.qrImage ||
                            opt.dataset.image,

                        bankName: opt.dataset.bankName,

                        bankCode: opt.dataset.bankCode,

                        accountNumber: opt.dataset.accountNumber,

                        accountName: opt.dataset.accountName,

                        transferContent: opt.dataset.transferContent,

                        image: opt.dataset.image

                    };

                } else {

                    amount =
                        btn.dataset.amount;

                    type =
                        (
                            btn.dataset.paymentType ||
                            ''
                        )
                        .trim()
                        .toLowerCase();


                    try {

                        data =
                            JSON.parse(
                                btn.dataset.paymentData ||
                                '{}'
                            );

                    } catch (error) {

                        data = {};

                    }

                }


                /* =====================================================
                   BANK VN
                ====================================================== */

                if (
                    type === 'bank_vn' ||
                    type === 'bank'
                ) {

                    openBankModal(
                        data,
                        amount
                    );

                    return;

                }


                /* =====================================================
                   BINANCE - GIỮ NGUYÊN
                ====================================================== */

                if (
                    type === 'binance' ||
                    type === 'crypto'
                ) {

                    currentBinanceStep = 1;

                    const binanceId =
                        data.binance_id ||
                        '';

                    const qrImage =
                        data.qr_image ||
                        '';


                    document
                        .querySelectorAll(
                            '.binance-amount-value'
                        )
                        .forEach(
                            el =>
                            el.textContent =
                            amount
                        );


                    document.getElementById(
                            'binance-uuid-input'
                        ).value =
                        binanceId;


                    document.getElementById(
                            'binance-uuid-value'
                        ).textContent =
                        binanceId;


                    document.getElementById(
                            'binance-qr-code-image'
                        ).src =
                        qrImage;


                    $('#binance-top-step1')
                        .removeClass('hidden');


                    $('#binance-top-step2')
                        .addClass('hidden');


                    $('#step-1')
                        .addClass('active');


                    $('#step-2')
                        .removeClass('active');


                    binancePrimaryBtn.textContent =
                        'Confirm payment';


                    openBinanceModal();

                }

            }
        );


        /* =========================================================
           BINANCE MODAL
        ========================================================== */

        function openBinanceModal() {

            const modalElement =
                document.getElementById(
                    'binance-qr-modal'
                );

            if (!modalElement) {
                return;
            }


            modalElement.classList.add(
                'show'
            );

            modalElement.style.display =
                'block';

            modalElement.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body.classList.add(
                'modal-open'
            );


            const backdrop =
                document.createElement(
                    'div'
                );

            backdrop.className =
                'modal-backdrop fade show';

            backdrop.dataset.binanceBackdrop =
                '1';

            document.body.appendChild(
                backdrop
            );

        }


        document.querySelector(
            '#binance-qr-modal [data-dismiss="modal"]'
        )?.addEventListener(
            'click',
            function() {

                const modal =
                    document.getElementById(
                        'binance-qr-modal'
                    );

                modal.classList.remove(
                    'show'
                );

                modal.style.display =
                    'none';

                modal.setAttribute(
                    'aria-hidden',
                    'true'
                );

                document.body.classList.remove(
                    'modal-open'
                );

                document.querySelector(
                    '[data-binance-backdrop]'
                )?.remove();

            }
        );


        /* =========================================================
           BINANCE STEPS
        ========================================================== */

        if (binancePrimaryBtn) {

            binancePrimaryBtn.addEventListener(
                'click',
                function() {

                    if (
                        currentBinanceStep === 1
                    ) {

                        currentBinanceStep =
                            2;


                        $('#binance-top-step1')
                            .addClass('hidden');


                        $('#binance-top-step2')
                            .removeClass('hidden');


                        $('#step-1')
                            .removeClass('active');


                        $('#step-2')
                            .addClass('active');


                        this.textContent =
                            'Verify payment';

                        return;
                    }


                    const orderId =
                        document
                        .getElementById(
                            'binance-order-id'
                        )
                        .value
                        .trim();


                    if (!orderId) {

                        return alert(
                            'Please enter Order ID'
                        );

                    }


                    this.disabled = true;


                    const userId = @json(Auth::id());


                    fetch(
                            `/cron/binance/transactions?orderId=${orderId}&amount=${document.querySelector('.binance-amount-value').textContent}&user_id=${userId}`
                        )
                        .then(
                            r => r.json()
                        )
                        .then(
                            res => {

                                this.disabled =
                                    false;


                                const successAlert =
                                    document.querySelector(
                                        '.binance-alert-success'
                                    );


                                const dangerAlert =
                                    document.querySelector(
                                        '.binance-alert-danger'
                                    );


                                if (res.success) {

                                    if (
                                        successAlert
                                    ) {

                                        successAlert
                                            .querySelector(
                                                '.content'
                                            )
                                            .textContent =
                                            res.message ||
                                            'Payment verified successfully!';


                                        successAlert.classList
                                            .remove(
                                                'hidden'
                                            );

                                    }


                                    if (
                                        dangerAlert
                                    ) {

                                        dangerAlert.classList
                                            .add(
                                                'hidden'
                                            );

                                    }


                                    setTimeout(
                                        () => {
                                            location.reload();
                                        },
                                        2000
                                    );

                                } else {

                                    if (
                                        dangerAlert
                                    ) {

                                        dangerAlert
                                            .querySelector(
                                                '.content'
                                            )
                                            .textContent =
                                            res.message ||
                                            'Transaction not found. Check if the Order ID is correct.';


                                        dangerAlert.classList
                                            .remove(
                                                'hidden'
                                            );

                                    }


                                    if (
                                        successAlert
                                    ) {

                                        successAlert.classList
                                            .add(
                                                'hidden'
                                            );

                                    }

                                }

                            }
                        )
                        .catch(
                            () => {

                                this.disabled =
                                    false;


                                const dangerAlert =
                                    document.querySelector(
                                        '.binance-alert-danger'
                                    );


                                if (
                                    dangerAlert
                                ) {

                                    dangerAlert
                                        .querySelector(
                                            '.content'
                                        )
                                        .textContent =
                                        'Network error. Please try again.';


                                    dangerAlert.classList
                                        .remove(
                                            'hidden'
                                        );

                                }

                            }
                        );

                }
            );

        }

        document.addEventListener(
            'click',
            function(e) {

                const btn =
                    e.target.closest(
                        '[data-for-clip]'
                    );

                if (!btn) {
                    return;
                }


                const target =
                    document.getElementById(
                        btn.dataset.forClip
                    );


                if (!target) {
                    return;
                }


                const val =
                    target.value ||
                    target.textContent;


                navigator.clipboard.writeText(
                    val
                );


                const old =
                    btn.innerText;


                btn.innerText =
                    'Copied!';


                setTimeout(
                    () => {
                        btn.innerText =
                            old;
                    },
                    2000
                );

            }
        );


        /* =========================================================
           BONUS PANEL
        ========================================================== */

        const sel =
            methodSelect;

        const detailsPanel = document.getElementById('payment-details');
        const detailsContent = document.getElementById('payment-details-content');

        function renderPaymentDetails(opt) {
            const details = (opt?.dataset?.details || '').trim();
            if (!detailsPanel || !detailsContent) return;
            // The details field stores the same HTML instruction markup as the
            // original add-funds form (paragraphs, links and text alignment).
            detailsContent.innerHTML = details;
            detailsPanel.style.display = details.replace(/<[^>]*>/g, '').trim() ? 'block' : 'none';
        }

        if (sel && detailsPanel && detailsContent) {
            renderPaymentDetails(sel.selectedOptions[0]);
            sel.addEventListener('change', () => renderPaymentDetails(sel.selectedOptions[0]));
            $(sel).on('select2:select', () => renderPaymentDetails(sel.selectedOptions[0]));
        }


        /* =========================================================
           DOWNLOAD INVOICE
        ========================================================== */

        document.addEventListener(
            'click',
            function(e) {

                const btn =
                    e.target.closest(
                        '.download-invoice-btn'
                    );

                if (!btn) {
                    return;
                }


                const paymentId =
                    btn.dataset.paymentId;


                const url =
                    '/addfunds/invoice/' +
                    paymentId +
                    '/download-direct';


                const iframe =
                    document.createElement(
                        'iframe'
                    );


                iframe.style.display =
                    'none';

                iframe.src =
                    url;


                document.body.appendChild(
                    iframe
                );


                setTimeout(
                    () => {

                        if (
                            iframe.parentNode
                        ) {

                            iframe.parentNode
                                .removeChild(
                                    iframe
                                );

                        }

                    },
                    2000
                );

            }
        );

    });
</script>

@endpush


