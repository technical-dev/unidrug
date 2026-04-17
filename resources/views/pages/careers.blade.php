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
        {{-- Left: Job Openings --}}
        <div class="lg:col-span-2 space-y-6">
            @forelse($jobOpenings as $job)
                {{-- Job Card --}}
                <div class="bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 rounded-3xl overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-brand-600/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
                    <div class="relative p-8">
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-xs font-bold text-brand-200 uppercase tracking-wider mb-4">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            Now Hiring
                        </div>
                        <h2 class="text-xl font-extrabold text-white mb-2">{{ $job->title }}</h2>
                        <div class="flex flex-wrap gap-3 mt-3">
                            @if($job->location)
                                <span class="inline-flex items-center gap-1.5 text-brand-200 text-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    {{ $job->location }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 text-brand-200 text-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ ucfirst(str_replace('-', ' ', $job->type)) }}
                            </span>
                        </div>
                        @if($job->description)
                            <p class="text-brand-200 text-sm mt-3">{{ $job->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Responsibilities --}}
                @if(!empty($job->responsibilities))
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                        <h3 class="text-lg font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            Duties & Responsibilities
                        </h3>
                        <ul class="space-y-3">
                            @foreach($job->responsibilities as $duty)
                                <li class="flex gap-3 text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $duty }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Requirements --}}
                @if(!empty($job->requirements))
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8">
                        <h3 class="text-lg font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"/></svg>
                            Requirements
                        </h3>
                        <ul class="space-y-3">
                            @foreach($job->requirements as $req)
                                <li class="flex gap-3 text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $req }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @empty
                <div class="bg-white rounded-2xl border border-gray-200/80 p-8 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                    <p class="font-semibold text-gray-500">No open positions at this time</p>
                    <p class="text-sm text-gray-400 mt-1">Check back later or submit a general application below.</p>
                </div>
            @endforelse
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
                            @foreach($jobOpenings as $job)
                                <option value="{{ $job->title }}" {{ old('position') == $job->title ? 'selected' : '' }}>{{ $job->title }}</option>
                            @endforeach
                            <option value="General Application" {{ old('position') == 'General Application' ? 'selected' : '' }}>General Application</option>
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
