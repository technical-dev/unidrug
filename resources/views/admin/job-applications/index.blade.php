@extends('admin.layout')
@section('title', 'Job Applications')
@section('page-title', 'Job Applications')

@section('content')
<div class="space-y-4">
    {{-- Search --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Search by name, email, or position...">
            </div>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.job-applications.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-900">{{ $applications->total() }}</p>
            <p class="text-sm text-gray-500">Total Applications</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-brand-600">{{ \App\Models\JobApplication::whereDate('created_at', today())->count() }}</p>
            <p class="text-sm text-gray-500">Today</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\JobApplication::where('created_at', '>=', now()->subDays(7))->count() }}</p>
            <p class="text-sm text-gray-500">This Week</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($applications->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Phone</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Position</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Resume</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($applications as $app)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $app->full_name }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $app->email }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $app->phone ?: '—' }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-700">{{ $app->position }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    @if($app->resume_path)
                                        <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank"
                                           class="inline-flex items-center gap-1 text-brand-600 hover:text-brand-800 font-medium text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                            Download
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $app->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-3">
                                    <form action="{{ route('admin.job-applications.destroy', $app) }}" method="POST" onsubmit="return confirm('Delete this application?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($applications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $applications->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <p class="text-gray-500 text-sm">No job applications yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
