<!DOCTYPE html>
<html lang="{{ auth()->user()?->lang ?? 'en' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $payment->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .invoice-number {
            text-align: right;
        }

        .invoice-number h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .invoice-number p {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .info-section h4 {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item {
            margin-bottom: 12px;
            font-size: 14px;
        }

        .info-item label {
            color: #666;
            font-weight: 500;
            display: block;
            margin-bottom: 3px;
        }

        .info-item p {
            color: #333;
            margin: 0;
        }

        .invoice-table {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
        }

        .invoice-table thead {
            background-color: #f8f9fa;
            border-top: 2px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
        }

        .invoice-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .invoice-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
            color: #333;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: 2px solid #dee2e6;
        }

        .text-end {
            text-align: right;
        }

        .amount-bold {
            font-weight: 600;
            color: #007bff;
        }

        .invoice-total {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .total-box {
            width: 300px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .total-row.final {
            border-top: 2px solid #dee2e6;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        .invoice-notes {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 40px;
            border-radius: 4px;
        }

        .invoice-notes h5 {
            font-size: 13px;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .invoice-notes p {
            font-size: 13px;
            color: #0056b3;
            margin: 5px 0;
        }

        .invoice-footer {
            text-align: center;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
            color: #666;
            font-size: 12px;
        }

        .invoice-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-print {
            background-color: #6c757d;
            color: white;
        }

        .btn-print:hover {
            background-color: #5a6268;
        }

        .btn-pdf {
            background-color: #007bff;
            color: white;
        }

        .btn-pdf:hover {
            background-color: #0056b3;
        }

        .btn-close {
            background-color: #dc3545;
            color: white;
        }

        .btn-close:hover {
            background-color: #c82333;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                padding: 0;
            }

            .invoice-actions {
                display: none;
            }

            .btn {
                display: none;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }

        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div>
                <div class="company-logo">{{ config('app.name') }}</div>
                <p style="color: #666; font-size: 13px; margin: 0;">{{ config('app.url') }}</p>
            </div>
            <div class="invoice-number">
                <h3 data-lang="Invoice">Invoice</h3>
                <p>#{{ $payment->id }}</p>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <!-- Left Column: Company & Customer Info -->
            <div>
                <div class="info-section">
                    <h4 data-lang="Company Information">Company Information</h4>
                    <div class="info-item">
                        <p><strong>{{ config('app.name') }}</strong></p>
                    </div>
                </div>

                <div class="info-section" style="margin-top: 30px;">
                    <h4 data-lang="Customer Information">Customer Information</h4>
                    <div class="info-item">
                        <label data-lang="Name">Name</label>
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                    <div class="info-item">
                        <label data-lang="Email">Email</label>
                        <p>{{ auth()->user()->email }}</p>
                    </div>
                    <div class="info-item">
                        <label data-lang="Username">Username</label>
                        <p>{{ auth()->user()->username }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Invoice Details -->
            <div>
                <div class="info-section">
                    <h4 data-lang="Invoice Details">Invoice Details</h4>
                    <div class="info-item">
                        <label data-lang="Date">Date</label>
                        <p>{{ $payment->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="info-item">
                        <label data-lang="Status">Status</label>
                        <p>
                            <span data-lang="Status {{ ucfirst($payment->status) }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="info-section" style="margin-top: 30px;">
                    <h4 data-lang="Payment Information">Payment Information</h4>
                    <div class="info-item">
                        <label data-lang="Choose method">Payment Method</label>
                        <p>
                            @if ($payment->paymentMethod?->image)
                                <img src="{{ $payment->paymentMethod->image }}"
                                    alt="{{ $payment->paymentMethod->name }}"
                                    style="height: 20px; margin-right: 8px; vertical-align: middle;">
                            @endif
                            {{ $payment->paymentMethod->name ?? 'N/A' }}
                        </p>
                    </div>
                    @if ($payment->reference)
                        <div class="info-item">
                            <label data-lang="Reference">Reference</label>
                            <p>{{ $payment->reference }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th data-lang="Description">Description</th>
                    <th class="text-end" data-lang="Amount">Amount</th>
                    <th class="text-end" data-lang="Currency">Currency</th>
                    <th class="text-end" data-lang="Total">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong data-lang="Deposit Amount">Deposit Amount</strong><br>
                        <small style="color: #999;">{{ $payment->created_at->format('d/m/Y H:i:s') }}</small>
                    </td>
                    <td class="text-end">{{ number_format($payment->amount, 0, ',', ',') }}</td>
                    <td class="text-end">{{ $payment->currency ?? $currency->code }}</td>
                    <td class="text-end amount-bold">
                        {{ number_format($payment->amount, 0, ',', ',') }} {{ $payment->currency ?? $currency->code }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="invoice-total">
            <div class="total-box">
                <div class="total-row">
                    <span><span data-lang="Amount">Amount</span>:</span>
                    <span>{{ number_format($payment->amount, 0, ',', ',') }}
                        {{ $payment->currency ?? $currency->code }}</span>
                </div>
                <div class="total-row final">
                    <span><span data-lang="Total">Total</span>:</span>
                    <span>{{ number_format($payment->amount, 0, ',', ',') }}
                        {{ $payment->currency ?? $currency->code }}</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="invoice-notes">
            <h5 data-lang="Notes">Notes</h5>
            <p data-lang="Invoice note 1">This invoice is automatically generated from the system.</p>
            <p data-lang="Invoice note 2">Please keep this invoice as proof of payment.</p>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p data-lang="Thank you">Thank you for using our service!</p>
            <p>{{ config('app.name') }} © {{ date('Y') }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="invoice-actions">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> <span data-lang="Print">Print</span>
            </button>
            <button class="btn btn-pdf" onclick="downloadPDF()">
                <i class="fas fa-download"></i> <span data-lang="Download PDF">Download PDF</span>
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/client/language.js') }}?v={{ config('app.version') }}"></script>
    <script>
        document.querySelectorAll('[data-lang]').forEach(function(element) {
            var key = element.getAttribute('data-lang');
            var value = LANGUAGE?.language?.['/addfunds']?.[key] ||
                LANGUAGE?.core?.['/addfunds']?.[key] || key;
            element.textContent = value;
        });
        document.title = (LANGUAGE?.language?.['/addfunds']?.Invoice ||
            LANGUAGE?.core?.['/addfunds']?.Invoice || 'Invoice') + ' #{{ $payment->id }}';
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.querySelector('.invoice-container');
            const opt = {
                margin: 10,
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
        }

        // Auto-hide action buttons on print
        window.addEventListener('beforeprint', function() {
            document.querySelector('.invoice-actions').style.display = 'none';
        });

        window.addEventListener('afterprint', function() {
            document.querySelector('.invoice-actions').style.display = 'flex';
        });

        // Auto-trigger PDF download if download flag is set
        @if ($download ?? false)
            document.addEventListener('DOMContentLoaded', function() {
                downloadPDF();
            });
        @endif
    </script>
</body>

</html>

