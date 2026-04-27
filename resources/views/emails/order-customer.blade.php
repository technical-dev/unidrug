<x-mail::message>
# Hi {{ $order->name }},

Your order has been received. We will update you once it's up for delivery.

**Order reference:** #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}

## Your items
@foreach($order->items as $item)
- {{ $item['product_name'] }}@if(!empty($item['variation'])) ({{ $item['variation'] }})@endif &times; {{ $item['quantity'] }}
@endforeach

**Estimated total:** ${{ number_format($order->estimated_total, 2) }}
**Payment:** {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}

@if($order->tracking_token)
You can track your order anytime here:

<x-mail::button :url="route('order.track')">
Track your order
</x-mail::button>
@endif

Thank you for shopping with Unidrug.

— The Unidrug Team
</x-mail::message>
