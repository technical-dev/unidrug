@extends('admin.layout')
@section('title', 'Job Openings')
@section('page-title', 'Job Openings')

@section('page-actions')
    <a href="{{ route('admin.job-openings.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-lg shadow-brand-600/20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Job Opening
    </a>
@endsection

@section('content')
<div class="space-y-4">
    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-900">{{ $jobOpenings->total() }}</p>
            <p class="text-sm text-gray-500">Total Openings</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\JobOpening::where('is_active', true)->count() }}</p>
            <p class="text-sm text-gray-500">Active</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-2xl font-bold text-gray-400">{{ \App\Models\JobOpening::where('is_active', false)->count() }}</p>
            <p class="text-sm text-gray-500">Inactive</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($jobOpenings->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Title</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Location</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Type</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Created</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($jobOpenings as $job)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $job->title }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $job->location ?: '—' }}</td>
                                <td class="px-6 py-3">
                                    @php
                                        $typeColors = [
                                            'full-time' => 'bg-blue-100 text-blue-700',
                                            'part-time' => 'bg-purple-100 text-purple-700',
                                            'contract'  => 'bg-orange-100 text-orange-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $typeColors[$job->type] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst(str_replace('-', ' ', $job->type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $job->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $job->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $job->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.job-openings.edit', $job) }}" class="text-brand-600 hover:text-brand-700 font-medium text-xs">Edit</a>
                                        <form action="{{ route('admin.job-openings.destroy', $job) }}" method="POST" onsubmit="return confirm('Delete this job opening?')">
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

            @if($jobOpenings->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $jobOpenings->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                <p class="font-semibold text-gray-500">No job openings yet</p>
                <p class="text-sm mt-1">Click "Add Job Opening" to create one.</p>
            </div>
        @endif
    </div>
</div>
@endsection
