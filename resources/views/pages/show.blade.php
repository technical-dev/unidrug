@extends('layouts.app')

@section('title', $page->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">{{ $page->title }}</span>
    </nav>

    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-8">{{ $page->title }}</h1>

    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-10 prose prose-sm max-w-none prose-headings:font-extrabold prose-headings:text-gray-900 prose-a:text-brand-600 prose-img:rounded-xl text-gray-600">
        {!! $page->content !!}
    </div>
</div>
@endsection
