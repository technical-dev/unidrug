@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Products</span>
    </nav>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
            @if(request('search'))
                Results for "{{ request('search') }}"
            @elseif(request('category'))
                {{ \App\Models\Category::where('slug', request('category'))->value('name') ?? 'Products' }}
            @else
                All Products
            @endif
        </h1>
        <p class="mt-2 text-gray-500">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <aside class="lg:w-72 shrink-0" x-data="{ filtersOpen: false }">
            {{-- Mobile filter toggle --}}
            <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full flex items-center justify-between bg-white border border-gray-200 rounded-2xl px-5 py-3 text-sm font-semibold text-gray-700 mb-4">
                <span class="flex items-center gap-2">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                    Filters & Sort
                </span>
                <svg class="w-5 h-5 text-gray-400 transition-transform" :class="filtersOpen && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </button>

            <div :class="filtersOpen ? '' : 'hidden lg:block'">
                <form method="GET" action="{{ route('products.index') }}" id="filter-form" class="bg-white rounded-2xl border border-gray-200/80 p-6 space-y-6">
                    {{-- Search --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Product name..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                        <select name="category" onchange="document.getElementById('filter-form').submit()"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all appearance-none">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Category::whereNull('parent_id')->where('is_active', true)->withCount('products')->orderBy('name')->get() as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->products_count }})
                                </option>
                                @foreach($cat->children()->where('is_active', true)->withCount('products')->orderBy('name')->get() as $child)
                                    <option value="{{ $child->slug }}" {{ request('category') === $child->slug ? 'selected' : '' }}>
                                        &nbsp;&nbsp;&nbsp;{{ $child->name }} ({{ $child->products_count }})
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sort By</label>
                        <select name="sort" onchange="document.getElementById('filter-form').submit()"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all appearance-none">
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A → Z</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-brand-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
                            Apply
                        </button>
                        @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('products.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1 min-w-0">
            @if($products->count())
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-5">
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
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">No products found</h3>
                    <p class="text-gray-400 text-sm max-w-sm mx-auto">Try adjusting your search or filter criteria to find what you're looking for.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-6 text-brand-600 text-sm font-semibold hover:text-brand-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Clear all filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
