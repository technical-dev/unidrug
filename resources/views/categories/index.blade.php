@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Categories</span>
    </nav>

    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Product Categories</h1>
        <p class="mt-2 text-gray-500">Browse our {{ $categories->count() }} product categories</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}"
               class="group bg-white rounded-2xl border border-gray-200/80 p-6 text-center hover:shadow-xl hover:shadow-brand-600/5 hover:border-brand-200 transition-all duration-300 relative overflow-hidden">
                {{-- Decorative corner --}}
                <div class="absolute -top-6 -right-6 w-16 h-16 bg-brand-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>

                @if($category->image)
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}"
                             class="w-full h-full object-contain rounded-xl group-hover:scale-110 transition-transform duration-300">
                    </div>
                @else
                    <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-brand-50 to-brand-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-9 h-9 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                        </svg>
                    </div>
                @endif
                <h3 class="font-bold text-gray-900 group-hover:text-brand-600 transition-colors text-sm md:text-base">{{ $category->name }}</h3>
                <p class="text-xs text-gray-400 mt-1.5 font-medium">{{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}</p>
                @if($category->children_count > 0)
                    <p class="text-xs text-brand-400 mt-0.5 font-medium">{{ $category->children_count }} subcategories</p>
                @endif
                {{-- Arrow --}}
                <div class="mt-3 opacity-0 group-hover:opacity-100 transition-all transform translate-y-1 group-hover:translate-y-0">
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-600">
                        Browse
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
