<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Sale #{{ $sale->id }}</title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 0;
            margin: 0;
        }
        
        .receipt-container {
            width: 80mm;
            margin: 0 auto;
            background: white;
            padding: 12px 10px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            line-height: 1.3;
        }
        
        .header p {
            font-size: 9px;
            color: #333;
            line-height: 1.4;
            margin: 2px 0;
        }
        
        .info-section {
            margin-bottom: 8px;
            font-size: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            padding: 1px 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #000;
        }
        
        .divider {
            border-top: 1px dashed #333;
            margin: 6px 0;
        }
        
        .items-table {
            width: 100%;
            margin: 8px 0;
            font-size: 9px;
        }
        
        .items-table thead {
            border-bottom: 1px solid #333;
        }
        
        .items-table th {
            text-align: left;
            padding: 3px 0;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }
        
        .items-table td {
            padding: 2px 0;
            border-bottom: 1px dotted #ccc;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-sku {
            font-size: 7px;
            color: #666;
            font-family: monospace;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .summary {
            margin-top: 8px;
            font-size: 10px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }
        
        .summary-label {
            font-weight: bold;
        }
        
        .summary-total {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            padding: 5px 0;
            margin: 5px 0;
            font-size: 12px;
            font-weight: bold;
        }
        
        .payment-info {
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px dashed #333;
            font-size: 9px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        
        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px dashed #333;
            font-size: 8px;
            color: #666;
            line-height: 1.4;
        }
        
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-partial {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-pending {
            background: #f8d7da;
            color: #721c24;
        }
        
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>APEX ELECTRONICS & ACCESSORIES</h1>
            <p style="margin-top: 5px; font-size: 9px; line-height: 1.4;">
                Kireka, Kampala<br>
                Tel: 0708833157 / 0778777809<br>
                Email: info@apexelectronics.com
            </p>
            <div style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed #333;">
                <p style="font-size: 10px; font-weight: bold; margin-bottom: 3px;">SALES RECEIPT</p>
                <p style="font-size: 9px; color: #666;">Thank you for your purchase!</p>
            </div>
        </div>

        <!-- Receipt Info -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Receipt #:</span>
                <span class="info-value">{{ $sale->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date:</span>
                <span class="info-value">{{ $sale->created_at->format('M d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Time:</span>
                <span class="info-value">{{ $sale->created_at->format('h:i A') }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Customer Info -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Customer:</span>
                <span class="info-value">{{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}</span>
            </div>
            @if($sale->customer && $sale->customer->phone)
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $sale->customer->phone }}</span>
            </div>
            @endif
        </div>

        <div class="divider"></div>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleItems as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-sku">{{ $item->product->sku }}</div>
                    </td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 0) }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span class="summary-label">Subtotal:</span>
                <span>{{ number_format($sale->total_amount, 0) }} UGX</span>
            </div>
            @if($sale->discount > 0)
            <div class="summary-row">
                <span class="summary-label">Discount:</span>
                <span style="color: #dc3545;">-{{ number_format($sale->discount, 0) }} UGX</span>
            </div>
            @endif
            @if($sale->tax > 0)
            <div class="summary-row">
                <span class="summary-label">Tax:</span>
                <span>{{ number_format($sale->tax, 0) }} UGX</span>
            </div>
            @endif
            <div class="summary-row summary-total">
                <span>TOTAL:</span>
                <span>{{ number_format($sale->final_amount, 0) }} UGX</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Payment Information -->
        <div class="payment-info">
            <div class="payment-row">
                <span class="info-label">Payment Method:</span>
                <span class="info-value" style="text-transform: capitalize;">{{ str_replace('_', ' ', $sale->payment_method) }}</span>
            </div>
            <div class="payment-row">
                <span class="info-label">Status:</span>
                <span class="status-badge status-{{ $sale->payment_status }}">
                    {{ ucfirst($sale->payment_status) }}
                </span>
            </div>
            @if($sale->amount_paid > 0)
            <div class="payment-row">
                <span class="info-label">Amount Paid:</span>
                <span class="info-value">{{ number_format($sale->amount_paid, 0) }} UGX</span>
            </div>
            @endif
            @if($sale->balance > 0)
            <div class="payment-row">
                <span class="info-label">Balance:</span>
                <span class="info-value" style="color: #dc3545; font-weight: bold;">{{ number_format($sale->balance, 0) }} UGX</span>
            </div>
            @endif
        </div>

        <div class="divider"></div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Served by:</strong> {{ $sale->creator->name }}</p>
            <p style="margin-top: 6px;">Thank you for your business!</p>
            <p style="margin-top: 6px; font-size: 7px; color: #999;">
                This is a computer-generated receipt.<br>
                No signature required.
            </p>
        </div>
    </div>

</body>
</html>
