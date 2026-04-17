@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        <span class="text-gray-900 font-medium">Products</span>
    </nav>

    {{-- Header + Search Row --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">
                @if(request('search'))
                    Results for "{{ request('search') }}"
                @elseif(request('category'))
                    {{ \App\Models\Category::where('slug', request('category'))->value('name') ?? 'Products' }}
                @else
                    All Products
                @endif
            </h1>
            <p class="text-sm text-gray-400 mt-1">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search --}}
            <form method="GET" action="{{ route('products.index') }}" class="relative">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search products..."
                       class="w-56 md:w-64 pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all placeholder:text-gray-400">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>

            {{-- Sort --}}
            <form method="GET" action="{{ route('products.index') }}" id="sort-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <select name="sort" onchange="document.getElementById('sort-form').submit()"
                        class="px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all appearance-none cursor-pointer text-gray-600">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>A → Z</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price ↑</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price ↓</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Category Filter --}}
    @php
        $parentCategories = \App\Models\Category::whereNull('parent_id')
            ->where('is_active', true)
            ->where('slug', '!=', 'uncategorized')
            ->withCount('products')
            ->with(['children' => fn($q) => $q->where('is_active', true)->withCount('products')->orderBy('name')])
            ->orderBy('name')
            ->get()
            ->filter(fn($c) => $c->products_count > 0);

        // Determine if the current category is a parent or a subcategory
        $currentSlug = request('category');
        $activeParent = null;
        $activeChild = null;
        if ($currentSlug) {
            $activeParent = $parentCategories->firstWhere('slug', $currentSlug);
            if (!$activeParent) {
                // It might be a subcategory slug
                foreach ($parentCategories as $pc) {
                    $found = $pc->children->firstWhere('slug', $currentSlug);
                    if ($found) {
                        $activeChild = $found;
                        $activeParent = $pc;
                        break;
                    }
                }
            }
        }
    @endphp
    <div class="mb-8">
        {{-- Parent Categories --}}
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('products.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold transition-all whitespace-nowrap
                      {{ !$currentSlug ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                All
            </a>

            @foreach($parentCategories as $cat)
                @php
                    $isActiveParent = $activeParent && $activeParent->id === $cat->id;
                @endphp
                <a href="{{ route('products.index', array_filter(['category' => $cat->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all whitespace-nowrap
                          {{ $isActiveParent ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'bg-white text-gray-600 border border-gray-200 hover:border-brand-300 hover:text-brand-600 hover:bg-brand-50' }}">
                    {{ $cat->name }}
                    <span class="{{ $isActiveParent ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }} text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                </a>
            @endforeach
        </div>

        {{-- Subcategories (shown when a parent with children is selected) --}}
        @if($activeParent && $activeParent->children->filter(fn($c) => $c->products_count > 0)->count())
            <div class="flex flex-wrap items-center gap-2 mt-3 pl-2 border-l-2 border-brand-200">
                <a href="{{ route('products.index', array_filter(['category' => $activeParent->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition-all whitespace-nowrap
                          {{ !$activeChild ? 'bg-brand-100 text-brand-700 ring-1 ring-brand-300' : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-brand-300 hover:text-brand-600 hover:bg-brand-50' }}">
                    All {{ $activeParent->name }}
                </a>

                @foreach($activeParent->children->filter(fn($c) => $c->products_count > 0) as $sub)
                    <a href="{{ route('products.index', array_filter(['category' => $sub->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium transition-all whitespace-nowrap
                              {{ $activeChild && $activeChild->id === $sub->id ? 'bg-brand-100 text-brand-700 ring-1 ring-brand-300' : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-brand-300 hover:text-brand-600 hover:bg-brand-50' }}">
                        {{ $sub->name }}
                        <span class="{{ $activeChild && $activeChild->id === $sub->id ? 'bg-brand-200 text-brand-700' : 'bg-gray-100 text-gray-400' }} text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $sub->products_count }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Active Filters --}}
    @if(request('search') || request('category'))
        <div class="flex items-center gap-2 mb-6 flex-wrap">
            <span class="text-xs text-gray-400 font-medium">Active:</span>
            @if(request('search'))
                <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}"
                   class="inline-flex items-center gap-1 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-semibold hover:bg-brand-100 transition-colors">
                    "{{ request('search') }}"
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
            @if(request('category'))
                <a href="{{ route('products.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}"
                   class="inline-flex items-center gap-1 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-semibold hover:bg-brand-100 transition-colors">
                    {{ \App\Models\Category::where('slug', request('category'))->value('name') }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
            <a href="{{ route('products.index') }}" class="text-xs text-gray-400 hover:text-red-500 font-medium ml-1 transition-colors">Clear all</a>
        </div>
    @endif

    {{-- Products Grid --}}
    @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @foreach($products as $product)
                @include('partials.product-card', [
                    'product' => $product,
                    'groupMembers' => ($product->group_slug && isset($groupedProducts[$product->group_slug]))
                        ? $groupedProducts[$product->group_slug]
                        : [],
                ])
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
            <p class="text-gray-400 text-sm max-w-sm mx-auto">Try adjusting your search or filter criteria.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-6 text-brand-600 text-sm font-semibold hover:text-brand-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                Clear all filters
            </a>
        </div>
    @endif
</div>
@endsection
