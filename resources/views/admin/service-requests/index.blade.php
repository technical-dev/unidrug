@extends('admin.layout')
@section('title', 'Service Requests')
@section('page-title', 'Service Requests')

@section('content')
<div class="space-y-4">
    {{-- Search & Filters --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Search by name, email, or company...">
            </div>
            <select name="status" class="px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <select name="type" class="px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                <option value="">All Types</option>
                <option value="installation" {{ request('type') == 'installation' ? 'selected' : '' }}>Installation</option>
                <option value="refilling" {{ request('type') == 'refilling' ? 'selected' : '' }}>Refilling</option>
                <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">Search</button>
            @if(request('search') || request('status') || request('type'))
                <a href="{{ route('admin.service-requests.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-900">{{ $requests->total() }}</p>
            <p class="text-sm text-gray-500">Total Requests</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-amber-500">{{ \App\Models\ServiceRequest::where('status', 'pending')->count() }}</p>
            <p class="text-sm text-gray-500">Pending</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\ServiceRequest::where('status', 'contacted')->count() }}</p>
            <p class="text-sm text-gray-500">Contacted</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\ServiceRequest::where('status', 'completed')->count() }}</p>
            <p class="text-sm text-gray-500">Completed</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($requests->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Phone</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Company</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Service</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($requests as $req)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $req->name }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $req->email }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $req->phone ?: '—' }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $req->company ?: '—' }}</td>
                                <td class="px-6 py-3">
                                    @php
                                        $typeColors = [
                                            'installation' => 'bg-purple-100 text-purple-700',
                                            'refilling'    => 'bg-blue-100 text-blue-700',
                                            'maintenance'  => 'bg-orange-100 text-orange-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $typeColors[$req->service_type] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($req->service_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <form action="{{ route('admin.service-requests.updateStatus', $req) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                                class="text-xs font-semibold px-2 py-1 rounded-full border-0 cursor-pointer
                                                {{ $req->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                                {{ $req->status === 'contacted' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $req->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                                            <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="contacted" {{ $req->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="completed" {{ $req->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $req->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($req->message)
                                            <button type="button" title="{{ $req->message }}"
                                                    class="text-gray-400 hover:text-gray-600 cursor-help">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                            </button>
                                        @endif
                                        <form action="{{ route('admin.service-requests.destroy', $req) }}" method="POST" onsubmit="return confirm('Delete this request?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $requests->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384 3.183a.667.667 0 01-.966-.723l1.03-5.99L1.72 7.44a.667.667 0 01.37-1.138l6.02-.877L10.8.89a.667.667 0 011.2 0l2.69 5.535 6.02.877a.667.667 0 01.37 1.138l-4.38 4.2 1.03 5.99a.667.667 0 01-.966.723L11.42 15.17z"/></svg>
                <p class="text-gray-500 text-sm">No service requests yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
