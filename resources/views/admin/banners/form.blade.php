@extends('admin.layout')
@section('title', $banner ? 'Edit Banner' : 'New Banner')
@section('page-title', $banner ? 'Edit Banner' : 'New Banner')

@section('page-actions')
    <a href="{{ route('admin.banners.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">&larr; Back to Banners</a>
@endsection

@section('content')
<form method="POST"
      action="{{ $banner ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
      enctype="multipart/form-data"
      class="max-w-4xl space-y-6">
    @csrf
    @if($banner) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc ml-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5">
        <h2 class="text-base font-bold text-gray-900">Banner Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $banner?->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Banner headline">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $banner?->subtitle) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Short subtitle text">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                          placeholder="Optional description text">{{ old('description', $banner?->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Button Text</label>
                <input type="text" name="button_text" value="{{ old('button_text', $banner?->button_text) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="e.g., Shop Now">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Button URL</label>
                <input type="text" name="button_url" value="{{ old('button_url', $banner?->button_url) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="/products or https://...">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $banner?->sort_order ?? 0) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="0">
            </div>

            <div class="flex items-end">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner?->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500/20">
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Image Upload --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5" x-data="{ preview: '{{ $banner && $banner->image ? asset($banner->image) : '' }}' }">
        <h2 class="text-base font-bold text-gray-900">Banner Image</h2>
        <div>
            <template x-if="preview">
                <div class="mb-4">
                    <img :src="preview" alt="Preview" class="max-h-48 rounded-xl border border-gray-200">
                </div>
            </template>
            <label class="block">
                <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700 cursor-pointer transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    Choose Image
                </span>
                <input type="file" name="image" accept="image/*" class="hidden"
                       @change="preview = URL.createObjectURL($event.target.files[0])">
            </label>
            <p class="text-xs text-gray-400 mt-2">Recommended: 1920×600px. JPG, PNG, or WebP.</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-brand-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            {{ $banner ? 'Update Banner' : 'Create Banner' }}
        </button>
        <a href="{{ route('admin.banners.index') }}" class="px-4 py-2.5 text-sm text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
    </div>
</form>
@endsection
