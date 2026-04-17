@extends('admin.layout')
@section('title', 'Order #ORD-' . str_pad($quote->id, 5, '0', STR_PAD_LEFT))
@section('page-title', 'Order #ORD-' . str_pad($quote->id, 5, '0', STR_PAD_LEFT))

@section('page-actions')
    <a href="{{ route('admin.quotes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">&larr; Back to Orders</a>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Customer Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4">Customer Information</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 font-medium">Name</dt>
                        <dd class="text-gray-900 mt-0.5">{{ $quote->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">Email</dt>
                        <dd class="text-gray-900 mt-0.5">
                            <a href="mailto:{{ $quote->email }}" class="text-brand-600 hover:text-brand-700">{{ $quote->email }}</a>
                        </dd>
                    </div>
                    @if($quote->phone)
                        <div>
                            <dt class="text-gray-500 font-medium">Phone</dt>
                            <dd class="text-gray-900 mt-0.5">{{ $quote->phone }}</dd>
                        </div>
                    @endif
                    @if($quote->company)
                        <div>
                            <dt class="text-gray-500 font-medium">Company</dt>
                            <dd class="text-gray-900 mt-0.5">{{ $quote->company }}</dd>
                        </div>
                    @endif
                </dl>

                @if($quote->message)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-sm text-gray-500 font-medium mb-1">Message</dt>
                        <dd class="text-sm text-gray-700 bg-gray-50 rounded-xl px-4 py-3">{{ $quote->message }}</dd>
                    </div>
                @endif
            </div>

            {{-- Delivery & Payment --}}
            @if($quote->city || $quote->address || $quote->payment_method)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Delivery & Payment</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        @if($quote->city)
                            <div>
                                <dt class="text-gray-500 font-medium">City</dt>
                                <dd class="text-gray-900 mt-0.5">{{ $quote->city }}</dd>
                            </div>
                        @endif
                        @if($quote->address)
                            <div>
                                <dt class="text-gray-500 font-medium">Address</dt>
                                <dd class="text-gray-900 mt-0.5">
                                    {{ $quote->address }}
                                    @if($quote->building), {{ $quote->building }}@endif
                                    @if($quote->floor), {{ $quote->floor }}@endif
                                </dd>
                            </div>
                        @endif
                        @if($quote->payment_method)
                            <div>
                                <dt class="text-gray-500 font-medium">Payment Method</dt>
                                <dd class="text-gray-900 mt-0.5">
                                    @if($quote->payment_method === 'cod')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.798 7.45c.512-.67 1.135-.95 1.702-.95s1.19.28 1.702.95a.75.75 0 001.192-.91C12.637 5.55 11.592 5 10.5 5s-2.137.55-2.894 1.54A5.205 5.205 0 006.83 8H5.75a.75.75 0 000 1.5h.77a6.333 6.333 0 000 1h-.77a.75.75 0 000 1.5h1.08c.183.528.442 1.023.776 1.46.757.99 1.802 1.54 2.894 1.54s2.137-.55 2.894-1.54a.75.75 0 00-1.192-.91c-.512.67-1.135.95-1.702.95s-1.19-.28-1.702-.95a3.505 3.505 0 01-.343-.55h1.795a.75.75 0 000-1.5H8.026a4.835 4.835 0 010-1h2.224a.75.75 0 000-1.5H8.455c.098-.195.212-.38.343-.55z"/></svg>
                                            Cash on Delivery
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                            Bank Transfer
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        @endif
                        @if($quote->tracking_token)
                            <div>
                                <dt class="text-gray-500 font-medium">Tracking Token</dt>
                                <dd class="text-gray-900 mt-0.5 font-mono text-xs">{{ $quote->tracking_token }}</dd>
                            </div>
                        @endif
                    </dl>
                    @if($quote->delivery_notes)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <dt class="text-sm text-gray-500 font-medium mb-1">Delivery Notes</dt>
                            <dd class="text-sm text-gray-700 bg-gray-50 rounded-xl px-4 py-3">{{ $quote->delivery_notes }}</dd>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Items --}}
            <div class="bg-white rounded-2xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-bold text-gray-900">Requested Items</h2>
                </div>
                @if(is_array($quote->items) && count($quote->items))
                    <div class="divide-y divide-gray-100">
                        @foreach($quote->items as $item)
                            <div class="px-6 py-4 flex items-center gap-4">
                                @if(!empty($item['image']))
                                    <img src="{{ $item['image'] }}" alt="" class="w-12 h-12 rounded-lg object-cover shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $item['name'] ?? 'Unknown Product' }}</p>
                                    @if(!empty($item['variation']))
                                        <p class="text-xs text-gray-500">{{ $item['variation'] }}</p>
                                    @endif
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] ?? 1 }}</p>
                                    @if(!empty($item['price']))
                                        <p class="text-sm font-semibold text-gray-900">${{ number_format($item['price'] * ($item['quantity'] ?? 1), 2) }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Estimated Total</span>
                        <span class="text-lg font-bold text-gray-900">${{ number_format($quote->estimated_total, 2) }}</span>
                    </div>
                @else
                    <div class="px-6 py-8 text-center text-sm text-gray-500">No items data.</div>
                @endif
            </div>
        </div>

        {{-- Status & Actions --}}
        <div class="space-y-6">
            {{-- Current Status --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h2 class="text-base font-bold text-gray-900 mb-3">Status</h2>
                @php
                    $colors = ['pending' => 'bg-amber-100 text-amber-700', 'reviewed' => 'bg-blue-100 text-blue-700', 'quoted' => 'bg-purple-100 text-purple-700', 'accepted' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700'];
                @endphp
                <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $colors[$quote->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($quote->status) }}
                </span>
                <p class="text-xs text-gray-400 mt-2">Submitted {{ $quote->created_at->format('M d, Y \\a\\t h:i A') }}</p>
            </div>

            {{-- Update Status --}}
            <form action="{{ route('admin.quotes.updateStatus', $quote) }}" method="POST"
                  class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4">
                @csrf @method('PATCH')
                <h2 class="text-base font-bold text-gray-900">Update Status</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                        @foreach(['pending', 'reviewed', 'quoted', 'accepted', 'rejected'] as $s)
                            <option value="{{ $s }}" {{ $quote->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Admin Notes</label>
                    <textarea name="admin_notes" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                              placeholder="Internal notes...">{{ $quote->admin_notes }}</textarea>
                </div>

                <button type="submit"
                        class="w-full bg-brand-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                    Save Changes
                </button>
            </form>

            {{-- Delete --}}
            <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Permanently delete this order?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full px-4 py-2.5 border border-red-200 text-red-600 rounded-xl text-sm font-medium hover:bg-red-50 transition-colors">
                    Delete Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
