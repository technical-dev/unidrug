@extends('admin.layout')
@section('title', $category ? 'Edit Category' : 'New Category')
@section('page-title', $category ? 'Edit Category' : 'New Category')

@section('page-actions')
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">&larr; Back to Categories</a>
@endsection

@section('content')
<form method="POST"
      action="{{ $category ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      enctype="multipart/form-data"
      class="max-w-2xl space-y-6">
    @csrf
    @if($category) @method('PUT') @endif

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
        <h2 class="text-base font-bold text-gray-900">Category Details</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Category Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $category?->name) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                   placeholder="Enter category name">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category?->slug) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                   placeholder="auto-generated-from-name">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Parent Category</label>
            <select name="parent_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                <option value="">None (Top Level)</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category?->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                      placeholder="Optional category description">{{ old('description', $category?->description) }}</textarea>
        </div>

        <div x-data="{ preview: '{{ $category?->image }}' }">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Image</label>
            {{-- Current image preview --}}
            <div x-show="preview" class="mb-3">
                <div class="relative inline-block">
                    <img :src="preview" alt="Category image" class="w-32 h-32 rounded-xl object-cover border border-gray-200">
                    <button type="button" @click="preview = ''; $refs.fileInput.value = ''" 
                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-brand-400 hover:bg-brand-50/30 transition-all" x-show="!preview">
                <div class="flex flex-col items-center justify-center py-4">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    <p class="text-sm text-gray-500 font-medium">Click to upload image</p>
                    <p class="text-xs text-gray-400 mt-0.5">PNG, JPG, WEBP up to 2MB</p>
                </div>
                <input type="file" name="image" accept="image/*" class="hidden" x-ref="fileInput"
                       @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])">
            </label>
            @if($category?->image)
                <input type="hidden" name="existing_image" value="{{ $category->image }}">
            @endif
        </div>

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}
                   class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
            <div>
                <p class="text-sm font-medium text-gray-900">Active</p>
                <p class="text-xs text-gray-500">Show category on storefront</p>
            </div>
        </label>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-brand-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            {{ $category ? 'Update Category' : 'Create Category' }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
</form>
@endsection
