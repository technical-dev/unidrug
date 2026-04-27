<x-mail::message>
# You got a new order

**Order:** #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
**Customer:** {{ $order->name }}
**Email:** {{ $order->email }}
**Phone:** {{ $order->phone }}
@if($order->company)
**Company:** {{ $order->company }}
@endif

@php
    $deliveryLine = $order->address;
    if ($order->building) $deliveryLine .= ', ' . $order->building;
    if ($order->floor) $deliveryLine .= ', ' . $order->floor;
    $deliveryLine .= ', ' . $order->city;
@endphp

**Delivery:** {{ $deliveryLine }}
**Payment:** {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}

---

## Items
@foreach($order->items as $item)
@php
    $line = '- ' . $item['product_name'];
    if (!empty($item['variation'])) $line .= ' (' . $item['variation'] . ')';
    $line .= ' x ' . $item['quantity'];
    if (!empty($item['subtotal']) && $item['subtotal'] > 0) $line .= ' — $' . number_format($item['subtotal'], 2);
@endphp
{{ $line }}
@endforeach

**Estimated Total:** ${{ number_format($order->estimated_total, 2) }}

@if($order->delivery_notes)
**Delivery notes:** {{ $order->delivery_notes }}
@endif
@if($order->message)
**Message:** {{ $order->message }}
@endif

<x-mail::button :url="url('/admin/quotes/' . $order->id)">
View order
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
