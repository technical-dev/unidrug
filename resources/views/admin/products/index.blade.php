@extends('admin.layout')
@section('title', 'Products')
@section('page-title', 'Products')

@section('page-actions')
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-2 bg-brand-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Product
    </a>
@endsection

@section('content')
<div class="space-y-4">
    {{-- Filters --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Search products...">
            </div>
            <select name="category"
                    class="px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                Filter
            </button>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($products->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600 w-14"></th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Product</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">SKU</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Price</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Stock</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Categories</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3">
                                    @if($product->featured_image)
                                        <img src="{{ $product->featured_image }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3h18a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 21 21H3a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 3 3z"/></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <p class="font-medium text-gray-900">{{ Str::limit($product->name, 50) }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $product->product_type }}</p>
                                </td>
                                <td class="px-6 py-3 text-gray-500 font-mono text-xs">{{ $product->sku ?: '—' }}</td>
                                <td class="px-6 py-3 font-semibold text-gray-900">
                                    @if($product->price)
                                        ${{ number_format($product->price, 2) }}
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $product->stock_status === 'instock' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $product->stock_status === 'instock' ? 'In Stock' : 'Out' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-xs text-gray-500">{{ $product->categories->pluck('name')->join(', ') ?: '—' }}</td>
                                <td class="px-6 py-3">
                                    @if($product->is_active ?? true)
                                        <span class="w-2 h-2 bg-green-500 rounded-full inline-block" title="Active"></span>
                                    @else
                                        <span class="w-2 h-2 bg-gray-300 rounded-full inline-block" title="Inactive"></span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2 justify-end">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 text-gray-400 hover:text-brand-600 rounded-lg hover:bg-brand-50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="text-gray-500 text-sm mb-4">No products found.</p>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 text-brand-600 font-medium text-sm hover:text-brand-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Add your first product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
