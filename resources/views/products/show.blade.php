@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit(strip_tags($product->short_description ?? $product->description), 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <a href="{{ route('products.index') }}" class="hover:text-brand-600 transition-colors">Products</a>
        @if($product->categories->count())
            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <a href="{{ route('categories.show', $product->categories->first()->slug) }}" class="hover:text-brand-600 transition-colors">
                {{ $product->categories->first()->name }}
            </a>
        @endif
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-600 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 mb-20" x-data="{ mainImage: '{{ $product->featured_image ?? '' }}' }">
        {{-- Image Gallery --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden aspect-square relative group">
                @if($product->featured_image)
                    <img :src="mainImage" alt="{{ $product->name }}"
                         class="w-full h-full object-contain p-8 transition-transform duration-500 group-hover:scale-105">
                    {{-- Zoom hint --}}
                    <div class="absolute bottom-4 right-4 bg-black/40 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Hover to zoom
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                        <svg class="w-24 h-24 text-gray-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Thumbnail Gallery --}}
            @if($product->images->count() || $product->featured_image)
                <div class="flex gap-3 overflow-x-auto pb-1">
                    @if($product->featured_image)
                        <button @click="mainImage = '{{ $product->featured_image }}'"
                                :class="mainImage === '{{ $product->featured_image }}' ? 'ring-2 ring-brand-500 ring-offset-2' : 'ring-1 ring-gray-200 hover:ring-brand-300'"
                                class="w-18 h-18 rounded-xl overflow-hidden shrink-0 transition-all bg-white">
                            <img src="{{ $product->featured_image }}" class="w-full h-full object-contain p-1.5">
                        </button>
                    @endif
                    @foreach($product->images as $img)
                        <button @click="mainImage = '{{ $img->url }}'"
                                :class="mainImage === '{{ $img->url }}' ? 'ring-2 ring-brand-500 ring-offset-2' : 'ring-1 ring-gray-200 hover:ring-brand-300'"
                                class="w-18 h-18 rounded-xl overflow-hidden shrink-0 transition-all bg-white">
                            <img src="{{ $img->url }}" alt="{{ $img->alt }}" class="w-full h-full object-contain p-1.5">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="flex flex-col">
            {{-- Categories --}}
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($product->categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}"
                       class="text-xs font-semibold text-brand-600 bg-brand-50 px-3 py-1.5 rounded-full hover:bg-brand-100 transition-colors uppercase tracking-wide">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">{{ $product->name }}</h1>

            {{-- SKU & Stock --}}
            <div class="flex items-center gap-4 mb-6">
                @if($product->sku)
                    <span class="text-sm text-gray-400">SKU: <span class="text-gray-500 font-mono">{{ $product->sku }}</span></span>
                @endif
                @if($product->stock_status === 'instock')
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        In Stock
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-700 bg-red-50 px-3 py-1.5 rounded-full uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                        Sold Out
                    </span>
                @endif
            </div>

            {{-- Price --}}
            <div class="mb-6 pb-6 border-b border-gray-100">
                @if($product->price)
                    <div class="flex items-baseline gap-3">
                        @if($product->product_type === 'variable' && $product->variations->count())
                            <span class="text-sm text-gray-400 font-medium">From</span>
                        @endif
                        <span class="text-4xl font-extrabold text-gray-900">${{ $product->display_price }}</span>
                        <span class="text-sm text-gray-400">USD</span>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-semibold text-gray-400">Price on request</span>
                        <span class="text-xs bg-amber-50 text-amber-700 font-semibold px-2.5 py-1 rounded-full">Contact us</span>
                    </div>
                @endif
            </div>

            {{-- Short Description --}}
            @if($product->short_description)
                <div class="text-gray-500 text-[0.95rem] leading-relaxed mb-6 prose prose-sm max-w-none prose-p:text-gray-500">
                    {!! $product->short_description !!}
                </div>
            @endif

            {{-- Variations --}}
            @if($product->variations->count())
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Available Options</h3>
                    <div class="space-y-2">
                        @foreach($product->variations as $variation)
                            <div class="flex items-center justify-between bg-gray-50/80 rounded-xl px-5 py-3.5 border border-gray-100 hover:border-brand-200 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-brand-400"></div>
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ ucfirst($variation->attribute_value ?? $variation->name) }}
                                    </span>
                                    @if($variation->sku)
                                        <span class="text-xs text-gray-300 font-mono">{{ $variation->sku }}</span>
                                    @endif
                                </div>
                                @if($variation->price)
                                    <span class="font-extrabold text-gray-900">${{ number_format($variation->price, 2) }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 mt-auto">
                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-brand-600 text-white py-3.5 px-6 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        Add to Cart
                    </button>
                </form>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-700 py-3.5 px-6 rounded-xl font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                    Direct Inquiry
                </a>
            </div>

            {{-- Trust signals --}}
            <div class="mt-8 grid grid-cols-2 gap-3">
                <div class="flex items-center gap-2.5 text-xs text-gray-400">
                    <svg class="w-4 h-4 shrink-0 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    Trusted supplier
                </div>
                <div class="flex items-center gap-2.5 text-xs text-gray-400">
                    <svg class="w-4 h-4 shrink-0 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    Lebanon delivery
                </div>
                <div class="flex items-center gap-2.5 text-xs text-gray-400">
                    <svg class="w-4 h-4 shrink-0 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    Wholesale pricing
                </div>
                <div class="flex items-center gap-2.5 text-xs text-gray-400">
                    <svg class="w-4 h-4 shrink-0 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                    Quality guaranteed
                </div>
            </div>
        </div>
    </div>

    {{-- Full Description --}}
    @if($product->description)
        <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden mb-20">
            <div class="px-6 md:px-8 py-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Product Description
                </h2>
            </div>
            <div class="px-6 md:px-8 py-6 md:py-8 prose prose-sm max-w-none text-gray-600 prose-headings:text-gray-900 prose-a:text-brand-600">
                {!! $product->description !!}
            </div>
        </div>
    @endif

    {{-- Related Products --}}
    @if($relatedProducts->count())
        <section class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Related Products</h2>
                <a href="{{ route('products.index') }}" class="text-brand-600 text-sm font-semibold hover:text-brand-700 transition-colors flex items-center gap-1">
                    View all
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5">
                @foreach($relatedProducts as $related)
                    @include('partials.product-card', ['product' => $related])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
