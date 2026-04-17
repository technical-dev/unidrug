@extends('admin.layout')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="space-y-4">
    {{-- Filters --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Search by name or email...">
            </div>
            <select name="status"
                    class="px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                <option value="">All Statuses</option>
                @foreach(['pending', 'reviewed', 'quoted', 'accepted', 'rejected'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                Filter
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.quotes.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($quotes->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Ref</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Customer</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Company</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Items</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Total</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($quotes as $quote)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 font-mono text-xs text-gray-500">#ORD-{{ str_pad($quote->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3">
                                    <p class="font-medium text-gray-900">{{ $quote->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $quote->email }}</p>
                                    @if($quote->phone)
                                        <p class="text-xs text-gray-400">{{ $quote->phone }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-600 text-sm">{{ $quote->company ?: '—' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ is_array($quote->items) ? count($quote->items) : 0 }}</td>
                                <td class="px-6 py-3 font-semibold text-gray-900">${{ number_format($quote->estimated_total, 2) }}</td>
                                <td class="px-6 py-3">
                                    @php
                                        $colors = ['pending' => 'bg-amber-100 text-amber-700', 'reviewed' => 'bg-blue-100 text-blue-700', 'quoted' => 'bg-purple-100 text-purple-700', 'accepted' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700'];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $colors[$quote->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $quote->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.quotes.show', $quote) }}" class="inline-flex items-center gap-1 text-brand-600 hover:text-brand-700 font-medium text-xs">
                                        View
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($quotes->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $quotes->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <p class="text-gray-500 text-sm">No orders found.</p>
            </div>
        @endif
    </div>
</div>
@endsection
