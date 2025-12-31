<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #111318;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        
        .header {
            border-bottom: 2px solid #f0f2f4;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
        
        .header-content {
            display: table;
            width: 100%;
        }
        
        .brand-info {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .brand-name {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .brand-details {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.8;
        }
        
        .invoice-meta {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #d1fae5;
            color: #065f46;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .invoice-number {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .invoice-dates {
            font-size: 11px;
            color: #6b7280;
        }
        
        .addresses {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 1px solid #f0f2f4;
        }
        
        .address-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .address-title {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .address-content {
            font-size: 11px;
            line-height: 1.8;
        }
        
        .address-name {
            font-weight: bold;
            margin-bottom: 4px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        thead {
            border-bottom: 2px solid #dbdfe6;
        }
        
        th {
            text-align: left;
            padding: 12px 8px;
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        th.text-center {
            text-align: center;
        }
        
        th.text-right {
            text-align: right;
        }
        
        tbody tr {
            border-bottom: 1px solid #f0f2f4;
        }
        
        td {
            padding: 16px 8px;
            font-size: 11px;
        }
        
        td.text-center {
            text-align: center;
        }
        
        td.text-right {
            text-align: right;
        }
        
        .item-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .item-variant {
            font-size: 10px;
            color: #6b7280;
        }
        
        .totals-section {
            display: table;
            width: 100%;
            border-top: 1px solid #f0f2f4;
            padding-top: 20px;
        }
        
        .totals-spacer {
            display: table-cell;
            width: 50%;
        }
        
        .totals-content {
            display: table-cell;
            width: 50%;
        }
        
        .total-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            font-size: 11px;
        }
        
        .total-label {
            display: table-cell;
            color: #6b7280;
        }
        
        .total-value {
            display: table-cell;
            text-align: right;
            font-weight: 600;
        }
        
        .discount-label {
            color: #059669;
        }
        
        .grand-total {
            border-top: 2px solid #dbdfe6;
            margin-top: 8px;
            padding-top: 16px;
        }
        
        .grand-total .total-label {
            font-size: 14px;
            font-weight: bold;
            color: #111318;
        }
        
        .grand-total .total-value {
            font-size: 18px;
            font-weight: bold;
            color: #111318;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #f0f2f4;
            text-align: center;
        }
        
        .footer-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .footer-text {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="header-content">
                <div class="brand-info">
                    <div class="brand-name">Maneé</div>
                    <div class="brand-details">
                        <div>Maneé Official Store</div>
                        <div>Jalan Senopati No. 10</div>
                        <div>Jakarta Selatan, 12190</div>
                        <div>Indonesia</div>
                        <div>support@manee.id</div>
                    </div>
                </div>
                <div class="invoice-meta">
                    <div class="status-badge">
                        {{ $order->payment_status === 'paid' ? 'PAID' : 'UNPAID' }}
                    </div>
                    <div class="invoice-number">Invoice #{{ $order->order_number }}</div>
                    <div class="invoice-dates">
                        <div>Issued Date: <strong>{{ $order->created_at->format('M d, Y') }}</strong></div>
                        <div>Due Date: <strong>{{ $order->created_at->addDay()->format('M d, Y') }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Addresses --}}
        <div class="addresses">
            <div class="address-block">
                <div class="address-title">Bill To</div>
                <div class="address-content">
                    <div class="address-name">{{ $order->user->name }}</div>
                    <div>{{ $order->user->email }}</div>
                    <div>{{ $order->shippingAddress->phone_number }}</div>
                    <div>{{ $order->shippingAddress->address_line }}</div>
                    <div>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}</div>
                </div>
            </div>
            <div class="address-block">
                <div class="address-title">Ship To</div>
                <div class="address-content">
                    <div class="address-name">{{ $order->shippingAddress->recipient_name }}</div>
                    <div>{{ $order->shippingAddress->address_line }}</div>
                    <div>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->province }}</div>
                    <div>{{ $order->shippingAddress->postal_code }}</div>
                </div>
            </div>
        </div>

        {{-- Items Table --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 45%;">Item Description</th>
                    <th class="text-center" style="width: 15%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Unit Price</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->product->product_name }}</div>
                        <div class="item-variant">
                            @if($item->variant)
                                {{ $item->variant->color }} / {{ $item->variant->size }}
                            @else
                                -
                            @endif
                        </div>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">IDR {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="totals-section">
            <div class="totals-spacer"></div>
            <div class="totals-content">
                <div class="total-row">
                    <div class="total-label">Subtotal</div>
                    <div class="total-value">IDR {{ number_format($order->summary->subtotal, 0, ',', '.') }}</div>
                </div>
                <div class="total-row">
                    <div class="total-label">Shipping ({{ $order->shipping_method }})</div>
                    <div class="total-value">IDR {{ number_format($order->summary->shipping, 0, ',', '.') }}</div>
                </div>
                @if($order->summary->discount > 0)
                <div class="total-row">
                    <div class="total-label discount-label">Discount</div>
                    <div class="total-value discount-label">- IDR {{ number_format($order->summary->discount, 0, ',', '.') }}</div>
                </div>
                @endif
                <div class="total-row">
                    <div class="total-label">Tax (11%)</div>
                    <div class="total-value">IDR {{ number_format($order->summary->tax, 0, ',', '.') }}</div>
                </div>
                <div class="total-row grand-total">
                    <div class="total-label">Total</div>
                    <div class="total-value">IDR {{ number_format($order->summary->total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <div class="footer-title">Thank You for Your Purchase!</div>
            <div class="footer-text">
                <div>If you have any questions about this invoice, please contact us at support@manee.id</div>
                <div style="margin-top: 20px;">© 2023 Maneé Official Store. All rights reserved.</div>
            </div>
        </div>
    </div>
</body>
</html>
