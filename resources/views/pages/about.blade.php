@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">About Us</span>
    </nav>

    {{-- Hero Header --}}
    <div class="text-center mb-16">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-brand-50 to-brand-100 rounded-3xl mb-5">
            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">About Unidrug</h1>
        <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">A leading provider of essential hygiene products, proudly serving Lebanon since 1971.</p>
    </div>

    {{-- Our Story --}}
    <section class="mb-16">
        <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden">
            <div class="p-8 md:p-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Our Story</h2>
                </div>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                        Founded in 1971, Unidrug was originally a reseller of drugs and chemicals in Lebanon, before expanding to include chemical cleaning products, its first venture into hygiene items. Over time, drug products were abandoned and the line was expanded to include a complete line of hygiene products, following a change of management in 1980.
                    </p>
                    <p class="text-gray-600 leading-relaxed text-base md:text-lg mt-4">
                        The company has grown to become the manufacturers and distributors for a wide range of paper tissue products, cleaning products and other hygiene products for professional, industrial, and consumer use.
                    </p>
                </div>

                {{-- Timeline --}}
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="relative bg-gradient-to-br from-brand-50 to-white rounded-2xl p-6 border border-brand-100/50">
                        <span class="text-4xl font-black text-brand-600/20">1971</span>
                        <h3 class="text-sm font-bold text-gray-900 mt-2">Founded</h3>
                        <p class="text-xs text-gray-500 mt-1">Started as a reseller of drugs and chemicals in Lebanon</p>
                    </div>
                    <div class="relative bg-gradient-to-br from-brand-50 to-white rounded-2xl p-6 border border-brand-100/50">
                        <span class="text-4xl font-black text-brand-600/20">1980</span>
                        <h3 class="text-sm font-bold text-gray-900 mt-2">New Direction</h3>
                        <p class="text-xs text-gray-500 mt-1">Change of management led to a full pivot into hygiene products</p>
                    </div>
                    <div class="relative bg-gradient-to-br from-brand-50 to-white rounded-2xl p-6 border border-brand-100/50">
                        <span class="text-4xl font-black text-brand-600/20">Today</span>
                        <h3 class="text-sm font-bold text-gray-900 mt-2">Industry Leader</h3>
                        <p class="text-xs text-gray-500 mt-1">Manufacturer & distributor of professional, industrial, and consumer hygiene products</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission --}}
    <section class="mb-16">
        <div class="bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 w-80 h-80 bg-brand-600/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-brand-500/20 rounded-full blur-3xl translate-y-1/4 -translate-x-1/4"></div>
            <div class="relative p-8 md:p-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-brand-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white">Our Mission</h2>
                </div>
                <p class="text-brand-100 text-base md:text-lg leading-relaxed max-w-3xl">
                    We will continue to partner with our customers by consistently delivering quality hygiene products and excellent service through our dedicated and empowered team.
                </p>
            </div>
        </div>
    </section>

    {{-- Core Values --}}
    <section class="mb-16">
        <div class="text-center mb-10">
            <p class="text-brand-600 text-sm font-semibold uppercase tracking-wider mb-2">What Drives Us</p>
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Our Core Values</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Respect --}}
            <div class="group bg-white rounded-2xl border border-gray-200/80 p-6 hover:shadow-lg hover:shadow-brand-600/5 hover:border-brand-200 transition-all">
                <div class="w-12 h-12 bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Respect</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Our relationships are based on trust, integrity and respect.</p>
            </div>

            {{-- Clarity --}}
            <div class="group bg-white rounded-2xl border border-gray-200/80 p-6 hover:shadow-lg hover:shadow-brand-600/5 hover:border-brand-200 transition-all">
                <div class="w-12 h-12 bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Clarity & Transparency</h3>
                <p class="text-sm text-gray-500 leading-relaxed">We use clear communication to achieve our objectives.</p>
            </div>

            {{-- Adaptability --}}
            <div class="group bg-white rounded-2xl border border-gray-200/80 p-6 hover:shadow-lg hover:shadow-brand-600/5 hover:border-brand-200 transition-all">
                <div class="w-12 h-12 bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Adaptability</h3>
                <p class="text-sm text-gray-500 leading-relaxed">We demonstrate flexibility to fulfill the needs of clients and suppliers.</p>
            </div>

            {{-- Commitment --}}
            <div class="group bg-white rounded-2xl border border-gray-200/80 p-6 hover:shadow-lg hover:shadow-brand-600/5 hover:border-brand-200 transition-all">
                <div class="w-12 h-12 bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Commitment & Accountability</h3>
                <p class="text-sm text-gray-500 leading-relaxed">We deliver on our promises.</p>
            </div>

            {{-- Results --}}
            <div class="group bg-white rounded-2xl border border-gray-200/80 p-6 hover:shadow-lg hover:shadow-brand-600/5 hover:border-brand-200 transition-all">
                <div class="w-12 h-12 bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Results</h3>
                <p class="text-sm text-gray-500 leading-relaxed">We are committed to achieving objectives in customer service, quality and financial results.</p>
            </div>

            {{-- CTA Card --}}
            <div class="bg-gradient-to-br from-brand-50 to-brand-100/50 rounded-2xl border border-brand-200/50 p-6 flex flex-col justify-center items-center text-center">
                <div class="w-12 h-12 bg-brand-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-brand-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Work With Us</h3>
                <p class="text-sm text-gray-500 mb-4">Let's discuss how Unidrug can serve your business.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/25 text-sm">
                    Contact Us
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
