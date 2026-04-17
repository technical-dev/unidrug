@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <a href="{{ route('categories.index') }}" class="hover:text-brand-600 transition-colors">Categories</a>
        @if($category->parent)
            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <a href="{{ route('categories.show', $category->parent->slug) }}" class="hover:text-brand-600 transition-colors">{{ $category->parent->name }}</a>
        @endif
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">{{ $category->name }}</span>
    </nav>

    {{-- Category Header --}}
    <div class="mb-8 pb-8 border-b border-gray-100">
        <div class="flex items-start gap-5">
            @if($category->image)
                <div class="w-16 h-16 shrink-0 rounded-2xl overflow-hidden bg-white border border-gray-200/80 p-2">
                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                </div>
            @else
                <div class="w-16 h-16 shrink-0 bg-gradient-to-br from-brand-50 to-brand-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
            @endif
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="mt-2 text-gray-500 text-sm md:text-base max-w-2xl">{{ $category->description }}</p>
                @endif
                <p class="mt-1 text-sm text-gray-400">{{ $products->total() }} {{ Str::plural('product', $products->total()) }}</p>
            </div>
        </div>
    </div>

    {{-- Subcategories --}}
    @if($childCategories->count())
        <div class="mb-8">
            <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Subcategories</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($childCategories as $child)
                    <a href="{{ route('categories.show', $child->slug) }}"
                       class="inline-flex items-center gap-1.5 bg-white border border-gray-200 rounded-full px-4 py-2 text-sm font-semibold text-gray-700 hover:border-brand-300 hover:text-brand-600 hover:bg-brand-50/50 transition-all">
                        {{ $child->name }}
                        <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $child->products_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Products --}}
    @if($products->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-200/80 p-16 text-center">
            <div class="w-20 h-20 mx-auto mb-5 bg-gray-100 rounded-3xl flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mb-2">No products in this category</h3>
            <p class="text-gray-400 text-sm max-w-sm mx-auto">Check back later or browse other categories.</p>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 mt-6 text-brand-600 text-sm font-semibold hover:text-brand-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                Browse all categories
            </a>
        </div>
    @endif
</div>
@endsection
