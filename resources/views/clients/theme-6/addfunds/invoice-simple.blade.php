<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $payment->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 0;
        }

        .invoice-container {
            width: 100%;
            max-width: 794px;
            margin: 0 auto;
            background: white;
            min-height: 1123px;
            padding: 56px 55px;
            border-top: 3px solid #252525;
            border-bottom: 3px solid #252525;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0;
        }

        .company-info {
            width: 50%;
            font-size: 14px;
            line-height: 1.05;
            color: #111827;
        }

        .company-info strong {
            color: inherit;
            font-weight: normal;
        }

        .company-logo {
            text-align: right;
        }

        .company-logo img {
            max-width: 220px;
            max-height: 145px;
            height: auto;
        }

        .invoice-title {
            text-align: center;
            margin: 100px 0 0;
            font-size: 16px;
            font-weight: normal;
            color: #111827;
        }

        .invoice-date {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 208px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 45px;
        }

        .invoice-table thead {
            background-color: #e8e8e8;
        }

        .invoice-table th {
            padding: 7px 8px;
            text-align: left;
            font-size: 14px;
            font-weight: normal;
            color: #111827;
            border: 0;
        }

        .invoice-table td {
            padding: 7px 8px;
            font-size: 14px;
            color: #111827;
            border: 0;
            border-bottom: 1px solid #d1d5db;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            width: 100%;
            margin-bottom: 40px;
        }

        .totals-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .totals-label {
            width: 190px;
            text-align: right;
            padding-right: 20px;
            font-weight: bold;
            color: #333;
        }

        .totals-value {
            width: 100px;
            text-align: right;
            color: #333;
        }

        .totals-row.total {
            padding: 8px 0;
            font-weight: bold;
            font-size: 14px;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-top: 3px solid #252525;
                border-bottom: 3px solid #252525;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>

<body>
    @php
        $invoiceLogo = !empty($config?->logo)
            ? asset('assets/media/' . basename($config->logo))
            : asset('assets/media/logo.png');
        $companyName = $config->title ?? config('app.name');
        $companyPhone = $config->phone_admin ?? '';
        $companyEmail = $config->other_contact ?? '';
        $currencyCode = $currency->code ?? 'USD';
        $currencyMark = $currencyCode === 'USD' ? '$' : $currencyCode;
    @endphp
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                {{ $companyName }}<br>
                {{ config('app.name') }}<br>
                @if ($companyPhone) {{ $companyPhone }}<br> @endif
                @if ($companyEmail) {{ $companyEmail }} @endif
            </div>
            <div class="company-logo">
                <img src="{{ $invoiceLogo }}" alt="{{ $companyName }}">
            </div>
        </div>

        <!-- Title -->
        <div class="invoice-title">INVOICE #{{ $payment->id }}</div>
        <div class="invoice-date">{{ $payment->created_at->format('Y-m-d') }}</div>

        <!-- Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>{{ __('addfunds.description') }}</th>
                    <th class="text-right">{{ __('newOrder.quantity') }}</th>
                    <th class="text-right">Price, {{ $currencyMark }}</th>
                    <th class="text-right">Amount, {{ $currencyMark }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $payment->paymentMethod->name ?? 'Payment' }}</td>
                    <td class="text-right">1</td>
                    <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                    <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <div class="totals-label">Subtotal, {{ $currencyMark }}</div>
                <div class="totals-value">{{ number_format($payment->amount, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">TAX (0%), {{ $currencyMark }}</div>
                <div class="totals-value">0.00</div>
            </div>
            <div class="totals-row total">
                <div class="totals-label">Total Amount, {{ $currencyMark }}</div>
                <div class="totals-value">{{ number_format($payment->amount, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.querySelector('.invoice-container');
            const opt = {
                margin: 0,
                filename: 'Invoice{{ $payment->id }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                }
            };
            html2pdf().set(opt).from(element).save();

            // Close the window after download starts
            setTimeout(function() {
                window.close();
            }, 1000);
        }

        // Auto-trigger PDF download on page load
        document.addEventListener('DOMContentLoaded', function() {
            downloadPDF();
        });
    </script>
</body>

</html>
