@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Cart</span>
    </nav>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Shopping Cart</h1>
            <p class="mt-1 text-gray-500 text-sm">Review your items before placing your order</p>
        </div>
        @if(count($items))
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    Clear Cart
                </button>
            </form>
        @endif
    </div>

    @if(count($items))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-3">
                @foreach($items as $item)
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-4 md:p-5 flex gap-4 items-start">
                        {{-- Product Image --}}
                        <a href="{{ route('products.show', $item['product']->slug) }}" class="shrink-0">
                            @if($item['product']->featured_image)
                                <img src="{{ $item['product']->featured_image }}" alt="{{ $item['product']->name }}"
                                     class="w-20 h-20 md:w-24 md:h-24 object-contain bg-gray-50 rounded-xl border border-gray-100 p-2">
                            @else
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5"/></svg>
                                </div>
                            @endif
                        </a>

                        {{-- Product Info --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item['product']->slug) }}" class="font-bold text-gray-900 text-sm md:text-base hover:text-brand-600 transition-colors line-clamp-2">
                                {{ $item['product']->name }}
                            </a>
                            @if($item['variation'])
                                <p class="text-xs text-brand-600 font-medium mt-0.5">
                                    {{ ucfirst($item['variation']->attribute_value ?? $item['variation']->name) }}
                                </p>
                            @endif
                            @if($item['price'] > 0)
                                <p class="text-sm font-bold text-gray-900 mt-1">${{ number_format($item['price'], 2) }}</p>
                            @else
                                <p class="text-xs text-gray-400 mt-1">Price on request</p>
                            @endif

                            {{-- Quantity & Remove (mobile-friendly) --}}
                            <div class="flex items-center gap-3 mt-3">
                                <form action="{{ route('cart.update', $item['key']) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                        <button type="submit" name="quantity" value="{{ max(0, $item['quantity'] - 1) }}"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-sm font-bold">−</button>
                                        <span class="w-10 text-center text-sm font-bold text-gray-900">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-sm font-bold">+</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.remove', $item['key']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Subtotal (desktop) --}}
                        <div class="hidden md:block text-right shrink-0">
                            @if($item['subtotal'] > 0)
                                <span class="text-lg font-extrabold text-gray-900">${{ number_format($item['subtotal'], 2) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Order Summary</h2>

                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Items</span>
                            <span class="font-medium text-gray-900">{{ collect($items)->sum('quantity') }}</span>
                        </div>
                        @if($total > 0)
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-900">${{ number_format($total, 2) }}</span>
                            </div>
                        @endif
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-bold text-gray-900">Estimated Total</span>
                            <span class="text-xl font-extrabold text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 mb-5">Shipping costs will be calculated at checkout.</p>

                    <a href="{{ route('checkout.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 bg-brand-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Proceed to Checkout
                    </a>

                    <a href="{{ route('products.index') }}" class="w-full inline-flex items-center justify-center gap-2 mt-3 text-gray-600 py-2.5 rounded-xl font-medium text-sm hover:text-brand-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Continue Browsing
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart --}}
        <div class="bg-white rounded-2xl border border-gray-200/80 p-16 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-3xl flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-400 max-w-md mx-auto mb-8">Browse our products and add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-600 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
