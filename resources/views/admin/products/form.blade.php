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
      class="max-w-4xl space-y-6"
      x-data="productForm()">
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
                <select name="product_type" required x-model="productType"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                    <option value="simple">Simple</option>
                    <option value="variable">Variable</option>
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

    {{-- Variations Section (only visible when product_type is "variable") --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5" x-show="productType === 'variable'" x-transition>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">Variations / Options</h2>
                <p class="text-xs text-gray-500 mt-0.5">Add different options with their own price, image, and details.</p>
            </div>
            <button type="button" @click="addVariation()"
                    class="inline-flex items-center gap-1.5 bg-brand-600 text-white px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Variation
            </button>
        </div>

        {{-- No variations message --}}
        <div x-show="variations.length === 0" class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
            <p class="text-sm text-gray-500">No variations yet. Click "Add Variation" to add options.</p>
        </div>

        {{-- Variation cards --}}
        <template x-for="(v, index) in variations" :key="v._key">
            <div class="border border-gray-200 rounded-xl p-5 space-y-4 relative bg-gray-50/50 hover:bg-white transition-colors">
                {{-- Header with drag handle and delete --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-brand-100 text-brand-700 text-xs font-bold" x-text="index + 1"></span>
                        <span class="text-sm font-semibold text-gray-700" x-text="v.name || 'New Variation'"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="toggleVariation(index)" class="p-1.5 text-gray-400 hover:text-brand-600 rounded-lg hover:bg-brand-50 transition-colors" title="Collapse/Expand">
                            <svg class="w-4 h-4 transition-transform" :class="v._open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <button type="button" @click="removeVariation(index)"
                                class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Remove">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Collapsible body --}}
                <div x-show="v._open" x-transition>
                    {{-- Hidden ID for existing variations --}}
                    <input type="hidden" :name="'variations[' + index + '][id]'" :value="v.id || ''">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Variation Name <span class="text-red-500">*</span></label>
                            <input type="text" :name="'variations[' + index + '][name]'" x-model="v.name" required
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="e.g., Small, 500ml, Red">
                        </div>

                        {{-- SKU --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">SKU</label>
                            <input type="text" :name="'variations[' + index + '][sku]'" x-model="v.sku"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="e.g., UNI-001-SM">
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Price (USD) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" :name="'variations[' + index + '][price]'" x-model="v.price" required
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="0.00">
                        </div>

                        {{-- Sale Price --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sale Price (USD)</label>
                            <input type="number" step="0.01" :name="'variations[' + index + '][sale_price]'" x-model="v.sale_price"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="Leave empty if no sale">
                        </div>

                        {{-- Attribute Name --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Attribute Name</label>
                            <input type="text" :name="'variations[' + index + '][attribute_name]'" x-model="v.attribute_name"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="e.g., Size, Color, Volume">
                        </div>

                        {{-- Attribute Value --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Attribute Value</label>
                            <input type="text" :name="'variations[' + index + '][attribute_value]'" x-model="v.attribute_value"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="e.g., Small, Blue, 500ml">
                        </div>

                        {{-- Stock Status --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Stock Status</label>
                            <select :name="'variations[' + index + '][stock_status]'" x-model="v.stock_status"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                                <option value="instock">In Stock</option>
                                <option value="outofstock">Out of Stock</option>
                            </select>
                        </div>

                        {{-- Stock Quantity --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Stock Quantity</label>
                            <input type="number" :name="'variations[' + index + '][stock_quantity]'" x-model="v.stock_quantity"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="Leave empty for unlimited">
                        </div>

                        {{-- Sort Order --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sort Order</label>
                            <input type="number" :name="'variations[' + index + '][sort_order]'" x-model="v.sort_order"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                                   placeholder="0">
                        </div>

                        {{-- Image Upload --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Variation Image</label>
                            <div class="flex items-start gap-4">
                                {{-- Current image preview --}}
                                <div x-show="v._imagePreview || v.image" class="shrink-0">
                                    <div class="relative">
                                        <img :src="v._imagePreview || v.image" alt="" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                                        <button type="button" @click="v._imagePreview = ''; v.image = ''; if($refs['varImg' + index]) $refs['varImg' + index].value = ''"
                                                class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-sm">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-brand-400 hover:bg-brand-50/30 transition-all">
                                        <div class="flex items-center gap-2 py-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                            <span class="text-xs text-gray-500 font-medium">Upload image</span>
                                        </div>
                                        <input type="file" :name="'variation_images[' + index + ']'" accept="image/*" class="hidden"
                                               :x-ref="'varImg' + index"
                                               @change="if($event.target.files[0]) v._imagePreview = URL.createObjectURL($event.target.files[0])">
                                    </label>
                                    <input type="hidden" :name="'variations[' + index + '][existing_image]'" :value="v.image || ''">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Collapsed summary --}}
                <div x-show="!v._open" class="flex items-center gap-4 text-xs text-gray-500">
                    <span x-show="v.image || v._imagePreview" class="shrink-0">
                        <img :src="v._imagePreview || v.image" alt="" class="w-8 h-8 rounded object-cover">
                    </span>
                    <span x-text="v.attribute_name ? v.attribute_name + ': ' + (v.attribute_value || '') : ''"></span>
                    <span x-show="v.price" class="font-semibold text-gray-700" x-text="'$' + parseFloat(v.price || 0).toFixed(2)"></span>
                    <span x-show="v.sale_price" class="text-red-500 font-semibold" x-text="'Sale: $' + parseFloat(v.sale_price || 0).toFixed(2)"></span>
                    <span :class="v.stock_status === 'instock' ? 'text-green-600' : 'text-red-500'" x-text="v.stock_status === 'instock' ? 'In Stock' : 'Out of Stock'"></span>
                </div>
            </div>
        </template>
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

@php
    $variationsJson = $product
        ? $product->variations->map(function($v) {
            return [
                'id' => $v->id,
                'name' => $v->name,
                'sku' => $v->sku,
                'price' => $v->price,
                'sale_price' => $v->sale_price,
                'attribute_name' => $v->attribute_name,
                'attribute_value' => $v->attribute_value,
                'stock_status' => $v->stock_status ?? 'instock',
                'stock_quantity' => $v->stock_quantity,
                'sort_order' => $v->sort_order ?? 0,
                'image' => $v->image,
                '_imagePreview' => '',
                '_open' => false,
                '_key' => 'existing-' . $v->id,
            ];
        })->toArray()
        : [];
@endphp

<script>
function productForm() {
    const existingVariations = @json($variationsJson);

    return {
        productType: '{{ old('product_type', $product?->product_type ?? 'simple') }}',
        variations: existingVariations,

        addVariation() {
            this.variations.push({
                id: '',
                name: '',
                sku: '',
                price: '',
                sale_price: '',
                attribute_name: '',
                attribute_value: '',
                stock_status: 'instock',
                stock_quantity: '',
                sort_order: this.variations.length,
                image: '',
                _imagePreview: '',
                _open: true,
                _key: 'new-' + Date.now() + '-' + Math.random().toString(36).substr(2, 5),
            });
        },

        removeVariation(index) {
            if (confirm('Remove this variation?')) {
                this.variations.splice(index, 1);
            }
        },

        toggleVariation(index) {
            this.variations[index]._open = !this.variations[index]._open;
        }
    };
}
</script>
@endsection
