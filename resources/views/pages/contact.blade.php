@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Contact Us</span>
    </nav>

    {{-- Header --}}
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-brand-50 to-brand-100 rounded-3xl mb-5">
            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Get in Touch</h1>
        <p class="mt-3 text-gray-500 max-w-lg mx-auto">Have a question about our products or need a wholesale quote? We'd love to hear from you.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        {{-- Contact Form --}}
        <div class="md:col-span-3 bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-1">Send a message</h2>
            <p class="text-sm text-gray-400 mb-6">We'll get back to you within 24 hours.</p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Name</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                               placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                               placeholder="john@example.com">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone <span class="text-gray-300 font-normal">(optional)</span></label>
                    <input type="tel" name="phone"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                           placeholder="+961 ...">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Message</label>
                    <textarea name="message" rows="5" required
                              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all resize-none"
                              placeholder="Tell us about your inquiry..."></textarea>
                </div>
                <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 flex items-center justify-center gap-2">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    Send Message
                </button>
            </form>
        </div>

        {{-- Contact Info --}}
        <div class="md:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-gradient-to-br from-brand-50 to-brand-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">Email</h3>
                        <a href="mailto:info@unidrug.com" class="text-brand-600 hover:text-brand-700 text-sm font-medium transition-colors">info@unidrug.com</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200/80 p-5">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-gradient-to-br from-brand-50 to-brand-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">Location</h3>
                        <p class="text-sm text-gray-500">Lebanon</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200/80 p-5">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-gradient-to-br from-brand-50 to-brand-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">Response Time</h3>
                        <p class="text-sm text-gray-500">Within 24 hours</p>
                    </div>
                </div>
            </div>

            {{-- Wholesale CTA --}}
            <div class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-2xl p-6 text-white">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-brand-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    <h3 class="font-bold text-sm">Wholesale Orders</h3>
                </div>
                <p class="text-sm text-brand-100 leading-relaxed">Looking for bulk pricing? We offer competitive rates for hospitals, pharmacies, and clinics across Lebanon.</p>
                <p class="mt-3 text-xs text-brand-200 font-medium">Minimum order: Contact us for details</p>
            </div>
        </div>
    </div>
</div>
@endsection
