@extends('admin.layout')
@section('title', 'Bundles / Sales')
@section('page-title', 'Bundles / Sales')

@section('page-actions')
    <a href="{{ route('admin.bundles.create') }}"
       class="inline-flex items-center gap-2 bg-brand-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Bundle
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
                       placeholder="Search bundles...">
            </div>
            <button type="submit" class="px-5 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                Filter
            </button>
            @if(request('search'))
                <a href="{{ route('admin.bundles.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium self-center">Clear</a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        @if($bundles->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600 w-14"></th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Bundle</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Products</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Original</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Bundle Price</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Savings</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Period</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($bundles as $bundle)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3">
                                    @if($bundle->image)
                                        <img src="{{ $bundle->image }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"/></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <p class="font-medium text-gray-900">{{ Str::limit($bundle->name, 50) }}</p>
                                    @if($bundle->description)
                                        <p class="text-xs text-gray-500 mt-0.5 truncate max-w-xs">{{ Str::limit($bundle->description, 60) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $bundle->products_count }} items
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500 line-through text-xs">${{ number_format($bundle->original_price, 2) }}</td>
                                <td class="px-6 py-3 font-bold text-gray-900">${{ number_format($bundle->bundle_price, 2) }}</td>
                                <td class="px-6 py-3">
                                    @if($bundle->savings_percent > 0)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            -{{ $bundle->savings_percent }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-xs text-gray-500">
                                    @if($bundle->starts_at || $bundle->ends_at)
                                        {{ $bundle->starts_at?->format('M d') ?? '...' }} – {{ $bundle->ends_at?->format('M d') ?? '...' }}
                                    @else
                                        <span class="text-gray-400">Always</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if($bundle->is_currently_active)
                                        <span class="w-2 h-2 bg-green-500 rounded-full inline-block" title="Active"></span>
                                    @else
                                        <span class="w-2 h-2 bg-gray-300 rounded-full inline-block" title="Inactive"></span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2 justify-end">
                                        <a href="{{ route('admin.bundles.edit', $bundle) }}" class="p-1.5 text-gray-400 hover:text-brand-600 rounded-lg hover:bg-brand-50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                                        </a>
                                        <form action="{{ route('admin.bundles.destroy', $bundle) }}" method="POST" onsubmit="return confirm('Delete this bundle?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($bundles->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $bundles->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"/></svg>
                <p class="text-gray-500 text-sm mb-4">No bundles found.</p>
                <a href="{{ route('admin.bundles.create') }}" class="inline-flex items-center gap-2 text-brand-600 font-medium text-sm hover:text-brand-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Create your first bundle
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
