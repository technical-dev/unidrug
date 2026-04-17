@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
    {{-- Success Icon --}}
    <div class="w-20 h-20 mx-auto mb-8 bg-gradient-to-br from-brand-50 to-brand-100 rounded-3xl flex items-center justify-center">
        <svg class="w-10 h-10 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">Order Placed Successfully!</h1>
    <p class="text-gray-500 max-w-md mx-auto mb-2">
        Thank you, <strong class="text-gray-700">{{ $quoteRequest->name }}</strong>. We've received your order and will process it shortly.
    </p>
    <p class="text-sm text-gray-400 mb-4">
        Order Reference: <span class="font-mono font-bold text-gray-600">#ORD-{{ str_pad($quoteRequest->id, 5, '0', STR_PAD_LEFT) }}</span>
    </p>

    {{-- Tracking Token --}}
    @if($quoteRequest->tracking_token)
        <div class="inline-flex items-center gap-2 bg-brand-50 border border-brand-200 text-brand-800 px-4 py-2 rounded-xl text-sm font-medium mb-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            Track your order anytime at <a href="{{ route('order.track') }}" class="underline font-bold hover:text-brand-900">Track Order</a>
        </div>
    @endif

    {{-- Summary Card --}}
    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 text-left mb-6">
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Order Summary</h2>
        
        <div class="space-y-3 mb-6">
            @foreach($quoteRequest->items as $item)
                <div class="flex items-center justify-between text-sm py-2 border-b border-gray-50 last:border-0">
                    <div>
                        <span class="font-semibold text-gray-900">{{ $item['product_name'] }}</span>
                        @if(!empty($item['variation']))
                            <span class="text-brand-600 text-xs ml-1">({{ $item['variation'] }})</span>
                        @endif
                        <span class="text-gray-400 ml-1">&times; {{ $item['quantity'] }}</span>
                    </div>
                    @if($item['subtotal'] > 0)
                        <span class="font-bold text-gray-900">${{ number_format($item['subtotal'], 2) }}</span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
            <span class="font-bold text-gray-900">Estimated Total</span>
            <span class="text-xl font-extrabold text-gray-900">${{ number_format($quoteRequest->estimated_total, 2) }}</span>
        </div>
    </div>

    {{-- Delivery Details --}}
    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 text-left mb-6">
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Delivery Details</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-400 font-medium">Delivery Address</dt>
                <dd class="text-gray-900 mt-0.5">
                    {{ $quoteRequest->address }}
                    @if($quoteRequest->building), {{ $quoteRequest->building }}@endif
                    @if($quoteRequest->floor), {{ $quoteRequest->floor }}@endif
                </dd>
            </div>
            <div>
                <dt class="text-gray-400 font-medium">City</dt>
                <dd class="text-gray-900 mt-0.5">{{ $quoteRequest->city }}</dd>
            </div>
            <div>
                <dt class="text-gray-400 font-medium">Payment Method</dt>
                <dd class="text-gray-900 mt-0.5">{{ $quoteRequest->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}</dd>
            </div>
            <div>
                <dt class="text-gray-400 font-medium">Contact</dt>
                <dd class="text-gray-900 mt-0.5">{{ $quoteRequest->phone }}</dd>
            </div>
        </dl>
    </div>

    {{-- Info --}}
    <div class="bg-brand-50 rounded-2xl border border-brand-100 p-5 mb-10 text-left">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-brand-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            <div>
                <p class="text-sm font-semibold text-brand-800">What happens next?</p>
                <p class="text-sm text-brand-700 mt-1">Our team will review your order and confirm it via email at <strong>{{ $quoteRequest->email }}</strong> within 24 hours. {{ $quoteRequest->payment_method === 'bank_transfer' ? 'Bank transfer details will be included in the confirmation email.' : 'Payment will be collected upon delivery.' }}</p>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('order.track') }}" class="inline-flex items-center justify-center gap-2 bg-brand-600 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            Track Your Order
        </a>
        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-700 px-8 py-3.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
