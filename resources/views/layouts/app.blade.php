<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Unidrug') — Unidrug Lebanon</title>
    <meta name="description" content="@yield('meta_description', 'Unidrug — Premium Cleaning, Hygiene & Pet Supplies in Lebanon')">
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 text-gray-800 font-sans antialiased" x-data="{ mobileMenu: false, searchOpen: false }">

    {{-- Announcement Bar --}}
    <div class="bg-brand-900 text-white/90 text-xs font-medium tracking-wide">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                <span>Serving All of Lebanon</span>
            </div>
            <div class="hidden sm:flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    Wholesale Available
                </span>
                <span class="text-white/40">|</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                    USD Pricing
                </span>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="glass sticky top-0 z-50 border-b border-gray-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-18">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center shrink-0 group">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Unidrug Lebanon" class="h-10 md:h-12 w-auto">
                </a>

                {{-- Desktop Search with Autocomplete --}}
                <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-8"
                      x-data="{
                          query: '{{ request('search') }}',
                          results: [],
                          open: false,
                          debounce: null,
                          search() {
                              clearTimeout(this.debounce);
                              this.debounce = setTimeout(() => {
                                  if (this.query.length < 2) { this.results = []; this.open = false; return; }
                                  fetch('/search/autocomplete?q=' + encodeURIComponent(this.query))
                                      .then(r => r.json())
                                      .then(d => { this.results = d; this.open = d.length > 0; });
                              }, 250);
                          }
                      }"
                      @click.away="open = false">
                    <div class="relative w-full group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-gray-400 group-focus-within:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" x-model="query" @input="search()" @focus="if(results.length) open = true"
                               placeholder="Search for products, categories..."
                               autocomplete="off"
                               class="w-full pl-11 pr-4 py-2.5 bg-gray-100/80 border border-transparent rounded-2xl text-sm placeholder:text-gray-400 focus:bg-white focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 focus:outline-none transition-all">
                        {{-- Autocomplete dropdown --}}
                        <div x-show="open" x-cloak x-transition
                             class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-2xl shadow-xl overflow-hidden z-50">
                            <template x-for="item in results" :key="item.url">
                                <a :href="item.url" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="w-8 h-8 rounded-lg object-cover" alt="">
                                    </template>
                                    <template x-if="!item.image">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                    </template>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="item.name"></p>
                                        <p class="text-xs text-brand-600 font-semibold" x-show="item.price" x-text="'$' + item.price"></p>
                                    </div>
                                </a>
                            </template>
                            <a :href="'/products?search=' + encodeURIComponent(query)" class="block px-4 py-2.5 text-center text-xs font-semibold text-brand-600 bg-gray-50 hover:bg-gray-100 border-t border-gray-100">
                                View all results &rarr;
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center gap-1">
                    @php
                        $currentRoute = request()->route()?->getName();
                    @endphp
                    <a href="{{ route('products.index') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $currentRoute === 'products.index' ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $currentRoute === 'categories.index' ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Categories
                    </a>
                    <a href="{{ route('about') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $currentRoute === 'about' ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        About
                    </a>
                    <a href="{{ route('services') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $currentRoute === 'services' ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Services
                    </a>
                    <a href="{{ route('blog.index') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ str_starts_with($currentRoute ?? '', 'blog') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Blog
                    </a>
                    <a href="{{ route('careers') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $currentRoute === 'careers' ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Careers
                    </a>
                    <a href="{{ route('contact') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $currentRoute === 'contact' ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Contact
                    </a>
                    <div class="w-px h-6 bg-gray-200 mx-2"></div>
                    {{-- Cart Icon --}}
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        @if(app(\App\Services\CartService::class)->count() > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-brand-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center badge-pulse">
                                {{ app(\App\Services\CartService::class)->count() }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Contact Us
                    </a>
                </nav>

                {{-- Mobile buttons --}}
                <div class="flex md:hidden items-center gap-2">
                    <button @click="searchOpen = !searchOpen" class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        @if(app(\App\Services\CartService::class)->count() > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-brand-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                {{ app(\App\Services\CartService::class)->count() }}
                            </span>
                        @endif
                    </a>
                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition">
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Search --}}
        <div x-show="searchOpen" x-cloak x-transition class="md:hidden border-t border-gray-100 px-4 py-3 bg-white">
            <form action="{{ route('products.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search products..."
                       class="w-full px-4 py-2.5 bg-gray-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none border border-transparent focus:border-brand-300">
            </form>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" x-cloak x-transition.origin.top class="md:hidden border-t border-gray-100 bg-white shadow-lg">
            <nav class="px-4 py-4 space-y-1">
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentRoute === 'products.index' ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentRoute === 'categories.index' ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Categories
                </a>
                <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentRoute === 'about' ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                    About
                </a>
                <a href="{{ route('services') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentRoute === 'services' ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/></svg>
                    Services
                </a>
                <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ str_starts_with($currentRoute ?? '', 'blog') ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                    Blog
                </a>
                <a href="{{ route('careers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentRoute === 'careers' ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                    Careers
                </a>
                <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentRoute === 'contact' ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Contact
                </a>
                <div class="pt-2">
                    <a href="{{ route('contact') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Contact Us
                    </a>
                </div>
            </nav>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-3 bg-brand-50 border border-brand-200 text-brand-800 px-5 py-3.5 rounded-2xl text-sm font-medium" role="alert">
                <svg class="w-5 h-5 text-brand-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="relative overflow-hidden">
        {{-- Wave separator --}}
        <div class="text-gray-900">
            <svg viewBox="0 0 1440 60" class="w-full h-12 md:h-16" preserveAspectRatio="none" fill="currentColor">
                <path d="M0,60 L0,20 Q360,0 720,20 Q1080,40 1440,20 L1440,60 Z"/>
            </svg>
        </div>
        <div class="bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
                    {{-- Brand --}}
                    <div class="md:col-span-5">
                        <div class="flex items-center gap-3 mb-5">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Unidrug Lebanon" class="h-10 w-auto brightness-0 invert">
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-sm">Your trusted source for professional & consumer cleaning products, hygiene supplies, and pet care essentials. Proudly serving Lebanon.</p>
                        <div class="flex gap-3 mt-6">
                            @if(!empty($siteSettings['facebook_url'] ?? ''))
                                <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['instagram_url'] ?? ''))
                                <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['tiktok_url'] ?? ''))
                                <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['linkedin_url'] ?? ''))
                                <a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['youtube_url'] ?? ''))
                                <a href="{{ $siteSettings['youtube_url'] }}" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['twitter_url'] ?? ''))
                                <a href="{{ $siteSettings['twitter_url'] }}" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            <a href="mailto:{{ $siteSettings['email'] ?? 'info@unidrug.com' }}" class="w-10 h-10 bg-gray-800 hover:bg-brand-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Links --}}
                    <div class="md:col-span-3">
                        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Shop</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">All Products</a></li>
                            <li><a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Categories</a></li>
                            <li><a href="{{ route('products.index', ['sort' => 'newest']) }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">New Arrivals</a></li>
                            <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Blog</a></li>
                        </ul>
                        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 mt-6">Company</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">About Us</a></li>
                            <li><a href="{{ route('services') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Services</a></li>
                            <li><a href="{{ route('careers') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Careers</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Contact</a></li>
                        </ul>
                    </div>

                    <div class="md:col-span-4">
                        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Get in Touch</h4>
                        <ul class="space-y-3 text-sm text-gray-400">
                            @if(!empty($siteSettings['phone'] ?? ''))
                                <li class="flex items-center gap-3">
                                    <svg class="w-4.5 h-4.5 text-brand-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                    <a href="tel:{{ $siteSettings['phone'] }}" class="hover:text-white transition-colors">{{ $siteSettings['phone'] }}</a>
                                </li>
                            @endif
                            <li class="flex items-center gap-3">
                                <svg class="w-4.5 h-4.5 text-brand-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                                <a href="mailto:{{ $siteSettings['email'] ?? 'info@unidrug.com' }}" class="hover:text-white transition-colors">{{ $siteSettings['email'] ?? 'info@unidrug.com' }}</a>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-4.5 h-4.5 text-brand-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                @if(!empty($siteSettings['google_maps_url'] ?? ''))
                                    <a href="{{ $siteSettings['google_maps_url'] }}" target="_blank" class="hover:text-white transition-colors">
                                        {{ !empty($siteSettings['address'] ?? '') ? $siteSettings['address'] . ', ' : '' }}{{ $siteSettings['city'] ?? 'Lebanon' }}
                                    </a>
                                @else
                                    <span>{{ !empty($siteSettings['address'] ?? '') ? $siteSettings['address'] . ', ' : '' }}{{ $siteSettings['city'] ?? 'Lebanon' }}</span>
                                @endif
                            </li>
                        </ul>
                        {{-- Newsletter Signup --}}
                        <div class="mt-5 p-4 bg-gray-800/50 rounded-2xl border border-gray-800" x-data="{ email: '', submitted: false, loading: false }">
                            <p class="text-sm text-gray-300 font-medium mb-2">Stay Updated</p>
                            <template x-if="!submitted">
                                <form @submit.prevent="loading = true; fetch('/subscribe', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ email }) }).then(r => r.json()).then(d => { submitted = true; loading = false; }).catch(() => { loading = false; })" class="flex gap-2">
                                    <input type="email" x-model="email" required placeholder="Your email"
                                           class="flex-1 px-3 py-2 bg-gray-900 border border-gray-700 rounded-xl text-sm text-white placeholder:text-gray-500 focus:border-brand-500 focus:ring-1 focus:ring-brand-500/20 focus:outline-none">
                                    <button type="submit" :disabled="loading"
                                            class="px-4 py-2 bg-brand-600 text-white text-xs font-semibold rounded-xl hover:bg-brand-700 transition-colors disabled:opacity-50">
                                        <span x-show="!loading">Subscribe</span>
                                        <span x-show="loading" x-cloak>...</span>
                                    </button>
                                </form>
                            </template>
                            <template x-if="submitted">
                                <p class="text-sm text-brand-400 font-medium">&#10003; Subscribed! Thank you.</p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Unidrug Lebanon. All rights reserved.</p>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <a href="#" class="hover:text-gray-300 transition-colors">Privacy</a>
                        <a href="#" class="hover:text-gray-300 transition-colors">Terms</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Floating Button --}}
    @if(!empty($siteSettings['whatsapp'] ?? ''))
    <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text={{ urlencode('Hello! I\'m interested in your products.') }}"
       target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-full flex items-center justify-center shadow-lg shadow-green-500/30 hover:scale-110 transition-all group"
       title="Chat on WhatsApp">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <span class="absolute right-full mr-3 bg-white text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-lg shadow-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Chat with us!</span>
    </a>
    @endif

    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
