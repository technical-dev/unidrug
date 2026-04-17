@extends('admin.layout')
@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
<div class="space-y-4">
    {{-- Search --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Search by name, email, or message...">
            </div>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-900">{{ $messages->total() }}</p>
            <p class="text-sm text-gray-500">Total Messages</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-amber-500">{{ \App\Models\ContactMessage::where('status', 'new')->count() }}</p>
            <p class="text-sm text-gray-500">New / Unread</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\ContactMessage::where('status', 'read')->count() }}</p>
            <p class="text-sm text-gray-500">Read</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($messages->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Phone</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Message</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($messages as $msg)
                            <tr class="hover:bg-gray-50/50 {{ $msg->status === 'new' ? 'bg-amber-50/30' : '' }}">
                                <td class="px-6 py-3 font-medium text-gray-900">
                                    {{ $msg->name }}
                                    @if($msg->status === 'new')
                                        <span class="inline-flex ml-1 w-2 h-2 bg-amber-500 rounded-full"></span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    <a href="mailto:{{ $msg->email }}" class="hover:text-brand-600 transition-colors">{{ $msg->email }}</a>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $msg->phone ?: '—' }}</td>
                                <td class="px-6 py-3 text-gray-500 max-w-xs truncate" title="{{ $msg->message }}">{{ Str::limit($msg->message, 60) }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $msg->status === 'new' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($msg->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $msg->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-3">
                                    <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $messages->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                <p class="font-semibold text-gray-500">No messages yet</p>
                <p class="text-sm mt-1">Contact form submissions will appear here.</p>
            </div>
        @endif
    </div>
</div>
@endsection
