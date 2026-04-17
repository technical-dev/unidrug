@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-gradient relative overflow-hidden">
        {{-- Decorative elements --}}
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-20 w-96 h-96 bg-brand-400/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-300/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-6">
                    <span class="w-2 h-2 bg-brand-400 rounded-full badge-pulse"></span>
                    <span class="text-white/80 text-xs font-medium tracking-wide uppercase">Premium Supplies for Lebanon</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] tracking-tight mb-6">
                    Professional<br>
                    <span class="bg-gradient-to-r from-brand-300 to-brand-100 bg-clip-text text-transparent">Cleaning & Hygiene</span><br>
                    Solutions
                </h1>

                <p class="text-lg md:text-xl text-white/70 mb-10 max-w-xl leading-relaxed">
                    From industrial-grade cleaning products to everyday hygiene essentials and pet care — we supply it all across Lebanon.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-brand-800 font-bold px-8 py-4 rounded-2xl hover:bg-brand-50 transition-all shadow-2xl shadow-black/20 hover:shadow-brand-900/30 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Browse Catalog
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-2xl border border-white/20 hover:bg-white/20 transition-all text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Contact Us
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex flex-wrap gap-8 mt-14 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-3xl font-bold text-white">{{ \App\Models\Product::where('status','active')->count() }}+</p>
                        <p class="text-sm text-white/50 mt-1">Products</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">{{ \App\Models\Category::where('is_active', true)->count() }}</p>
                        <p class="text-sm text-white/50 mt-1">Categories</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">B2B</p>
                        <p class="text-sm text-white/50 mt-1">Wholesale</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Banners Carousel --}}
    @if($banners->count())
    <section class="bg-white border-b border-gray-100" x-data="{ current: 0, total: {{ $banners->count() }}, auto: null, init() { this.auto = setInterval(() => { this.current = (this.current + 1) % this.total }, 5000) } }" x-init="init()">
        <div class="relative max-w-7xl mx-auto">
            {{-- Slides --}}
            <div class="relative overflow-hidden">
                @foreach($banners as $i => $banner)
                    <div x-show="current === {{ $i }}"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="relative"
                         {{ $i > 0 ? 'x-cloak' : '' }}>
                        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-10 px-4 sm:px-6 lg:px-8 py-8 md:py-12">
                            @if($banner->image)
                                <div class="w-full md:w-1/2 aspect-[16/9] md:aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1 {{ $banner->image ? '' : 'text-center py-6' }}">
                                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">{{ $banner->title }}</h2>
                                @if($banner->subtitle)
                                    <p class="text-brand-600 font-semibold mt-1">{{ $banner->subtitle }}</p>
                                @endif
                                @if($banner->description)
                                    <p class="text-gray-500 mt-3 text-sm leading-relaxed max-w-lg">{{ $banner->description }}</p>
                                @endif
                                @if($banner->button_text && $banner->button_url)
                                    <a href="{{ $banner->button_url }}" class="inline-flex items-center gap-2 mt-5 bg-brand-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/25 text-sm">
                                        {{ $banner->button_text }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Nav dots + arrows (only if multiple banners) --}}
            @if($banners->count() > 1)
                <div class="flex items-center justify-center gap-3 pb-6">
                    <button @click="current = (current - 1 + total) % total; clearInterval(auto)" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </button>
                    @foreach($banners as $i => $b)
                        <button @click="current = {{ $i }}; clearInterval(auto)" :class="current === {{ $i }} ? 'bg-brand-600 w-6' : 'bg-gray-300 w-2'" class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                    <button @click="current = (current + 1) % total; clearInterval(auto)" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </button>
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- Trust Bar --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-brand-50 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5.5 h-5.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Delivery</p>
                        <p class="text-xs text-gray-500">Across Lebanon</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5.5 h-5.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Quality</p>
                        <p class="text-xs text-gray-500">Certified Products</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-amber-50 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5.5 h-5.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Wholesale</p>
                        <p class="text-xs text-gray-500">Bulk Discounts</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-purple-50 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5.5 h-5.5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Support</p>
                        <p class="text-xs text-gray-500">Expert Guidance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories Section --}}
    @if($topCategories->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-brand-600 text-sm font-semibold uppercase tracking-wider mb-2">Browse</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Shop by Category</h2>
            </div>
            <a href="{{ route('categories.index') }}" class="hidden sm:inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-700 text-sm font-semibold group transition-colors">
                View All
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @foreach($topCategories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                   class="group relative bg-white rounded-2xl border border-gray-200/80 p-5 md:p-6 hover:border-brand-200 card-hover overflow-hidden">
                    {{-- Background decoration --}}
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-brand-50 to-transparent rounded-bl-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="relative">
                        @if($category->image)
                            <div class="w-14 h-14 mb-4 rounded-2xl overflow-hidden bg-gray-50 p-1 cat-icon">
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-14 h-14 mb-4 bg-gradient-to-br from-brand-100 to-brand-50 rounded-2xl flex items-center justify-center cat-icon">
                                <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                            </div>
                        @endif
                        <h3 class="font-bold text-gray-900 group-hover:text-brand-700 transition-colors text-sm mb-1">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-400 font-medium">{{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}</p>
                    </div>

                    {{-- Arrow --}}
                    <div class="absolute bottom-5 right-5 w-8 h-8 bg-brand-50 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="sm:hidden mt-6 text-center">
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1.5 text-brand-600 text-sm font-semibold">
                View All Categories
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </section>
    @endif

    {{-- Products Section --}}
    <section class="bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="text-brand-600 text-sm font-semibold uppercase tracking-wider mb-2">Catalog</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                        @if($featuredProducts->count()) Featured Products @else Our Products @endif
                    </h2>
                </div>
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-700 text-sm font-semibold group transition-colors">
                    See All
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            @if($featuredProducts->count())
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($featuredProducts as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                {{-- Show latest products instead --}}
                @php
                    $latestProducts = \App\Models\Product::where('status', 'active')->with('categories', 'variations')->latest()->limit(8)->get();
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($latestProducts as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @endif

            <div class="mt-10 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-600 text-white font-semibold px-8 py-3.5 rounded-2xl hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 text-sm">
                    Browse All {{ \App\Models\Product::where('status','active')->count() }} Products
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="relative bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 rounded-3xl overflow-hidden">
            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-80 h-80 bg-brand-600/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-brand-500/20 rounded-full blur-3xl translate-y-1/4 -translate-x-1/4"></div>

            <div class="relative px-8 md:px-14 py-12 md:py-16 text-center md:text-left md:flex md:items-center md:justify-between gap-8">
                <div class="max-w-lg">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-3 tracking-tight">Need Bulk Orders?</h2>
                    <p class="text-brand-200 text-sm md:text-base leading-relaxed">We offer competitive wholesale pricing for businesses, hotels, restaurants, hospitals, and more. Get in touch for custom pricing and bulk orders.</p>
                </div>
                <div class="mt-6 md:mt-0 shrink-0">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-brand-800 font-bold px-8 py-4 rounded-2xl hover:bg-brand-50 transition-all shadow-2xl text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        Contact Us Today
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Blog Posts --}}
    @if($latestPosts->count())
    <section class="bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="text-center mb-10">
                <p class="text-brand-600 text-sm font-semibold uppercase tracking-wider mb-2">Blog</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Latest News & Tips</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                @foreach($latestPosts as $post)
                    <article class="group bg-white rounded-2xl border border-gray-200/80 overflow-hidden card-hover">
                        <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-50">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 md:p-6">
                            <h3 class="font-bold text-gray-900 group-hover:text-brand-700 transition-colors mb-2 line-clamp-2">{{ $post->title }}</h3>
                            @if($post->excerpt)
                                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
