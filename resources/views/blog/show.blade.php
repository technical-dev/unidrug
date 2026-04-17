@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
    {{-- Header --}}
    <section class="bg-gradient-to-b from-gray-50 to-white border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Home</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors">Blog</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-gray-900 font-medium truncate">{{ Str::limit($post->title, 40) }}</span>
            </nav>
            <time class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ $post->created_at->format('F d, Y') }}</time>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-2">{{ $post->title }}</h1>
        </div>
    </section>

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        @if($post->featured_image)
            <div class="aspect-[16/9] rounded-2xl overflow-hidden mb-10 border border-gray-200">
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="prose prose-gray prose-lg max-w-none prose-headings:font-bold prose-a:text-brand-600 prose-img:rounded-xl">
            {!! $post->content !!}
        </div>
    </article>

    {{-- Related Posts --}}
    @if($relatedPosts->count())
        <section class="bg-gray-50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                <h2 class="text-xl font-bold text-gray-900 mb-8">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <article class="group bg-white rounded-2xl border border-gray-200/80 overflow-hidden card-hover">
                            <a href="{{ route('blog.show', $related->slug) }}" class="block">
                                <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                                    @if($related->featured_image)
                                        <img src="{{ $related->featured_image }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-50 to-gray-50">
                                            <svg class="w-10 h-10 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <time class="text-xs text-gray-400 font-medium">{{ $related->created_at->format('M d, Y') }}</time>
                                    <h3 class="font-bold text-gray-900 group-hover:text-brand-700 transition-colors mt-1 line-clamp-2">{{ $related->title }}</h3>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
