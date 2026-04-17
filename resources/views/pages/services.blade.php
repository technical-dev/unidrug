@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Services</span>
    </nav>

    {{-- Hero Header --}}
    <div class="text-center mb-16">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-brand-50 to-brand-100 rounded-3xl mb-5">
            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.1-5.1m0 0L11.42 4.97m-5.1 5.1H21M3 3v18"/></svg>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Our Services</h1>
        <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">We go beyond just supplying products — our dedicated team ensures seamless installation, maintenance, and refilling for all your hygiene systems.</p>
    </div>

    {{-- Services Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

        {{-- Installation --}}
        <div class="group relative bg-white rounded-3xl border border-gray-200/80 overflow-hidden hover:shadow-xl hover:shadow-brand-600/5 hover:border-brand-200 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-brand-500 to-brand-600"></div>
            <div class="p-8">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-50 to-brand-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.1-5.1m0 0L11.42 4.97m-5.1 5.1H21M3 3v18"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-xl font-extrabold text-gray-900 mb-3">Installation</h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Our installation team can visit on location to install any dispenser, in line with the design of your space, while prioritizing respecting hygiene and safety measures.
                </p>
                <div class="mt-6 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    On-site service
                </div>
                <div class="mt-2 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Design-aligned placement
                </div>
                <div class="mt-2 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Hygiene & safety first
                </div>
            </div>
        </div>

        {{-- Refilling --}}
        <div class="group relative bg-white rounded-3xl border border-gray-200/80 overflow-hidden hover:shadow-xl hover:shadow-brand-600/5 hover:border-brand-200 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-brand-400 to-brand-500"></div>
            <div class="p-8">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-50 to-brand-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
                <h2 class="text-xl font-extrabold text-gray-900 mb-3">Refilling</h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Ensuring a seamless supply of hygiene products to cater to your customers, our dedicated service team maintains your drip dispensers and air freshener systems, keeping them consistently stocked and operational.
                </p>
                <div class="mt-6 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Seamless supply chain
                </div>
                <div class="mt-2 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Drip dispensers & air fresheners
                </div>
                <div class="mt-2 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Always stocked & operational
                </div>
            </div>
        </div>

        {{-- Maintenance --}}
        <div class="group relative bg-white rounded-3xl border border-gray-200/80 overflow-hidden hover:shadow-xl hover:shadow-brand-600/5 hover:border-brand-200 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-brand-600 to-brand-700"></div>
            <div class="p-8">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-50 to-brand-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.1-5.1m0 0L11.42 4.97m-5.1 5.1H21"/><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/></svg>
                </div>
                <h2 class="text-xl font-extrabold text-gray-900 mb-3">Maintenance</h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    With our maintenance service, we ensure your dispensers are up to industry standards. We promptly replace or repair as required, assuring uninterrupted functionality.
                </p>
                <div class="mt-6 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Industry standard compliance
                </div>
                <div class="mt-2 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Prompt repair & replacement
                </div>
                <div class="mt-2 flex items-center gap-2 text-brand-600 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Uninterrupted functionality
                </div>
            </div>
        </div>
    </div>

    {{-- Service Request Form --}}
    <section class="mb-16" id="request">
        <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden">
            <div class="p-8 md:p-12">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Request a Service</h2>
                </div>
                <p class="text-sm text-gray-400 mb-8 ml-13">Tell us what you need and we'll get back to you shortly.</p>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('services.request') }}" method="POST" class="space-y-5 max-w-2xl">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Name <span class="text-red-400">*</span></label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('name') border-red-300 @enderror"
                                   placeholder="Your name">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email <span class="text-red-400">*</span></label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('email') border-red-300 @enderror"
                                   placeholder="john@example.com">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone <span class="text-gray-300 font-normal">(optional)</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                                   placeholder="+961 ...">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Company <span class="text-gray-300 font-normal">(optional)</span></label>
                            <input type="text" name="company" value="{{ old('company') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                                   placeholder="Company name">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Service Type <span class="text-red-400">*</span></label>
                        <select name="service_type" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('service_type') border-red-300 @enderror">
                            <option value="">— Select a service —</option>
                            <option value="installation" {{ old('service_type') == 'installation' ? 'selected' : '' }}>Installation</option>
                            <option value="refilling" {{ old('service_type') == 'refilling' ? 'selected' : '' }}>Refilling</option>
                            <option value="maintenance" {{ old('service_type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('service_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Message <span class="text-gray-300 font-normal">(optional)</span></label>
                        <textarea name="message" rows="4"
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all resize-none"
                                  placeholder="Any additional details...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="bg-brand-600 text-white py-3 px-8 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 flex items-center gap-2">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        Submit Request
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mb-8">
        <div class="relative bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 rounded-3xl overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-brand-600/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-brand-500/20 rounded-full blur-3xl translate-y-1/4 -translate-x-1/4"></div>
            <div class="relative px-8 md:px-14 py-12 md:py-16 text-center md:text-left md:flex md:items-center md:justify-between gap-8">
                <div class="max-w-lg">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-3 tracking-tight">Need Our Services?</h2>
                    <p class="text-brand-200 text-sm md:text-base leading-relaxed">Whether you need dispenser installation, regular refilling, or maintenance — our team is ready to help. Contact us for a tailored service plan.</p>
                </div>
                <div class="mt-6 md:mt-0 shrink-0 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-white text-brand-800 font-bold px-8 py-4 rounded-2xl hover:bg-brand-50 transition-all shadow-2xl text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        Contact Us Today
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
