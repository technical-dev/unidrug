@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero Section — Light & Editorial, Logo as Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-white via-surface-50 to-white">
        {{-- Soft brand mesh background --}}
        <div class="absolute inset-0 pointer-events-none"
             style="background:
                radial-gradient(ellipse 50% 40% at 15% 20%, rgba(16,185,129,0.10), transparent 60%),
                radial-gradient(ellipse 45% 35% at 85% 25%, rgba(20,184,166,0.10), transparent 60%),
                radial-gradient(ellipse 60% 50% at 50% 100%, rgba(110,231,183,0.12), transparent 60%);"></div>

        {{-- Subtle dot grid --}}
        <div class="absolute inset-0 opacity-[0.4] pointer-events-none"
             style="background-image: radial-gradient(circle at 1px 1px, rgba(6,95,70,0.15) 1px, transparent 0); background-size: 28px 28px; mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, #000 30%, transparent 80%);"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 lg:py-28 text-center">

            {{-- Top eyebrow --}}
            <div class="inline-flex items-center gap-3 mb-10 fade-up">
                <span class="h-px w-10 bg-brand-400"></span>
                <span class="inline-flex items-center gap-2 text-brand-700 text-[11px] font-bold tracking-[0.28em] uppercase">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Beirut · Lebanon · Est. 1998
                </span>
                <span class="h-px w-10 bg-brand-400"></span>
            </div>

            {{-- LOGO — natural, no plate, just space --}}
            <div class="relative inline-block fade-up delay-1 mb-12">
                {{-- Subtle orbital rings --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] aspect-square rounded-full border border-brand-200/60 pointer-events-none"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[180%] aspect-square rounded-full border border-brand-200/35 pointer-events-none"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[230%] aspect-square rounded-full border border-brand-200/20 pointer-events-none"></div>

                {{-- Drifting dots on the orbits --}}
                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] aspect-square pointer-events-none animate-[spin_28s_linear_infinite]">
                    <span class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-brand-500 shadow-[0_0_10px_rgba(16,185,129,0.6)]"></span>
                </span>
                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[180%] aspect-square pointer-events-none animate-[spin_42s_linear_infinite_reverse]">
                    <span class="absolute top-1/2 -right-1 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-brand-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></span>
                </span>

                {{-- Soft glow under logo --}}
                <div class="absolute inset-0 -m-12 pointer-events-none"
                     style="background:radial-gradient(circle, rgba(16,185,129,0.18) 0%, transparent 65%);"></div>

                {{-- The logo itself — clean on light background --}}
                <img src="{{ asset('images/logo.jpeg') }}" alt="Unidrug Lebanon"
                     class="relative h-32 md:h-44 lg:h-52 w-auto object-contain drop-shadow-[0_18px_40px_rgba(6,95,70,0.18)] transition-transform duration-700 hover:scale-[1.03]">
            </div>

            {{-- Wordmark + tagline --}}
            <p class="text-[11px] font-bold tracking-[0.5em] text-brand-700/70 uppercase mb-4 fade-up delay-2">Unidrug Lebanon</p>

            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-[1.05] tracking-[-0.035em] mb-5 fade-up delay-2">
                Professional <span class="bg-gradient-to-r from-brand-600 via-brand-500 to-brand-700 bg-clip-text text-transparent">Cleaning &amp; Hygiene</span><br class="hidden md:block">
                Solutions for Lebanon.
            </h1>

            <p class="text-base md:text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed mb-10 fade-up delay-3">
                Industrial-grade cleaning, hygiene essentials, and pet care — supplied with care, delivered with precision since 1998.
            </p>

            {{-- CTAs --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center fade-up delay-4">
                <a href="{{ route('products.index') }}" class="btn-primary group relative inline-flex items-center justify-center gap-2 font-bold px-8 py-4 rounded-full text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Browse Catalog
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-800 font-semibold px-8 py-4 rounded-full ring-1 ring-gray-200 hover:ring-brand-300 hover:bg-brand-50 hover:text-brand-700 transition-all text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Talk to Sales
                </a>
            </div>

            {{-- Stats strip --}}
            <div class="grid grid-cols-3 gap-6 md:gap-10 mt-16 pt-10 border-t border-gray-200/70 max-w-2xl mx-auto fade-up delay-4">
                <div>
                    <p class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">{{ \App\Models\Product::where('status','active')->count() }}<span class="text-brand-500">+</span></p>
                    <p class="text-[11px] md:text-xs text-gray-500 mt-1.5 tracking-[0.15em] uppercase">Products</p>
                </div>
                <div class="border-x border-gray-200/70">
                    <p class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">{{ \App\Models\Category::where('is_active', true)->count() }}</p>
                    <p class="text-[11px] md:text-xs text-gray-500 mt-1.5 tracking-[0.15em] uppercase">Categories</p>
                </div>
                <div>
                    <p class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">B2B</p>
                    <p class="text-[11px] md:text-xs text-gray-500 mt-1.5 tracking-[0.15em] uppercase">Wholesale</p>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-5 md:gap-8">
                <div class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-brand-50 to-brand-100/50 rounded-2xl flex items-center justify-center shrink-0 ring-1 ring-brand-100 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Fast Delivery</p>
                        <p class="text-xs text-gray-500">Across Lebanon</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl flex items-center justify-center shrink-0 ring-1 ring-blue-100 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Certified Quality</p>
                        <p class="text-xs text-gray-500">Trusted Brands</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-2xl flex items-center justify-center shrink-0 ring-1 ring-amber-100 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Bulk Discounts</p>
                        <p class="text-xs text-gray-500">Wholesale Pricing</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-2xl flex items-center justify-center shrink-0 ring-1 ring-purple-100 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Expert Support</p>
                        <p class="text-xs text-gray-500">Talk to a Human</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bundles / Sales Section --}}
    @if($bundles->count())
    <section class="relative overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-red-50/40 to-amber-50/50"></div>
        <div class="absolute inset-0 opacity-[0.3] pointer-events-none"
             style="background-image: radial-gradient(circle at 1px 1px, rgba(234,88,12,0.12) 1px, transparent 0); background-size: 24px 24px;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <div class="inline-flex items-center gap-2 mb-3">
                        <span class="h-px w-8 bg-orange-500"></span>
                        <p class="text-orange-600 text-xs font-bold uppercase tracking-[0.2em]">Special Offers</p>
                    </div>
                    <h2 class="font-display text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                        Bundle Deals <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">&amp; Save</span>
                    </h2>
                    <p class="text-gray-500 mt-3 max-w-md">Grab curated bundles at special prices — save more when you buy together.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
                @foreach($bundles as $bundle)
                    <div class="group relative bg-white rounded-3xl border border-gray-200/70 overflow-hidden card-hover flex flex-col">
                        {{-- Sale badge --}}
                        @if($bundle->savings_percent > 0)
                            <div class="absolute top-4 left-4 z-10">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-extrabold uppercase tracking-wider rounded-full shadow-lg shadow-red-500/30">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/></svg>
                                    Save {{ $bundle->savings_percent }}%
                                </span>
                            </div>
                        @endif

                        {{-- Bundle image or product thumbnails --}}
                        <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-orange-50 to-amber-50 relative">
                            @if($bundle->image)
                                <img src="{{ $bundle->image }}" alt="{{ $bundle->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                {{-- Show product thumbnails in a grid --}}
                                <div class="w-full h-full flex items-center justify-center p-4">
                                    <div class="flex flex-wrap justify-center gap-2 items-center">
                                        @foreach($bundle->products->take(4) as $bp)
                                            <div class="w-16 h-16 rounded-xl bg-white shadow-sm border border-gray-100 p-1 overflow-hidden">
                                                @if($bp->featured_image)
                                                    <img src="{{ $bp->featured_image }}" alt="{{ $bp->name }}" class="w-full h-full object-contain" loading="lazy">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($bundle->products->count() > 4)
                                            <div class="w-16 h-16 rounded-xl bg-white/80 shadow-sm border border-gray-100 flex items-center justify-center">
                                                <span class="text-xs font-bold text-gray-500">+{{ $bundle->products->count() - 4 }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Hover arrow --}}
                            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 z-10">
                                <div class="w-9 h-9 bg-orange-500 text-white rounded-xl shadow-lg shadow-orange-500/30 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-5 md:p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    {{ $bundle->products->count() }} products
                                </span>
                                @if($bundle->ends_at)
                                    <span class="text-[10px] font-semibold text-red-500">
                                        Ends {{ $bundle->ends_at->format('M d') }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-display font-bold text-gray-900 text-base leading-snug group-hover:text-orange-600 transition-colors mb-2 tracking-tight">
                                {{ $bundle->name }}
                            </h3>

                            @if($bundle->description)
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $bundle->description }}</p>
                            @endif

                            {{-- Product list preview --}}
                            <div class="mb-4 flex-1">
                                <div class="space-y-1.5">
                                    @foreach($bundle->products->take(3) as $bp)
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <svg class="w-3 h-3 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <span class="truncate">{{ $bp->name }}</span>
                                            @if($bp->pivot->quantity > 1)
                                                <span class="text-gray-400">x{{ $bp->pivot->quantity }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($bundle->products->count() > 3)
                                        <p class="text-[10px] text-gray-400 font-medium pl-5">+{{ $bundle->products->count() - 3 }} more items</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="flex items-end justify-between pt-4 border-t border-gray-100">
                                <div>
                                    @if($bundle->original_price > $bundle->bundle_price)
                                        <p class="text-xs text-gray-400 line-through">${{ number_format($bundle->original_price, 2) }}</p>
                                    @endif
                                    <p class="font-display text-2xl font-extrabold text-gray-900 tracking-tight">${{ number_format($bundle->bundle_price, 2) }}</p>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    @foreach($bundle->products as $bp)
                                        <input type="hidden" name="bundle_products[]" value="{{ $bp->id }}">
                                    @endforeach
                                    <input type="hidden" name="bundle_id" value="{{ $bundle->id }}">
                                    <button type="button" onclick="window.location='{{ route("products.index") }}'" class="inline-flex items-center gap-1.5 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold px-5 py-2.5 rounded-xl hover:from-orange-600 hover:to-red-600 transition-all shadow-lg shadow-orange-500/25 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                                        View Deal
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Categories Section --}}
    @if($topCategories->count())
    <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
        <div class="flex items-end justify-between mb-12">
            <div>
                <div class="inline-flex items-center gap-2 mb-3">
                    <span class="h-px w-8 bg-brand-500"></span>
                    <p class="text-brand-600 text-xs font-bold uppercase tracking-[0.2em]">Browse</p>
                </div>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Shop by Category</h2>
                <p class="text-gray-500 mt-3 max-w-md">Curated selections built around how professionals actually work.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="hidden sm:inline-flex items-center gap-2 text-brand-700 hover:text-brand-800 text-sm font-semibold group transition-colors">
                View All Categories
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-600 group-hover:text-white text-brand-700 transition-all">
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </span>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @foreach($topCategories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                   class="group relative bg-white rounded-3xl border border-gray-200/70 p-6 hover:border-brand-300/60 card-hover overflow-hidden">
                    {{-- Background mesh on hover --}}
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                         style="background:radial-gradient(ellipse 100% 80% at 100% 0%, rgba(16,185,129,0.10), transparent 60%), radial-gradient(ellipse 80% 60% at 0% 100%, rgba(20,184,166,0.06), transparent 70%);"></div>

                    <div class="relative">
                        @if($category->image)
                            <div class="w-16 h-16 mb-5 rounded-2xl overflow-hidden bg-gradient-to-br from-surface-50 to-white p-1.5 ring-1 ring-gray-100 cat-icon">
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-16 h-16 mb-5 bg-gradient-to-br from-brand-100 to-brand-50 rounded-2xl flex items-center justify-center cat-icon ring-1 ring-brand-100">
                                <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                            </div>
                        @endif
                        <h3 class="font-display font-bold text-gray-900 group-hover:text-brand-700 transition-colors text-[15px] mb-1.5 tracking-tight">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-400 font-medium flex items-center gap-1.5">
                            <span class="inline-block w-1 h-1 rounded-full bg-brand-400"></span>
                            {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                        </p>
                    </div>

                    {{-- Arrow --}}
                    <div class="absolute bottom-5 right-5 w-9 h-9 bg-brand-600 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-3 -translate-y-1 group-hover:translate-x-0 group-hover:translate-y-0 transition-all duration-300 shadow-lg shadow-brand-600/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
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
    <section class="relative bg-gradient-to-b from-white via-surface-50 to-white border-y border-gray-100 overflow-hidden">
        {{-- Decorative blob --}}
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-brand-100/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-brand-100/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 mb-3">
                        <span class="h-px w-8 bg-brand-500"></span>
                        <p class="text-brand-600 text-xs font-bold uppercase tracking-[0.2em]">Catalog</p>
                    </div>
                    <h2 class="font-display text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                        @if($featuredProducts->count()) Featured Products @else Our Products @endif
                    </h2>
                    <p class="text-gray-500 mt-3 max-w-md">Hand-picked essentials our customers keep coming back for.</p>
                </div>
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-2 text-brand-700 hover:text-brand-800 text-sm font-semibold group transition-colors">
                    See All Products
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-600 group-hover:text-white text-brand-700 transition-all">
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
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

            <div class="mt-12 text-center">
                <a href="{{ route('products.index') }}" class="btn-primary inline-flex items-center gap-2 font-semibold px-8 py-4 rounded-full text-sm">
                    Browse All {{ \App\Models\Product::where('status','active')->count() }} Products
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-24">
        <div class="relative bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 rounded-[2rem] overflow-hidden grain">
            {{-- Decorative orbs --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 float-slow"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl translate-y-1/4 -translate-x-1/4 float-medium"></div>
            {{-- Grid pattern --}}
            <div class="absolute inset-0 opacity-[0.06]" style="background-image: linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px); background-size: 40px 40px;"></div>

            <div class="relative px-8 md:px-16 py-14 md:py-20 text-center md:text-left md:flex md:items-center md:justify-between gap-10">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full px-3.5 py-1 mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-300 badge-pulse"></span>
                        <span class="text-white/80 text-[11px] font-semibold tracking-[0.18em] uppercase">For Businesses</span>
                    </div>
                    <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight">Need bulk orders?<br><span class="text-brand-300">We've got you covered.</span></h2>
                    <p class="text-brand-100/80 text-base md:text-lg leading-relaxed">Wholesale pricing for hotels, restaurants, hospitals, schools, and offices. Custom quotes within 24 hours.</p>
                </div>
                <div class="mt-8 md:mt-0 shrink-0 flex flex-col items-center md:items-end gap-3">
                    <a href="{{ route('contact') }}" class="group inline-flex items-center gap-2 bg-white text-brand-900 font-bold px-8 py-4 rounded-full hover:bg-brand-50 transition-all shadow-2xl text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        Get a Custom Quote
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <p class="text-xs text-brand-200/70 tracking-wide">Or call us — response in under an hour.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Blog Posts --}}
    @if($latestPosts->count())
    <section class="bg-surface-100/60 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2 mb-3">
                    <span class="h-px w-8 bg-brand-500"></span>
                    <p class="text-brand-600 text-xs font-bold uppercase tracking-[0.2em]">Blog</p>
                    <span class="h-px w-8 bg-brand-500"></span>
                </div>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Latest News &amp; Tips</h2>
                <p class="text-gray-500 mt-3 max-w-md mx-auto">Insights, guides, and updates from our team to yours.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                @foreach($latestPosts as $post)
                    <article class="group bg-white rounded-3xl border border-gray-200/70 overflow-hidden card-hover">
                        <div class="aspect-[16/10] overflow-hidden bg-gray-100 relative">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-50 to-surface-100">
                                    <svg class="w-14 h-14 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                </div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <div class="p-6 md:p-7">
                            <h3 class="font-display font-bold text-lg text-gray-900 group-hover:text-brand-700 transition-colors mb-2.5 line-clamp-2 leading-snug tracking-tight">{{ $post->title }}</h3>
                            @if($post->excerpt)
                                <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed">{{ $post->excerpt }}</p>
                            @endif
                            <div class="mt-4 inline-flex items-center gap-1.5 text-brand-600 text-xs font-bold tracking-wide uppercase">
                                Read more
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
