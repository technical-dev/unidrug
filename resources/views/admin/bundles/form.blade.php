@extends('admin.layout')
@section('title', $bundle ? 'Edit Bundle' : 'New Bundle')
@section('page-title', $bundle ? 'Edit Bundle' : 'New Bundle')

@section('page-actions')
    <a href="{{ route('admin.bundles.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">&larr; Back to Bundles</a>
@endsection

@section('content')
<form method="POST"
      action="{{ $bundle ? route('admin.bundles.update', $bundle) : route('admin.bundles.store') }}"
      enctype="multipart/form-data"
      class="max-w-4xl space-y-6"
      x-data="bundleForm()">
    @csrf
    @if($bundle) @method('PUT') @endif

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
        <h2 class="text-base font-bold text-gray-900">Bundle Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bundle Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $bundle?->name) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="e.g., Office Cleaning Starter Pack">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $bundle?->slug) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="auto-generated-from-name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bundle Price (USD) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="bundle_price" value="{{ old('bundle_price', $bundle?->bundle_price) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="0.00" x-model="bundlePrice">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $bundle?->sort_order ?? 0) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Starts At</label>
                <input type="date" name="starts_at" value="{{ old('starts_at', $bundle?->starts_at?->format('Y-m-d')) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Ends At</label>
                <input type="date" name="ends_at" value="{{ old('ends_at', $bundle?->ends_at?->format('Y-m-d')) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                          placeholder="Describe what's included in this bundle...">{{ old('description', $bundle?->description) }}</textarea>
            </div>

            <div class="md:col-span-2" x-data="{ preview: '{{ $bundle?->image }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bundle Image</label>
                <div x-show="preview" class="mb-3">
                    <div class="relative inline-block">
                        <img :src="preview" alt="Bundle image" class="w-32 h-32 rounded-xl object-cover border border-gray-200">
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
                    <input type="file" name="image" accept="image/*" class="hidden" x-ref="fileInput"
                           @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])">
                </label>
            </div>
        </div>
    </div>

    {{-- Select Products --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">Bundle Products</h2>
                <p class="text-xs text-gray-500 mt-0.5">Select at least 2 products to include in this bundle.</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Total original price</p>
                <p class="text-lg font-bold text-gray-900" x-text="'$' + originalTotal.toFixed(2)">$0.00</p>
                <template x-if="bundlePrice > 0 && originalTotal > 0 && bundlePrice < originalTotal">
                    <p class="text-xs font-bold text-green-600" x-text="'Save ' + Math.round(((originalTotal - bundlePrice) / originalTotal) * 100) + '%'"></p>
                </template>
            </div>
        </div>

        {{-- Product search --}}
        <div class="relative">
            <input type="text" x-model="productSearch"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400 pl-10"
                   placeholder="Search products to add...">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z"/></svg>
        </div>

        {{-- Available products grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto pr-1">
            @foreach($products as $product)
                <label class="relative flex items-start gap-3 p-3 rounded-xl border cursor-pointer transition-all"
                       :class="selectedProducts.includes({{ $product->id }}) ? 'bg-brand-50 border-brand-300 ring-1 ring-brand-200' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                       x-show="'{{ strtolower($product->name) }}'.includes(productSearch.toLowerCase()) || productSearch === ''">
                    <input type="checkbox" name="products[]" value="{{ $product->id }}"
                           class="mt-1 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                           x-model.number="selectedProducts"
                           :value="{{ $product->id }}"
                           data-price="{{ (float)($product->sale_price ?: $product->price) ?: 0 }}">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            @if($product->featured_image)
                                <img src="{{ $product->featured_image }}" alt="" class="w-8 h-8 rounded-lg object-cover shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3h18a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 21 21H3a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 3 3z"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">
                                    @if($product->price)
                                        ${{ number_format((float)($product->sale_price ?: $product->price), 2) }}
                                    @else
                                        No price
                                    @endif
                                </p>
                            </div>
                        </div>
                        {{-- Quantity input (only shows when selected) --}}
                        <div x-show="selectedProducts.includes({{ $product->id }})" x-transition class="mt-2">
                            <label class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Qty</label>
                            <input type="number" name="quantities[{{ $product->id }}]" min="1" value="{{ $bundle?->products->find($product->id)?->pivot?->quantity ?? 1 }}"
                                   class="w-16 px-2 py-1 rounded-lg border border-gray-300 text-xs focus:ring-1 focus:ring-brand-500/20 focus:border-brand-500"
                                   @input="updateQuantity({{ $product->id }}, $event.target.value)"
                                   x-ref="qty_{{ $product->id }}">
                        </div>
                    </div>
                </label>
            @endforeach
        </div>

        <p class="text-xs text-gray-400" x-show="selectedProducts.length > 0" x-text="selectedProducts.length + ' product(s) selected'"></p>
    </div>

    {{-- Visibility --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-500 w-5 h-5"
                   {{ old('is_active', $bundle?->is_active ?? true) ? 'checked' : '' }}>
            <div>
                <p class="text-sm font-semibold text-gray-900">Active</p>
                <p class="text-xs text-gray-500">Show this bundle on the storefront.</p>
            </div>
        </label>
    </div>

    {{-- Submit --}}
    <div class="flex items-center gap-4">
        <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            {{ $bundle ? 'Update Bundle' : 'Create Bundle' }}
        </button>
        <a href="{{ route('admin.bundles.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
    </div>
</form>

<script>
function bundleForm() {
    // Product prices map
    const prices = {
        @foreach($products as $product)
            {{ $product->id }}: {{ (float)($product->sale_price ?: $product->price) ?: 0 }},
        @endforeach
    };

    // Pre-selected products
    const initialSelected = @json(old('products', $bundle ? $bundle->products->pluck('id')->toArray() : []));
    const initialQuantities = {};
    @if($bundle)
        @foreach($bundle->products as $bp)
            initialQuantities[{{ $bp->id }}] = {{ $bp->pivot->quantity }};
        @endforeach
    @endif

    return {
        productSearch: '',
        selectedProducts: initialSelected.map(Number),
        quantities: Object.assign({}, initialQuantities),
        bundlePrice: {{ old('bundle_price', $bundle?->bundle_price ?? 0) }},

        get originalTotal() {
            let total = 0;
            for (const id of this.selectedProducts) {
                const qty = this.quantities[id] || 1;
                total += (prices[id] || 0) * qty;
            }
            return total;
        },

        updateQuantity(productId, value) {
            this.quantities[productId] = parseInt(value) || 1;
        }
    };
}
</script>
@endsection
