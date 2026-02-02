<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Export - {{ date('Y-m-d') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4472C4;
        }
        .header h1 {
            font-size: 20px;
            color: #4472C4;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11px;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        .info p {
            margin: 3px 0;
            font-size: 9px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead {
            background-color: #4472C4;
            color: white;
        }
        th {
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #4472C4;
        }
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 8px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        .status-active {
            color: #10b981;
            font-weight: bold;
        }
        .status-inactive {
            color: #6b7280;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Products Export</h1>
        <p>Apex Electronics & Accessories</p>
        <p>Generated on: {{ $export_date }}</p>
    </div>

    <div class="info">
        <p><strong>Total Products:</strong> {{ $total }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">SKU</th>
                <th style="width: 20%;">Product Name</th>
                <th style="width: 12%;">Category</th>
                <th style="width: 12%;">Brand</th>
                <th style="width: 10%;">Barcode</th>
                <th style="width: 10%;" class="text-right">Cost Price</th>
                <th style="width: 10%;" class="text-right">Selling Price</th>
                <th style="width: 6%;" class="text-center">Qty</th>
                <th style="width: 8%;" class="text-center">Reorder</th>
                <th style="width: 4%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category?->name ?? '—' }}</td>
                <td>{{ $product->brand?->name ?? '—' }}</td>
                <td>{{ $product->barcode ?? '—' }}</td>
                <td class="text-right">{{ $product->cost_price ? number_format($product->cost_price, 2) . ' UGX' : '—' }}</td>
                <td class="text-right">{{ $product->selling_price ? number_format($product->selling_price, 2) . ' UGX' : '—' }}</td>
                <td class="text-center">{{ $product->quantity ?? 0 }}</td>
                <td class="text-center">{{ $product->reorder_level ?? 0 }}</td>
                <td class="text-center">
                    <span class="status-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px;">
                    No products found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This document was generated automatically by Apex Electronics & Accessories Management System</p>
        <p>Generated on {{ $export_date }}</p>
    </div>
</body>
</html>
