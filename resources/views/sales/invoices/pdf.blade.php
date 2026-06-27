<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .company-info {
            text-align: right;
            margin-bottom: 30px;
            font-size: 12px;
            color: #666;
        }
        .details-grid {
            width: 100%;
            margin-bottom: 40px;
        }
        .details-grid td {
            vertical-align: top;
            width: 50%;
        }
        .details-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .details-box h3 {
            margin-top: 0;
            color: #475569;
            font-size: 14px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th, table.items td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        table.items th {
            background: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        table.items td.right, table.items th.right {
            text-align: right;
        }
        .totals {
            width: 50%;
            float: right;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 8px 12px;
            text-align: right;
        }
        .totals .bold {
            font-weight: bold;
            font-size: 16px;
        }
        .totals .grand-total {
            background: #eff6ff;
            color: #1e3a8a;
            border-top: 2px solid #2563eb;
        }
        .footer {
            clear: both;
            margin-top: 60px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background: {{ $invoice->status === 'paid' ? '#dcfce7' : '#fee2e2' }};
            color: {{ $invoice->status === 'paid' ? '#166534' : '#991b1b' }};
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        
        <div class="header">
            <h1>TAX INVOICE</h1>
        </div>

        <table class="details-grid data-table">
            <tr>
                <td>
                    <div class="company-info" style="text-align: left;">
                        <h2 style="margin:0; color:#1e293b;">{{ env('APP_NAME', 'ERP System') }}</h2>
                        <p style="margin:5px 0;">123 Business Avenue, Suite 100</p>
                        <p style="margin:5px 0;">contact@company.com</p>
                        <p style="margin:5px 0;">+1 234 567 890</p>
                    </div>
                </td>
                <td>
                    <div class="details-box" style="margin-left: 20px;">
                        <h3>Invoice Details</h3>
                        <table style="width: 100%; font-size: 13px;">
                            <tr>
                                <td style="padding: 3px 0; color: #64748b;">Invoice No:</td>
                                <td style="padding: 3px 0; font-weight: bold; text-align: right;">{{ $invoice->invoice_number }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0; color: #64748b;">{{ __('messages.date_colon') }}</td>
                                <td style="padding: 3px 0; text-align: right;">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0; color: #64748b;">Due Date:</td>
                                <td style="padding: 3px 0; text-align: right;">{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0; color: #64748b;">{{ __('messages.status_colon') }}</td>
                                <td style="padding: 3px 0; text-align: right;">
                                    <span class="status-badge">{{ $invoice->status }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <div class="details-box" style="margin-bottom: 30px;">
            <h3>Billed To</h3>
            <p style="margin: 0; font-weight: bold; font-size: 16px;">{{ $invoice->customer->name ?? 'Walk-in Customer' }}</p>
            @if($invoice->customer)
                <p style="margin: 3px 0; color: #475569;">{{ $invoice->customer->company ?? '' }}</p>
                <p style="margin: 3px 0; color: #475569;">{{ $invoice->customer->email }}</p>
                <p style="margin: 3px 0; color: #475569;">{{ $invoice->customer->phone ?? '' }}</p>
                <p style="margin: 3px 0; color: #475569;">{{ $invoice->customer->address ?? '' }}</p>
            @endif
        </div>

        <table class="items data-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="right">{{ __('messages.qty') }}</th>
                    <th class="right">Unit Price</th>
                    <th class="right">{{ __('messages.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="right">${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td style="color: #64748b;">{{ __('messages.subtotal_colon') }}</td>
                    <td>${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b;">Tax Amount ({{ $invoice->tax_rate }}%):</td>
                    <td>${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td class="bold">Grand Total:</td>
                    <td class="bold">${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p style="margin: 0;">Thank you for your business!</p>
            <p style="margin: 5px 0;">Payment is due within 30 days of the invoice date.</p>
        </div>
    </div>
</body>
</html>
