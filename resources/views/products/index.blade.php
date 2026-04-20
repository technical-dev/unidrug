@extends('layouts.app')

@section('title', 'Products')

@section('content')
@php
    $parentCategories = \App\Models\Category::whereNull('parent_id')
        ->where('is_active', true)
        ->where('slug', '!=', 'uncategorized')
        ->withCount('products')
        ->with(['children' => fn($q) => $q->where('is_active', true)->withCount('products')->orderBy('name')])
        ->orderBy('name')
        ->get()
        ->filter(fn($c) => $c->products_count > 0);

    $currentSlug = request('category');
    $activeParent = null;
    $activeChild = null;
    if ($currentSlug) {
        $activeParent = $parentCategories->firstWhere('slug', $currentSlug);
        if (!$activeParent) {
            foreach ($parentCategories as $pc) {
                $found = $pc->children->firstWhere('slug', $currentSlug);
                if ($found) { $activeChild = $found; $activeParent = $pc; break; }
            }
        }
    }

    $pageTitle = request('search')
        ? 'Results for "'.request('search').'"'
        : ($currentSlug
            ? (\App\Models\Category::where('slug', $currentSlug)->value('name') ?? 'Products')
            : 'All Products');
@endphp

{{-- Page Hero --}}
<section class="relative overflow-hidden border-b border-gray-100">
    <div class="absolute inset-0 pointer-events-none"
         style="background:
            radial-gradient(ellipse 50% 40% at 10% 20%, rgba(16,185,129,0.10), transparent 60%),
            radial-gradient(ellipse 45% 40% at 90% 80%, rgba(20,184,166,0.08), transparent 60%);"></div>
    <div class="absolute inset-0 opacity-30 pointer-events-none"
         style="background-image: radial-gradient(circle at 1px 1px, rgba(6,95,70,0.12) 1px, transparent 0); background-size: 24px 24px; mask-image: radial-gradient(ellipse 60% 50% at 50% 50%, #000 30%, transparent 80%);"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-5">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 hover:text-brand-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                Home
            </a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-semibold">Products</span>
            @if($activeParent && !$activeChild)
                <span class="text-gray-300">/</span>
                <span class="text-brand-700 font-semibold">{{ $activeParent->name }}</span>
            @elseif($activeChild)
                <span class="text-gray-300">/</span>
                <a href="{{ route('products.index', ['category' => $activeParent->slug]) }}" class="hover:text-brand-700 transition-colors">{{ $activeParent->name }}</a>
                <span class="text-gray-300">/</span>
                <span class="text-brand-700 font-semibold">{{ $activeChild->name }}</span>
            @endif
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 mb-3">
                    <span class="h-px w-8 bg-brand-500"></span>
                    <p class="text-brand-700 text-[10px] font-bold uppercase tracking-[0.22em]">Catalog</p>
                </div>
                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-[-0.035em] leading-[1.05]">
                    {{ $pageTitle }}
                </h1>
                <p class="text-sm text-gray-500 mt-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-brand-100 text-brand-700 font-bold text-[10px]">{{ $products->total() }}</span>
                    {{ Str::plural('product', $products->total()) }} available
                </p>
            </div>

            {{-- Search + Sort --}}
            <div class="flex items-center gap-2 lg:gap-3">
                <form method="GET" action="{{ route('products.index') }}" class="relative flex-1 lg:flex-none">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search products…"
                           class="w-full lg:w-72 pl-10 pr-4 py-2.5 bg-white border border-gray-200/80 rounded-full text-sm focus:ring-4 focus:ring-brand-500/10 focus:border-brand-300 focus:outline-none transition-all placeholder:text-gray-400 shadow-sm">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>

                {{-- Sort (custom Alpine dropdown) --}}
                @php
                    $sorts = [
                        'newest'     => ['label' => 'Newest',    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'name_asc'   => ['label' => 'A → Z',     'icon' => 'M3 7h12M3 12h9M3 17h6m4 0l4-8 4 8m-7-3h6'],
                        'price_asc'  => ['label' => 'Price ↑',   'icon' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941'],
                        'price_desc' => ['label' => 'Price ↓',   'icon' => 'M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181'],
                    ];
                    $currentSort = request('sort', 'newest');
                @endphp
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                            class="inline-flex items-center gap-2 pl-4 pr-3 py-2.5 bg-white border border-gray-200/80 rounded-full text-sm font-semibold text-gray-700 hover:border-brand-300 hover:text-brand-700 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M6 12h12m-9 4.5h6"/></svg>
                        <span>{{ $sorts[$currentSort]['label'] ?? 'Sort' }}</span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition.origin.top
                         class="absolute right-0 mt-2 w-44 bg-white border border-gray-200/80 rounded-2xl shadow-xl overflow-hidden z-30 py-1.5">
                        @foreach($sorts as $key => $sort)
                            <a href="{{ route('products.index', array_filter(['search' => request('search'), 'category' => request('category'), 'sort' => $key])) }}"
                               class="flex items-center gap-2.5 px-4 py-2 text-sm transition-colors {{ $currentSort === $key ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sort['icon'] }}"/></svg>
                                {{ $sort['label'] }}
                                @if($currentSort === $key)
                                    <svg class="w-3.5 h-3.5 text-brand-600 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    {{-- Category Pills — horizontal scroller with edge fade --}}
    <div class="relative -mx-4 sm:-mx-6 lg:-mx-8 mb-3"
         x-data="{ scrollX(dx) { this.$refs.scroller.scrollBy({ left: dx, behavior: 'smooth' }); } }">
        {{-- Left arrow --}}
        <button @click="scrollX(-300)"
                class="hidden md:flex absolute left-2 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white shadow-lg ring-1 ring-gray-200/80 items-center justify-center text-gray-600 hover:text-brand-700 hover:ring-brand-300 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </button>
        {{-- Right arrow --}}
        <button @click="scrollX(300)"
                class="hidden md:flex absolute right-2 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white shadow-lg ring-1 ring-gray-200/80 items-center justify-center text-gray-600 hover:text-brand-700 hover:ring-brand-300 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </button>

        {{-- Edge fades --}}
        <div class="hidden md:block pointer-events-none absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-surface-50 to-transparent z-[5]"></div>
        <div class="hidden md:block pointer-events-none absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-surface-50 to-transparent z-[5]"></div>

        <div x-ref="scroller" class="flex items-center gap-2 overflow-x-auto scrollbar-hide px-4 sm:px-6 lg:px-12 py-2">
            <a href="{{ route('products.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}"
               class="chip inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap shrink-0
                      {{ !$currentSlug ? 'bg-gray-900 text-white shadow-md shadow-gray-900/20' : 'bg-white text-gray-700 ring-1 ring-gray-200/80 hover:ring-brand-300 hover:text-brand-700' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                All
                <span class="{{ !$currentSlug ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }} text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $products->total() }}</span>
            </a>

            @foreach($parentCategories as $cat)
                @php $isActiveParent = $activeParent && $activeParent->id === $cat->id; @endphp
                <a href="{{ route('products.index', array_filter(['category' => $cat->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
                   class="chip inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap shrink-0
                          {{ $isActiveParent ? 'bg-brand-600 text-white shadow-md shadow-brand-600/25' : 'bg-white text-gray-700 ring-1 ring-gray-200/80 hover:ring-brand-300 hover:text-brand-700' }}">
                    {{ $cat->name }}
                    <span class="{{ $isActiveParent ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }} text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Subcategories --}}
    @if($activeParent && $activeParent->children->filter(fn($c) => $c->products_count > 0)->count())
        <div class="flex flex-wrap items-center gap-1.5 mb-6 pl-3 border-l-2 border-brand-300">
            <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-brand-700 mr-2">Refine</span>
            <a href="{{ route('products.index', array_filter(['category' => $activeParent->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
               class="chip inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                      {{ !$activeChild ? 'bg-brand-100 text-brand-800 ring-1 ring-brand-300' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:ring-brand-300 hover:text-brand-700' }}">
                All {{ $activeParent->name }}
            </a>
            @foreach($activeParent->children->filter(fn($c) => $c->products_count > 0) as $sub)
                <a href="{{ route('products.index', array_filter(['category' => $sub->slug, 'search' => request('search'), 'sort' => request('sort')])) }}"
                   class="chip inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap
                          {{ $activeChild && $activeChild->id === $sub->id ? 'bg-brand-100 text-brand-800 ring-1 ring-brand-300' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:ring-brand-300 hover:text-brand-700' }}">
                    {{ $sub->name }}
                    <span class="text-[9px] font-bold text-gray-400">{{ $sub->products_count }}</span>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Active Filters --}}
    @if(request('search') || request('category'))
        <div class="flex items-center gap-2 mb-6 flex-wrap">
            <span class="text-[10px] uppercase tracking-[0.18em] text-gray-400 font-bold">Active</span>
            @if(request('search'))
                <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-semibold hover:bg-brand-100 transition-colors group">
                    "{{ request('search') }}"
                    <svg class="w-3 h-3 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
            @if(request('category'))
                <a href="{{ route('products.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-semibold hover:bg-brand-100 transition-colors group">
                    {{ \App\Models\Category::where('slug', request('category'))->value('name') }}
                    <svg class="w-3 h-3 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
            <a href="{{ route('products.index') }}" class="text-xs text-gray-400 hover:text-red-500 font-semibold ml-1 transition-colors">Clear all</a>
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
