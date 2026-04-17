@extends('admin.layout')
@section('title', $post ? 'Edit Post' : 'New Post')
@section('page-title', $post ? 'Edit Post' : 'New Post')

@section('page-actions')
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">&larr; Back to Posts</a>
@endsection

@section('content')
<form method="POST"
      action="{{ $post ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      enctype="multipart/form-data"
      class="max-w-4xl space-y-6">
    @csrf
    @if($post) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc ml-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Basic Info --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5">
        <h2 class="text-base font-bold text-gray-900">Post Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $post?->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="Post title">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $post?->slug) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                       placeholder="auto-generated-from-title">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                    <option value="draft" {{ old('status', $post?->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="publish" {{ old('status', $post?->status) === 'publish' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Excerpt</label>
                <textarea name="excerpt" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 placeholder:text-gray-400"
                          placeholder="Short summary for listings and SEO">{{ old('excerpt', $post?->excerpt) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Content <span class="text-red-500">*</span></label>
                <textarea name="content" rows="15" required
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-mono placeholder:text-gray-400"
                          placeholder="Write your post content here... HTML is supported.">{{ old('content', $post?->content) }}</textarea>
                <p class="text-xs text-gray-400 mt-1.5">HTML is supported. Use headings, paragraphs, lists, and images.</p>
            </div>
        </div>
    </div>

    {{-- Featured Image --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5" x-data="{ preview: '{{ $post && $post->featured_image ? $post->featured_image : '' }}' }">
        <h2 class="text-base font-bold text-gray-900">Featured Image</h2>
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
                <input type="file" name="featured_image" accept="image/*" class="hidden"
                       @change="preview = URL.createObjectURL($event.target.files[0])">
            </label>
            <p class="text-xs text-gray-400 mt-2">Recommended: 1200×630px. JPG, PNG, or WebP.</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-brand-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            {{ $post ? 'Update Post' : 'Create Post' }}
        </button>
        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2.5 text-sm text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
    </div>
</form>
@endsection
