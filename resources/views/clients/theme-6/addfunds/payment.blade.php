@extends('clients.theme-6.layouts.app')

@section('title', __('addfunds.title'))

@section('content')
    <div id="block_106p">
        <div class="block-bg"></div>
        <div class="container-fluid">

            @if ($payment)
                @php
                    $cfg = $payment->parsed_config;
                    $accountName = $cfg['account_name'] ?? ($cfg['name'] ?? null);
                    $accountNumber = $cfg['account_number'] ?? ($cfg['account'] ?? null);
                    $transferCode = auth()->user()->transfer_code ?? $ref;
                    $rawBank = $cfg['bank_code'] ?? ($cfg['bank'] ?? ($payment->name ?? null));
                    $bankCode = $rawBank ? trim(preg_replace('/^.*[\-\x{2013}]\s*/u', '', $rawBank)) : null;
                    $qrUrl = null;
                    if ($bankCode && $accountNumber) {
                        $qrUrl =
                            'https://img.vietqr.io/image/' .
                            urlencode($bankCode) .
                            '-' .
                            urlencode($accountNumber) .
                            '-qr_only.jpg' .
                            '?amount=' .
                            (int) $amount .
                            ($accountName ? '&accountName=' . urlencode($accountName) : '') .
                            '&addInfo=' .
                            urlencode($transferCode);
                    } elseif (!empty($cfg['qr_image'])) {
                        $qrUrl = $cfg['qr_image'];
                    } elseif ($payment->image_url) {
                        $qrUrl = $payment->image_url;
                    }
                @endphp

                <div class="pay-topbar">
                    <a href="{{ route('clients.addfunds.index') }}" class="pay-back">
                        <i class="fas fa-arrow-left"></i>
                        <span>{{ __('addfunds.go_back') }}</span>
                    </a>
                    <div class="pay-topbar__title">
                        <i class="fas fa-university"></i>
                        {{ __('addfunds.transfer_details') }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <div class="pay-card">
                            <div class="pay-card__header">
                                <div class="pay-card__bank-icon"><i class="fas fa-landmark"></i></div>
                                <div>
                                    <div class="pay-card__bank-name">{{ $payment->name }}</div>
                                    <div class="pay-card__subtitle">{{ __('addfunds.bank_transfer') ?? 'Bank Transfer' }}
                                    </div>
                                </div>
                            </div>
                            <div class="pay-card__body">
                                @if ($accountName)
                                    <div class="prow">
                                        <span class="prow__label"><i
                                                class="fas fa-user prow__icon"></i>{{ __('addfunds.account_holder') }}</span>
                                        <span class="prow__copy">
                                            <span id="val-name" class="prow__value">{{ $accountName }}</span>
                                            <button type="button" class="btn-clip" data-for-clip="val-name"><i
                                                    class="far fa-copy"></i></button>
                                        </span>
                                    </div>
                                @endif
                                @if ($accountNumber)
                                    <div class="prow">
                                        <span class="prow__label"><i
                                                class="fas fa-credit-card prow__icon"></i>{{ __('addfunds.account_number') }}</span>
                                        <span class="prow__copy">
                                            <span id="val-acc"
                                                class="prow__value prow__value--mono">{{ $accountNumber }}</span>
                                            <button type="button" class="btn-clip" data-for-clip="val-acc"><i
                                                    class="far fa-copy"></i></button>
                                        </span>
                                    </div>
                                @endif
                                <div class="prow">
                                    <span class="prow__label"><i
                                            class="fas fa-coins prow__icon"></i>{{ __('addfunds.amount') }}</span>
                                    <span class="prow__copy">
                                        <span id="val-amt"
                                            class="prow__value prow__value--amount">{{ number_format((float) $amount, 0, '.', ',') }}
                                            VND</span>
                                        <button type="button" class="btn-clip" data-for-clip="val-amt"
                                            data-raw="{{ (int) $amount }}"><i class="far fa-copy"></i></button>
                                    </span>
                                </div>
                                <div class="prow prow--ref">
                                    <span class="prow__label"><i
                                            class="fas fa-comment-alt prow__icon"></i>{{ __('addfunds.transfer_content') }}</span>
                                    <span class="prow__copy">
                                        <span id="val-ref"
                                            class="prow__value prow__value--ref">{{ $transferCode }}</span>
                                        <button type="button" class="btn-clip btn-clip--primary" data-for-clip="val-ref"><i
                                                class="far fa-copy"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="pnotice">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ __('addfunds.auto_scan_notice') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="pay-card pay-card--qr">
                            <div class="pay-card__qr-title"><i class="fas fa-qrcode"></i>{{ __('addfunds.scan_qr') }}</div>
                            @if ($qrUrl)
                                <div class="qr-wrap">
                                    <div class="qr-box">
                                        <img src="{{ $qrUrl }}" alt="QR" class="qr-img"
                                            crossorigin="anonymous" loading="lazy">
                                        <div class="scan-line"></div>
                                        <div class="qr-corner tl"></div>
                                        <div class="qr-corner tr"></div>
                                        <div class="qr-corner bl"></div>
                                        <div class="qr-corner br"></div>
                                    </div>
                                </div>
                                <div class="qr-hint"><i class="fas fa-mobile-alt"></i>{{ __('addfunds.open_banking_app') }}
                                </div>
                            @else
                                <div class="qr-empty"><i class="fas fa-qrcode"></i>
                                    <p>{{ __('addfunds.no_qr') }}</p>
                                </div>
                            @endif
                            <div class="qr-amount-badge">
                                <i class="fas fa-coins"></i>
                                {{ number_format((float) $amount, 0, '.', ',') }} VND
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="component_card">
                    <div class="card">
                        <div class="component_form_group text-center py-4">
                            <i class="fas fa-exclamation-circle fa-2x text-danger mb-3 d-block"></i>
                            <p>{{ __('addfunds.invalid_payment_data') }}</p>
                            <a href="{{ route('clients.addfunds.index') }}" class="btn btn-big-primary mt-2">
                                {{ __('addfunds.go_back') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .pay-topbar {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .pay-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            background: var(--card-bg, #fff);
            border: 1px solid var(--border-color, #e5e7eb);
            color: var(--text-color, #374151);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .pay-back:hover {
            background: var(--primary-color, #337ab7);
            color: #fff;
            border-color: var(--primary-color, #337ab7);
            text-decoration: none;
        }

        .pay-topbar__title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-color, #1f2937);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pay-card {
            background: var(--card-bg, #fff);
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .08);
            overflow: hidden;
            height: 100%;
        }

        .pay-card__header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color, #f3f4f6);
            background: linear-gradient(135deg, rgba(51, 122, 183, .06) 0%, rgba(51, 122, 183, .02) 100%);
        }

        .pay-card__bank-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-color, #337ab7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .pay-card__bank-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-color, #1f2937);
        }

        .pay-card__subtitle {
            font-size: .78rem;
            color: var(--text-muted, #9ca3af);
            margin-top: 2px;
        }

        .pay-card__body {
            padding: 8px 24px;
        }

        .prow {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color, rgba(0, 0, 0, .06));
        }

        .prow:last-of-type {
            border-bottom: none;
        }

        .prow__label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .72rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: .6px;
            color: var(--text-muted, #9ca3af);
            flex-shrink: 0;
            min-width: 140px;
        }

        .prow__icon {
            width: 14px;
            text-align: center;
            color: var(--primary-color, #337ab7);
        }

        .prow__copy {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .prow__value {
            font-weight: 600;
            font-size: .95rem;
            word-break: break-all;
            text-align: right;
            color: var(--text-color, #1f2937);
        }

        .prow__value--mono {
            font-family: 'Courier New', monospace;
            letter-spacing: .5px;
        }

        .prow__value--amount {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--primary-color, #337ab7);
        }

        .prow--ref {
            background: rgba(51, 122, 183, .05);
            border: 1.5px dashed var(--primary-color, #337ab7);
            border-radius: 10px;
            padding: 14px 16px;
            margin: 8px 0;
        }

        .prow--ref .prow__label {
            color: var(--primary-color, #337ab7);
        }

        .prow__value--ref {
            font-family: 'Courier New', monospace;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--primary-color, #337ab7);
        }

        .btn-clip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: var(--card-bg, #f8fafc);
            border: 1px solid var(--border-color, #e2e8f0);
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-muted, #9ca3af);
            flex-shrink: 0;
            transition: all .15s;
            font-size: .8rem;
        }

        .btn-clip:hover {
            background: var(--primary-color, #337ab7);
            color: #fff;
            border-color: var(--primary-color, #337ab7);
            transform: scale(1.08);
        }

        .btn-clip--primary {
            background: rgba(51, 122, 183, .1);
            color: var(--primary-color, #337ab7);
            border-color: rgba(51, 122, 183, .3);
        }

        .btn-clip.copied {
            background: #10b981;
            color: #fff;
            border-color: #10b981;
        }

        .pnotice {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            background: rgba(245, 158, 11, .07);
            border-left: 3px solid #f59e0b;
            padding: 12px 16px;
            font-size: .82rem;
            color: var(--text-color, #374151);
            line-height: 1.55;
            margin: 0 24px 20px;
        }

        .pnotice i {
            color: #f59e0b;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .pay-card--qr {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px 24px;
            gap: 16px;
        }

        .pay-card__qr-title {
            font-size: .85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-muted, #9ca3af);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qr-wrap {
            display: flex;
            justify-content: center;
        }

        .qr-box {
            position: relative;
            display: inline-block;
            padding: 14px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, .12);
            overflow: hidden;
        }

        .qr-img {
            display: block;
            width: 220px;
            height: 220px;
            object-fit: contain;
            border-radius: 8px;
        }

        .scan-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, #06d6a0 40%, #06d6a0 60%, transparent 100%);
            box-shadow: 0 0 10px 3px rgba(6, 214, 160, .6);
            animation: qr-scan 2.4s ease-in-out infinite;
            z-index: 5;
        }

        @keyframes qr-scan {
            0% {
                top: 0;
                opacity: 0
            }

            5% {
                opacity: 1
            }

            95% {
                opacity: 1
            }

            100% {
                top: calc(100% - 2px);
                opacity: 0
            }
        }

        .qr-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid #06d6a0;
            z-index: 6;
        }

        .qr-corner.tl {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
            border-radius: 4px 0 0 0;
        }

        .qr-corner.tr {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 4px 0 0;
        }

        .qr-corner.bl {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 4px;
        }

        .qr-corner.br {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 4px 0;
        }

        .qr-hint {
            font-size: .82rem;
            color: var(--text-muted, #9ca3af);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qr-amount-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(51, 122, 183, .1);
            color: var(--primary-color, #337ab7);
            border: 1.5px solid rgba(51, 122, 183, .3);
            border-radius: 24px;
            padding: 8px 20px;
            font-weight: 700;
            font-size: 1rem;
        }

        .qr-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            color: var(--text-muted, #9ca3af);
            padding: 40px 0;
        }

        .qr-empty i {
            font-size: 3rem;
            opacity: .3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Proxy external images to bypass CORS
            const qrImg = document.querySelector('.qr-img');
            if (qrImg && qrImg.src) {
                const url = qrImg.src;
                // Check if image is from external domain (imgur, etc)
                if (url.includes('imgur.com') || url.includes('i.imgur.com')) {
                    qrImg.src = '{{ route('proxy.image') }}?url=' + encodeURIComponent(url);
                }
            }

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-clip');
                if (!btn) return;
                const target = document.getElementById(btn.dataset.forClip);
                if (!target) return;
                const text = btn.dataset.raw || target.textContent.trim();
                navigator.clipboard.writeText(text).then(() => {
                    const icon = btn.querySelector('i');
                    const orig = icon.className;
                    icon.className = 'fas fa-check';
                    btn.classList.add('copied');
                    setTimeout(() => {
                        icon.className = orig;
                        btn.classList.remove('copied');
                    }, 2000);
                });
            });
        });
    </script>
@endpush
