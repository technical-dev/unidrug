@extends('layouts.app')

@section('title', 'Track Your Order')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Track Order</span>
    </nav>

    <div class="text-center mb-10">
        <div class="w-16 h-16 mx-auto mb-5 bg-brand-50 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Track Your Order</h1>
        <p class="mt-2 text-gray-500 text-sm">Enter your order reference and email to check your order status.</p>
    </div>

    {{-- Lookup Form --}}
    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 mb-8">
        <form action="{{ route('order.track.lookup') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Order Reference <span class="text-red-400">*</span></label>
                <input type="text" name="reference" value="{{ old('reference') }}" required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('reference') border-red-300 @enderror"
                       placeholder="e.g. ORD-00005">
                @error('reference') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address <span class="text-red-400">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('email') border-red-300 @enderror"
                       placeholder="The email you used when ordering">
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-brand-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                Track Order
            </button>
        </form>
    </div>

    {{-- Order Result --}}
    @if(isset($order))
        <div class="space-y-6">
            {{-- Status Header --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Order Reference</p>
                        <p class="text-lg font-extrabold text-gray-900 font-mono">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    @php
                        $statusConfig = [
                            'pending'   => ['label' => 'Pending Review', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'reviewed'  => ['label' => 'Reviewed', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z'],
                            'quoted'    => ['label' => 'Quoted', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15'],
                            'accepted'  => ['label' => 'Confirmed', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'rejected'  => ['label' => 'Cancelled', 'bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                        $sc = $statusConfig[$order->status] ?? ['label' => ucfirst($order->status), 'bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => ''];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                        @if($sc['icon'])
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sc['icon'] }}"/></svg>
                        @endif
                        {{ $sc['label'] }}
                    </span>
                </div>

                {{-- Timeline --}}
                @php
                    $steps = ['pending', 'reviewed', 'accepted'];
                    $currentIndex = array_search($order->status, $steps);
                    if ($currentIndex === false) {
                        if ($order->status === 'quoted') $currentIndex = 1;
                        elseif ($order->status === 'rejected') $currentIndex = -1;
                        else $currentIndex = 0;
                    }
                @endphp
                <div class="flex items-center gap-0 w-full">
                    @foreach([['Placed', 0], ['Reviewed', 1], ['Confirmed', 2]] as [$label, $step])
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $step <= $currentIndex ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                                @if($step < $currentIndex)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @else
                                    {{ $step + 1 }}
                                @endif
                            </div>
                            <span class="text-[10px] font-semibold mt-1.5 {{ $step <= $currentIndex ? 'text-brand-700' : 'text-gray-400' }}">{{ $label }}</span>
                        </div>
                        @if(!$loop->last)
                            <div class="flex-1 h-0.5 -mt-4 {{ $step < $currentIndex ? 'bg-brand-500' : 'bg-gray-200' }}"></div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-6 pt-5 border-t border-gray-100 text-sm text-gray-500 grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-400 text-xs font-medium">Order Date</span>
                        <p class="text-gray-900 font-medium mt-0.5">{{ $order->created_at->format('M d, Y \\a\\t h:i A') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 text-xs font-medium">Payment</span>
                        <p class="text-gray-900 font-medium mt-0.5">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}</p>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-900">Order Items</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                        <div class="px-6 py-3 flex items-center justify-between text-sm">
                            <div>
                                <span class="font-semibold text-gray-900">{{ $item['product_name'] ?? 'Product' }}</span>
                                @if(!empty($item['variation']))
                                    <span class="text-brand-600 text-xs ml-1">({{ $item['variation'] }})</span>
                                @endif
                                <span class="text-gray-400 ml-1">&times; {{ $item['quantity'] }}</span>
                            </div>
                            @if(($item['subtotal'] ?? 0) > 0)
                                <span class="font-bold text-gray-900">${{ number_format($item['subtotal'], 2) }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-900">Estimated Total</span>
                    <span class="text-lg font-extrabold text-gray-900">${{ number_format($order->estimated_total, 2) }}</span>
                </div>
            </div>

            {{-- Delivery Info --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Delivery Information</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-400 font-medium text-xs">Delivery Address</dt>
                        <dd class="text-gray-900 mt-0.5">
                            {{ $order->address }}
                            @if($order->building), {{ $order->building }}@endif
                            @if($order->floor), {{ $order->floor }}@endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium text-xs">City</dt>
                        <dd class="text-gray-900 mt-0.5">{{ $order->city }}</dd>
                    </div>
                    @if($order->delivery_notes)
                        <div class="sm:col-span-2">
                            <dt class="text-gray-400 font-medium text-xs">Delivery Notes</dt>
                            <dd class="text-gray-700 mt-0.5 bg-gray-50 rounded-lg px-3 py-2">{{ $order->delivery_notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    @endif
</div>
@endsection
