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
            background-color: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 60px 40px;
            border: 2px solid #333;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 60px;
        }

        .company-info {
            font-size: 13px;
            line-height: 1.8;
            color: #666;
        }

        .company-info strong {
            color: #333;
            font-weight: bold;
        }

        .company-logo {
            text-align: right;
        }

        .company-logo img {
            max-width: 150px;
            height: auto;
        }

        .invoice-title {
            text-align: center;
            margin: 80px 0 20px 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .invoice-date {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 80px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .invoice-table thead {
            background-color: #e8e8e8;
        }

        .invoice-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            border: 1px solid #ccc;
        }

        .invoice-table td {
            padding: 12px;
            font-size: 13px;
            color: #333;
            border: 1px solid #ccc;
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
            margin-bottom: 8px;
            font-size: 13px;
        }

        .totals-label {
            width: 150px;
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
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
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
                border: 1px solid #333;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <strong>{{ config('app.name') }}</strong><br>
                {{ config('app.url') }}<br>
                <br>
                <strong>Invoice #{{ $payment->id }}</strong><br>
                <strong>{{ $payment->created_at->format('Y-m-d') }}</strong>
            </div>
            <div class="company-logo">
                @if (config('app.logo'))
                    <img src="{{ config('app.logo') }}" alt="{{ config('app.name') }}">
                @else
                    <div style="font-size: 24px; font-weight: bold; color: #007bff;">{{ config('app.name') }}</div>
                @endif
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
                    <th class="text-right">{{ __('addfunds.amount') }}, {{ $currency->code }}</th>
                    <th class="text-right">{{ __('addfunds.total') }}, {{ $currency->code }}</th>
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
                <div class="totals-label">{{ __('cashflow.total') }}, {{ $currency->code }}</div>
                <div class="totals-value">{{ number_format($payment->amount, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">TAX (0%), {{ $currency->code }}</div>
                <div class="totals-value">0.00</div>
            </div>
            <div class="totals-row total">
                <div class="totals-label">{{ __('addfunds.total') }}, {{ $currency->code }}</div>
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
