@extends('admin.layout')
@section('title', $product ? 'Edit Product' : 'New Product')
@section('page-title', $product ? 'Edit Product' : 'New Product')

@section('page-actions')
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">&larr; Back to Products</a>
@endsection

@section('content')
<form method="POST"
      action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="max-w-4xl space-y-6">
    @csrf
    @if($product) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc ml-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Basic Info --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5">
        <h2 class="text-base font-bold text-gray-900">Basic Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product?->name) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Enter product name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $product?->slug) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="auto-generated-from-name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product?->sku) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="e.g., UNI-001">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (USD)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="0.00">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Type <span class="text-red-500">*</span></label>
                <select name="product_type" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                    <option value="simple" {{ old('product_type', $product?->product_type) === 'simple' ? 'selected' : '' }}>Simple</option>
                    <option value="variable" {{ old('product_type', $product?->product_type) === 'variable' ? 'selected' : '' }}>Variable</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Status <span class="text-red-500">*</span></label>
                <select name="stock_status" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                    <option value="instock" {{ old('stock_status', $product?->stock_status) === 'instock' ? 'selected' : '' }}>In Stock</option>
                    <option value="outofstock" {{ old('stock_status', $product?->stock_status) === 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>

            <div class="md:col-span-2" x-data="{ preview: '{{ $product?->featured_image }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Featured Image</label>
                {{-- Current image preview --}}
                <div x-show="preview" class="mb-3">
                    <div class="relative inline-block">
                        <img :src="preview" alt="Product image" class="w-32 h-32 rounded-xl object-cover border border-gray-200">
                        <button type="button" @click="preview = ''; $refs.fileInput.value = ''"
                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-brand-400 hover:bg-brand-50/30 transition-all" x-show="!preview">
                    <div class="flex flex-col items-center justify-center py-4">
                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        <p class="text-sm text-gray-500 font-medium">Click to upload image</p>
                        <p class="text-xs text-gray-400 mt-0.5">PNG, JPG, WEBP up to 2MB</p>
                    </div>
                    <input type="file" name="featured_image" accept="image/*" class="hidden" x-ref="fileInput"
                           @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])">
                </label>
                @if($product?->featured_image)
                    <input type="hidden" name="existing_featured_image" value="{{ $product->featured_image }}">
                @endif
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Short Description</label>
            <textarea name="short_description" rows="2"
                      class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                      placeholder="Brief product summary">{{ old('short_description', $product?->short_description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Description</label>
            <textarea name="description" rows="6"
                      class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                      placeholder="Detailed product description (HTML supported)">{{ old('description', $product?->description) }}</textarea>
        </div>
    </div>

    {{-- Categories --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4">
        <h2 class="text-base font-bold text-gray-900">Categories</h2>
        @php $selectedCats = old('categories', $product ? $product->categories->pluck('id')->toArray() : []); @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 max-h-60 overflow-y-auto">
            @foreach($categories as $cat)
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer text-sm transition-colors {{ in_array($cat->id, $selectedCats) ? 'bg-brand-50 border-brand-200' : '' }}">
                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                           {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                    <span class="truncate">{{ $cat->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Toggles --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-4">Visibility</h2>
        <div class="flex flex-wrap gap-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}
                       class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                <div>
                    <p class="text-sm font-medium text-gray-900">Active</p>
                    <p class="text-xs text-gray-500">Show product on storefront</p>
                </div>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1"
                       {{ old('is_featured', $product?->is_featured ?? false) ? 'checked' : '' }}
                       class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                <div>
                    <p class="text-sm font-medium text-gray-900">Featured</p>
                    <p class="text-xs text-gray-500">Highlight on homepage</p>
                </div>
            </label>
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-brand-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            {{ $product ? 'Update Product' : 'Create Product' }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
</form>
@endsection
