@php
    $members = $groupMembers ?? [];
    $hasGroup = count($members) > 1;
    $baseName = $hasGroup ? preg_replace('/\s*-\s*(Small|Medium|Large|Extra Large|S|M|L|XL|XXL)\s*$/i', '', $product->name) : $product->name;
    $cardId = 'pc-' . $product->id;
@endphp
<div class="group bg-white rounded-2xl border border-gray-200/80 overflow-hidden card-hover flex flex-col"
     @if($hasGroup)
     x-data="{
        selected: 0,
        members: @js(collect($members)->map(fn($m) => ['id' => $m->id, 'slug' => $m->slug, 'label' => $m->variant_label, 'price' => number_format((float)($m->sale_price ?? $m->price), 2), 'image' => $m->featured_image, 'sku' => $m->sku])->values()),
        get current() { return this.members[this.selected] || this.members[0]; }
     }"
     @endif
>
    <a :href="'{{ url('/products') }}/' + (typeof current !== 'undefined' ? current.slug : '{{ $product->slug }}')"
       href="{{ route('products.show', $product->slug) }}">
        {{-- Image --}}
        <div class="aspect-square bg-gradient-to-br from-gray-50 to-white overflow-hidden relative shine-effect">
            @if($hasGroup)
                <template x-for="(m, i) in members" :key="m.id">
                    <img x-show="selected === i"
                         :src="m.image || ''"
                         :alt="m.label"
                         class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500"
                         loading="lazy"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                </template>
            @elseif($product->featured_image)
                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}"
                     class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            {{-- Badges --}}
            <div class="absolute top-2.5 left-2.5 flex flex-col gap-1">
                @if($hasGroup)
                    <span class="inline-flex items-center px-2 py-0.5 bg-brand-600 text-white text-[9px] font-bold uppercase tracking-wider rounded-md shadow-sm">
                        {{ count($members) }} sizes
                    </span>
                @elseif($product->product_type === 'variable')
                    <span class="inline-flex items-center px-2 py-0.5 bg-blue-600 text-white text-[9px] font-bold uppercase tracking-wider rounded-md shadow-sm">
                        Options
                    </span>
                @endif
                @if($product->stock_status !== 'instock')
                    <span class="inline-flex items-center px-2 py-0.5 bg-red-500 text-white text-[9px] font-bold uppercase tracking-wider rounded-md shadow-sm">
                        Sold Out
                    </span>
                @endif
            </div>

            {{-- Arrow icon --}}
            <div class="absolute bottom-2.5 right-2.5 opacity-0 group-hover:opacity-100 transform translate-y-1 group-hover:translate-y-0 transition-all">
                <div class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-lg shadow-md flex items-center justify-center">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-3.5 md:p-4 pb-1.5 md:pb-2 flex-1">
            @if($product->categories->count())
                <p class="text-[10px] font-semibold text-brand-600 uppercase tracking-wider mb-1 truncate">
                    {{ $product->categories->first()->name }}
                </p>
            @endif

            <h3 class="font-bold text-gray-900 text-[13px] leading-snug group-hover:text-brand-700 transition-colors line-clamp-2 mb-2 min-h-[2.25rem]">
                {{ $baseName }}
            </h3>

            {{-- Price --}}
            <div class="flex items-baseline gap-1.5">
                @if($hasGroup)
                    <span class="text-base md:text-lg font-extrabold text-gray-900" x-text="'$' + current.price">
                        ${{ number_format((float)($product->sale_price ?? $product->price), 2) }}
                    </span>
                @elseif($product->price)
                    <div class="flex items-baseline gap-1">
                        @if($product->product_type === 'variable')
                            <span class="text-[9px] text-gray-400 font-medium uppercase">from</span>
                        @endif
                        <span class="text-base md:text-lg font-extrabold text-gray-900">${{ $product->display_price }}</span>
                    </div>
                @else
                    <span class="text-xs font-medium text-gray-400">Contact for price</span>
                @endif
            </div>
        </div>
    </a>

    {{-- Variant Selector --}}
    @if($hasGroup)
        <div class="px-3.5 md:px-4 pt-2 pb-1.5" @click.stop>
            <div class="flex flex-wrap gap-1.5">
                <template x-for="(m, i) in members" :key="m.id">
                    <button @click.prevent="selected = i"
                            :class="selected === i ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400'"
                            class="px-2.5 py-1 rounded-lg border text-[11px] font-semibold transition-all"
                            x-text="m.label">
                    </button>
                </template>
            </div>
        </div>
    @endif

    {{-- Add to Cart --}}
    <div class="px-3.5 md:px-4 pb-3.5 md:pb-4 pt-2 mt-auto">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            @if($hasGroup)
                <input type="hidden" name="product_id" :value="current.id" value="{{ $product->id }}">
            @else
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            @endif
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg bg-brand-50 text-brand-700 text-xs font-bold hover:bg-brand-100 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add to Cart
            </button>
        </form>
    </div>
</div>
