@extends('admin.layout')
@section('title', $jobOpening ? 'Edit Job Opening' : 'New Job Opening')
@section('page-title', $jobOpening ? 'Edit Job Opening' : 'New Job Opening')

@section('content')
<div class="max-w-3xl">
    <form action="{{ $jobOpening ? route('admin.job-openings.update', $jobOpening) : route('admin.job-openings.store') }}"
          method="POST" class="space-y-6">
        @csrf
        @if($jobOpening) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4">Job Details</h3>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" required value="{{ old('title', $jobOpening?->title) }}"
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all @error('title') border-red-300 @enderror"
                       placeholder="e.g. Outdoor Sales Representative">
                @error('title')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Location</label>
                    <input type="text" name="location" value="{{ old('location', $jobOpening?->location) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                           placeholder="e.g. Beirut, Lebanon">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Type <span class="text-red-400">*</span></label>
                    <select name="type" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all">
                        <option value="full-time" {{ old('type', $jobOpening?->type) === 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ old('type', $jobOpening?->type) === 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ old('type', $jobOpening?->type) === 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                          placeholder="Brief description of the role...">{{ old('description', $jobOpening?->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Responsibilities</label>
                <p class="text-xs text-gray-400 mb-2">One per line</p>
                <textarea name="responsibilities" rows="6"
                          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all font-mono"
                          placeholder="Contact customers to demonstrate products&#10;Recommend products based on needs&#10;Answer customer questions about products">{{ old('responsibilities', $jobOpening ? implode("\n", $jobOpening->responsibilities ?? []) : '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Requirements</label>
                <p class="text-xs text-gray-400 mb-2">One per line</p>
                <textarea name="requirements" rows="6"
                          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all font-mono"
                          placeholder="Bachelor's degree in Business or related field&#10;2+ years sales experience&#10;Strong communication skills">{{ old('requirements', $jobOpening ? implode("\n", $jobOpening->requirements ?? []) : '') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4">Settings</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $jobOpening?->sort_order ?? 0) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                           min="0">
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $jobOpening?->is_active ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-brand-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-600"></div>
                    </label>
                    <span class="text-sm font-medium text-gray-700">Active (visible on careers page)</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-lg shadow-brand-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                {{ $jobOpening ? 'Update Job Opening' : 'Create Job Opening' }}
            </button>
            <a href="{{ route('admin.job-openings.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
