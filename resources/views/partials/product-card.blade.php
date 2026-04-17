<div class="group bg-white rounded-2xl border border-gray-200/80 overflow-hidden card-hover">
    <a href="{{ route('products.show', $product->slug) }}">
    {{-- Image --}}
    <div class="aspect-square bg-gradient-to-br from-gray-50 to-white overflow-hidden relative shine-effect">
        @if($product->featured_image)
            <img src="{{ $product->featured_image }}" alt="{{ $product->name }}"
                 class="w-full h-full object-contain p-5 group-hover:scale-110 transition-transform duration-500"
                 loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-14 h-14 text-gray-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if($product->product_type === 'variable')
                <span class="inline-flex items-center px-2.5 py-1 bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg shadow-sm">
                    Options
                </span>
            @endif
            @if($product->stock_status !== 'instock')
                <span class="inline-flex items-center px-2.5 py-1 bg-red-500 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg shadow-sm">
                    Sold Out
                </span>
            @endif
        </div>

        {{-- Quick view icon --}}
        <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all">
            <div class="w-9 h-9 bg-white/90 backdrop-blur-sm rounded-xl shadow-lg flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-4 md:p-5 pb-2 md:pb-2">
        {{-- Category --}}
        @if($product->categories->count())
            <p class="text-[11px] font-semibold text-brand-600 uppercase tracking-wider mb-1.5 truncate">
                {{ $product->categories->first()->name }}
            </p>
        @endif

        <h3 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-brand-700 transition-colors line-clamp-2 mb-3 min-h-[2.5rem]">
            {{ $product->name }}
        </h3>

        {{-- Price --}}
        <div class="flex items-center justify-between gap-2">
            @if($product->price)
                <div class="flex items-baseline gap-1">
                    @if($product->product_type === 'variable')
                        <span class="text-[10px] text-gray-400 font-medium uppercase">from</span>
                    @endif
                    <span class="text-lg font-extrabold text-gray-900">${{ $product->display_price }}</span>
                </div>
            @else
                <span class="text-xs font-medium text-gray-400">Contact for price</span>
            @endif

            @if($product->sku)
                <span class="text-[10px] text-gray-300 font-mono hidden md:inline">#{{ $product->sku }}</span>
            @endif
        </div>
    </div>
    </a>

    {{-- Add to Cart --}}
    <div class="px-4 md:px-5 pb-4 md:pb-5 pt-1">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg bg-brand-50 text-brand-700 text-xs font-bold hover:bg-brand-100 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add to Cart
            </button>
        </form>
    </div>
</div>
