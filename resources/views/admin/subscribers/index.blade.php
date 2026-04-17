@extends('admin.layout')
@section('title', 'Subscribers')
@section('page-title', 'Newsletter Subscribers')

@section('page-actions')
    <a href="{{ route('admin.subscribers.export') }}"
       class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
        Export CSV
    </a>
@endsection

@section('content')
<div class="space-y-4">
    {{-- Search --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Search by email...">
            </div>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.subscribers.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-900">{{ $subscribers->total() }}</p>
            <p class="text-sm text-gray-500">Total Subscribers</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Subscriber::where('is_active', true)->count() }}</p>
            <p class="text-sm text-gray-500">Active</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-400">{{ \App\Models\Subscriber::where('is_active', false)->count() }}</p>
            <p class="text-sm text-gray-500">Unsubscribed</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($subscribers->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Subscribed</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($subscribers as $sub)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $sub->email }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $sub->name ?: '—' }}</td>
                                <td class="px-6 py-3">
                                    @if($sub->is_active)
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Active</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $sub->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-3">
                                    <form action="{{ route('admin.subscribers.destroy', $sub) }}" method="POST" onsubmit="return confirm('Remove this subscriber?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($subscribers->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $subscribers->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                <p class="text-gray-500 text-sm">No subscribers yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
