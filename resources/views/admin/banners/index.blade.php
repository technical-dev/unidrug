@extends('admin.layout')
@section('title', 'Banners')
@section('page-title', 'Banners')

@section('page-actions')
    <a href="{{ route('admin.banners.create') }}"
       class="inline-flex items-center gap-2 bg-brand-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Banner
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    @if($banners->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-600 w-14">Order</th>
                        <th class="px-6 py-3 font-semibold text-gray-600 w-20"></th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Title</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Button</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($banners as $banner)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 text-gray-500 font-mono text-xs">{{ $banner->sort_order }}</td>
                            <td class="px-6 py-3">
                                @if($banner->image)
                                    <img src="{{ asset($banner->image) }}" alt="" class="w-16 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3h18a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 21 21H3a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 3 3z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <p class="font-medium text-gray-900">{{ $banner->title }}</p>
                                @if($banner->subtitle)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($banner->subtitle, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if($banner->button_text)
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">{{ $banner->button_text }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if($banner->is_active)
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="text-brand-600 hover:text-brand-700 font-medium text-xs">Edit</a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Delete this banner?')">
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
    @else
        <div class="px-6 py-16 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3h18a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 21 21H3a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 3 3z"/></svg>
            <p class="text-gray-500 text-sm mb-4">No banners yet.</p>
            <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center gap-2 bg-brand-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Create First Banner
            </a>
        </div>
    @endif
</div>
@endsection
