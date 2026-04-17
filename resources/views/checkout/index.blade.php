@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <a href="{{ route('cart.index') }}" class="hover:text-brand-600 transition-colors">Cart</a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Checkout</span>
    </nav>

    {{-- Steps --}}
    <div class="flex items-center justify-center gap-3 mb-10 text-sm">
        <div class="flex items-center gap-2 text-brand-600">
            <span class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-xs font-bold">1</span>
            <span class="font-semibold hidden sm:inline">Cart</span>
        </div>
        <div class="w-8 h-px bg-brand-200"></div>
        <div class="flex items-center gap-2 text-brand-600">
            <span class="w-7 h-7 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">2</span>
            <span class="font-bold hidden sm:inline">Details & Delivery</span>
        </div>
        <div class="w-8 h-px bg-gray-200"></div>
        <div class="flex items-center gap-2 text-gray-400">
            <span class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold">3</span>
            <span class="font-medium hidden sm:inline">Confirmation</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Checkout Form --}}
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Contact Information --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <span class="w-7 h-7 bg-brand-100 text-brand-700 rounded-lg flex items-center justify-center text-xs font-bold">1</span>
                        Contact Information
                    </h2>
                    <p class="text-sm text-gray-400 mb-5 ml-9">How can we reach you about this order?</p>

                    <div class="space-y-4 ml-0 md:ml-9">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Full Name <span class="text-red-400">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('name') border-red-300 @enderror"
                                       placeholder="John Doe">
                                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email <span class="text-red-400">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('email') border-red-300 @enderror"
                                       placeholder="john@company.com">
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone <span class="text-red-400">*</span></label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('phone') border-red-300 @enderror"
                                       placeholder="+961 XX XXX XXX">
                                @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Company <span class="text-gray-300 font-normal normal-case">(optional)</span></label>
                                <input type="text" name="company" value="{{ old('company') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                                       placeholder="Your company name">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Delivery Address --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <span class="w-7 h-7 bg-brand-100 text-brand-700 rounded-lg flex items-center justify-center text-xs font-bold">2</span>
                        Delivery Address
                    </h2>
                    <p class="text-sm text-gray-400 mb-5 ml-9">Where should we deliver your order?</p>

                    <div class="space-y-4 ml-0 md:ml-9">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">City / Area <span class="text-red-400">*</span></label>
                            <select name="city" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('city') border-red-300 @enderror">
                                <option value="">— Select city —</option>
                                @foreach(['Beirut', 'Tripoli', 'Sidon (Saida)', 'Tyre (Sour)', 'Jounieh', 'Byblos (Jbeil)', 'Baalbek', 'Zahle', 'Nabatieh', 'Batroun', 'Aley', 'Broummana', 'Beit Mery', 'Chouf', 'Keserwan', 'Metn', 'Akkar', 'Hermel', 'Rashaya', 'Hasbaya', 'Koura', 'Zgharta', 'Bsharri', 'Minieh-Danniyeh', 'Jezzine'] as $city)
                                    <option value="{{ $city }}" {{ old('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                            @error('city') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Street Address <span class="text-red-400">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}" required
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('address') border-red-300 @enderror"
                                   placeholder="Street name, neighborhood...">
                            @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Building <span class="text-gray-300 font-normal normal-case">(optional)</span></label>
                                <input type="text" name="building" value="{{ old('building') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                                       placeholder="Building name / number">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Floor <span class="text-gray-300 font-normal normal-case">(optional)</span></label>
                                <input type="text" name="floor" value="{{ old('floor') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                                       placeholder="e.g. 3rd floor">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Delivery Notes <span class="text-gray-300 font-normal normal-case">(optional)</span></label>
                            <textarea name="delivery_notes" rows="2"
                                      class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all resize-none"
                                      placeholder="Landmarks, gate code, preferred delivery time...">{{ old('delivery_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8" x-data="{ method: '{{ old('payment_method', 'cod') }}' }">
                    <h2 class="text-lg font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <span class="w-7 h-7 bg-brand-100 text-brand-700 rounded-lg flex items-center justify-center text-xs font-bold">3</span>
                        Payment Method
                    </h2>
                    <p class="text-sm text-gray-400 mb-5 ml-9">How would you like to pay?</p>

                    <div class="space-y-3 ml-0 md:ml-9">
                        <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all"
                               :class="method === 'cod' ? 'border-brand-500 bg-brand-50/50' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="payment_method" value="cod" x-model="method" class="mt-0.5 text-brand-600 focus:ring-brand-500">
                            <div>
                                <p class="text-sm font-bold text-gray-900">Cash on Delivery (COD)</p>
                                <p class="text-xs text-gray-500 mt-0.5">Pay when your order is delivered to your doorstep</p>
                            </div>
                            <svg class="w-6 h-6 text-brand-500 ml-auto shrink-0 mt-0.5" :class="method === 'cod' ? 'opacity-100' : 'opacity-0'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </label>

                        <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all"
                               :class="method === 'bank_transfer' ? 'border-brand-500 bg-brand-50/50' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="payment_method" value="bank_transfer" x-model="method" class="mt-0.5 text-brand-600 focus:ring-brand-500">
                            <div>
                                <p class="text-sm font-bold text-gray-900">Bank Transfer</p>
                                <p class="text-xs text-gray-500 mt-0.5">Transfer to our bank account — details will be sent via email</p>
                            </div>
                            <svg class="w-6 h-6 text-brand-500 ml-auto shrink-0 mt-0.5" :class="method === 'bank_transfer' ? 'opacity-100' : 'opacity-0'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </label>
                        @error('payment_method') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Additional Notes --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                        Additional Notes
                    </h2>
                    <div class="mt-3">
                        <textarea name="message" rows="3"
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all resize-none"
                                  placeholder="Any special requirements, preferred quantities, or other details...">{{ old('message') }}</textarea>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-600 text-white py-3.5 px-6 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Place Order
                    </button>
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 border border-gray-200 text-gray-600 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Back to Cart
                    </a>
                </div>
            </form>
        </div>

        {{-- Order Summary Sidebar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 sticky top-24">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Order Summary</h3>
                
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @foreach($items as $item)
                        <div class="flex gap-3">
                            @if($item['product']->featured_image)
                                <img src="{{ $item['product']->featured_image }}" class="w-12 h-12 object-contain bg-gray-50 rounded-lg border border-gray-100 p-1 shrink-0">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-lg shrink-0 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-gray-900 truncate">{{ $item['product']->name }}</p>
                                @if($item['variation'])
                                    <p class="text-[10px] text-brand-500 font-medium">{{ ucfirst($item['variation']->attribute_value ?? $item['variation']->name) }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-0.5">Qty: {{ $item['quantity'] }}
                                    @if($item['price'] > 0) &times; ${{ number_format($item['price'], 2) }} @endif
                                </p>
                            </div>
                            @if($item['subtotal'] > 0)
                                <span class="text-xs font-bold text-gray-900 shrink-0">${{ number_format($item['subtotal'], 2) }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-900">Estimated Total</span>
                        <span class="text-lg font-extrabold text-gray-900">${{ number_format($total, 2) }}</span>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1.5">* Delivery charges may apply based on your location</p>
                </div>

                {{-- Trust signals --}}
                <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        Secure & trusted since 1971
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.079-.504 1.009-1.12a38.42 38.42 0 00-.648-3.727c-.165-.62-.687-1.103-1.323-1.153h-4.276M8.25 6.75h5.906c.457 0 .884.212 1.163.564l3.181 4.011c.193.243.3.54.3.848V18M3.75 18V9.574c0-.412.225-.792.584-.99L10.5 5.25"/></svg>
                        Delivery across Lebanon
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        Support: +961 XX XXX XXX
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
