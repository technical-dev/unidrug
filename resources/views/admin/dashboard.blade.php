@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Products --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['products']) }}</p>
                    <p class="text-sm text-gray-500">Products</p>
                </div>
            </div>
        </div>

        {{-- Categories --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['categories']) }}</p>
                    <p class="text-sm text-gray-500">Categories</p>
                </div>
            </div>
        </div>

        {{-- Pending Quotes --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['quotes_pending']) }}</p>
                    <p class="text-sm text-gray-500">Pending Quotes</p>
                </div>
            </div>
        </div>

        {{-- Total Quotes --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['quotes_total']) }}</p>
                    <p class="text-sm text-gray-500">Total Quotes</p>
                </div>
            </div>
        </div>

        {{-- Subscribers --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['subscribers']) }}</p>
                    <p class="text-sm text-gray-500">Subscribers</p>
                </div>
            </div>
        </div>

        {{-- Published Posts --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['posts']) }}</p>
                    <p class="text-sm text-gray-500">Blog Posts</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.export.products') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export Products CSV
            </a>
            <a href="{{ route('admin.export.quotes') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export Quotes CSV
            </a>
            <a href="{{ route('admin.subscribers.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export Subscribers CSV
            </a>
        </div>
    </div>

    {{-- Recent Quotes --}}
    <div class="bg-white rounded-2xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900">Recent Quote Requests</h2>
            <a href="{{ route('admin.quotes.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all &rarr;</a>
        </div>

        @if($recentQuotes->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Ref</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Customer</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Items</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Total</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentQuotes as $quote)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 font-mono text-xs text-gray-500">#QR-{{ str_pad($quote->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3">
                                    <p class="font-medium text-gray-900">{{ $quote->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $quote->email }}</p>
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ is_array($quote->items) ? count($quote->items) : 0 }} items</td>
                                <td class="px-6 py-3 font-semibold text-gray-900">${{ number_format($quote->estimated_total, 2) }}</td>
                                <td class="px-6 py-3">
                                    @php
                                        $colors = ['pending' => 'bg-amber-100 text-amber-700', 'reviewed' => 'bg-blue-100 text-blue-700', 'quoted' => 'bg-purple-100 text-purple-700', 'accepted' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700'];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $colors[$quote->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $quote->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.quotes.show', $quote) }}" class="text-brand-600 hover:text-brand-700 font-medium text-xs">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <p class="text-gray-500 text-sm">No quote requests yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
