<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quote #QR-{{ str_pad($quote->id, 5, '0', STR_PAD_LEFT) }} — Unidrug</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1f2937; font-size: 14px; line-height: 1.5; background: #fff; }
        .page { max-width: 800px; margin: 0 auto; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 2px solid #10b981; }
        .brand { font-size: 28px; font-weight: 800; color: #1f2937; }
        .brand span { color: #10b981; }
        .brand-sub { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 2px; }
        .quote-ref { text-align: right; }
        .quote-ref h2 { font-size: 18px; color: #374151; margin-bottom: 4px; }
        .quote-ref p { font-size: 12px; color: #6b7280; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .info-box h3 { font-size: 11px; text-transform: uppercase; color: #9ca3af; letter-spacing: 1px; margin-bottom: 8px; }
        .info-box p { font-size: 14px; color: #374151; }
        .info-box p strong { color: #111827; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        thead th { background: #f9fafb; padding: 10px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e5e7eb; }
        tbody td { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; }
        tbody tr:last-child td { border-bottom: none; }
        .product-name { font-weight: 600; color: #111827; }
        .product-sku { font-size: 11px; color: #9ca3af; font-family: monospace; }
        .text-right { text-align: right; }
        .total-row { background: #f0fdf4; }
        .total-row td { font-weight: 700; font-size: 16px; color: #065f46; padding: 14px 16px; }
        .status { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-reviewed { background: #dbeafe; color: #1e40af; }
        .status-quoted { background: #ede9fe; color: #5b21b6; }
        .status-accepted { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 12px; color: #9ca3af; }
        .notes { background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 30px; }
        .notes h3 { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 6px; }
        .notes p { color: #374151; }
        @media print {
            body { background: none; }
            .page { padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #f3f4f6; padding: 12px; text-align: center; border-bottom: 1px solid #e5e7eb;">
        <button onclick="window.print()" style="background: #10b981; color: #fff; border: none; padding: 8px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
            Print / Save PDF
        </button>
        <a href="{{ route('admin.quotes.show', $quote) }}" style="margin-left: 12px; color: #6b7280; font-size: 14px; text-decoration: none;">
            &larr; Back to Quote
        </a>
    </div>

    <div class="page">
        <div class="header">
            <div>
                <div class="brand">uni<span>drug</span></div>
                <div class="brand-sub">Lebanon</div>
            </div>
            <div class="quote-ref">
                <h2>Quote Request #QR-{{ str_pad($quote->id, 5, '0', STR_PAD_LEFT) }}</h2>
                <p>{{ $quote->created_at->format('F d, Y') }}</p>
                <div style="margin-top: 6px;">
                    <span class="status status-{{ $quote->status }}">{{ ucfirst($quote->status) }}</span>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Customer Information</h3>
                <p><strong>{{ $quote->name }}</strong></p>
                <p>{{ $quote->email }}</p>
                @if($quote->phone)
                    <p>{{ $quote->phone }}</p>
                @endif
                @if($quote->company)
                    <p>{{ $quote->company }}</p>
                @endif
            </div>
            <div class="info-box">
                <h3>Quote Details</h3>
                <p><strong>Items:</strong> {{ is_array($quote->items) ? count($quote->items) : 0 }}</p>
                <p><strong>Est. Total:</strong> ${{ number_format($quote->estimated_total, 2) }}</p>
                <p><strong>Submitted:</strong> {{ $quote->created_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>

        @if(is_array($quote->items) && count($quote->items))
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quote->items as $i => $item)
                        <tr>
                            <td style="color: #9ca3af;">{{ $i + 1 }}</td>
                            <td>
                                <div class="product-name">{{ $item['name'] ?? 'Product' }}</div>
                                @if(!empty($item['sku']))
                                    <div class="product-sku">{{ $item['sku'] }}</div>
                                @endif
                            </td>
                            <td class="text-right">{{ $item['quantity'] ?? 1 }}</td>
                            <td class="text-right">${{ number_format($item['price'] ?? 0, 2) }}</td>
                            <td class="text-right">${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" class="text-right">Estimated Total</td>
                        <td class="text-right">${{ number_format($quote->estimated_total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        @if($quote->message)
            <div class="notes">
                <h3>Customer Notes</h3>
                <p>{{ $quote->message }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Unidrug Lebanon &bull; info@unidrug.com</p>
            <p style="margin-top: 4px;">This is a quote request — not a confirmed order.</p>
        </div>
    </div>
</body>
</html>
