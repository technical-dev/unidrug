@extends('layouts.app')

@section('title', 'Careers')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Careers</span>
    </nav>

    {{-- Hero Header --}}
    <div class="text-center mb-16">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-brand-50 to-brand-100 rounded-3xl mb-5">
            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Join Unidrug Sarl Team</h1>
        <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">Looking for a rewarding career? We're excited to hear from you! Explore our current job openings below and apply using the form provided.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        {{-- Left: Job Opening --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- We Are Recruiting --}}
            <div class="bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 rounded-3xl overflow-hidden relative">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand-600/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
                <div class="relative p-8">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-xs font-bold text-brand-200 uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Now Hiring
                    </div>
                    <h2 class="text-xl font-extrabold text-white mb-2">Outdoor Sales Representative</h2>
                    <p class="text-brand-200 text-sm">We have career opportunities for Outdoor Sales Representatives.</p>
                </div>
            </div>

            {{-- Duties & Responsibilities --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                <h3 class="text-lg font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    Duties & Responsibilities
                </h3>
                <ul class="space-y-3">
                    @foreach([
                        'Contact regular and prospective customers to demonstrate products, explain product features, and solicit orders.',
                        'Recommend products to customers, based on customers\' needs and interests.',
                        'Answer customers\' questions about products, prices, availability, product uses, and credit terms.',
                        'Provide customers with product samples and catalogs.',
                        'Identify prospective customers by using business directories, following leads from existing clients, and attending local trade shows and conferences.',
                        'Monitor market conditions, product innovations, and competitors\' products, prices, and sales.',
                        'Perform administrative duties, such as preparing sales budgets and reports, keeping sales records, and filing expense account reports.',
                        'Obtain credit information about prospective customers.',
                        'Prepare sales contracts and order forms.',
                        'Negotiate details of contracts and payments.',
                        'Check stock levels and reorder merchandise as necessary.',
                        'Arrange and direct delivery of products.',
                    ] as $duty)
                    <li class="flex gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $duty }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Right: Application Form --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 sticky top-24">
                <h2 class="text-xl font-extrabold text-gray-900 mb-1">Apply for a Job</h2>
                <p class="text-sm text-gray-400 mb-6">Fill in the form below and we'll get back to you shortly.</p>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('careers.apply') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Full Name <span class="text-red-400">*</span></label>
                        <input type="text" name="full_name" required value="{{ old('full_name') }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('full_name') border-red-300 @enderror"
                               placeholder="John Doe">
                        @error('full_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address <span class="text-red-400">*</span></label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('email') border-red-300 @enderror"
                                   placeholder="john@example.com">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone Number <span class="text-red-400">*</span></label>
                            <input type="tel" name="phone" required value="{{ old('phone') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('phone') border-red-300 @enderror"
                                   placeholder="+961 ...">
                            @error('phone')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Position Applying For <span class="text-red-400">*</span></label>
                        <select name="position" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('position') border-red-300 @enderror">
                            <option value="">— Please choose an option —</option>
                            <option value="Outdoor Sales Representative" {{ old('position') == 'Outdoor Sales Representative' ? 'selected' : '' }}>Outdoor Sales Representative</option>
                        </select>
                        @error('position')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Resume / CV <span class="text-red-400">*</span></label>
                        <div class="relative" x-data="{ fileName: '' }">
                            <input type="file" name="resume" required accept=".pdf,.doc,.docx"
                                   @change="fileName = $event.target.files[0]?.name || ''"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm @error('resume') border-red-300 @enderror">
                                <div class="flex items-center gap-2 text-brand-600 font-semibold shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                    Upload File
                                </div>
                                <span class="text-gray-400 truncate" x-text="fileName || 'PDF, DOC, DOCX (max 5MB)'"></span>
                            </div>
                        </div>
                        @error('resume')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <p class="text-xs text-gray-400 mb-4">
                            By submitting your application, you agree to our Privacy Policy and give consent for us to process your personal data for recruitment purposes only.
                        </p>
                        <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 flex items-center justify-center gap-2">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
