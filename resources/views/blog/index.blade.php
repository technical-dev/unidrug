@extends('layouts.app')

@section('title', 'Blog — Unidrug')
@section('meta_description', 'Latest news, tips and industry insights from Unidrug Lebanon.')

@section('content')
    {{-- Header --}}
    <section class="bg-gradient-to-b from-gray-50 to-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Home</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-gray-900 font-medium">Blog</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">News & Insights</h1>
            <p class="text-gray-500 mt-2">Stay updated with the latest from Unidrug</p>
        </div>
    </section>

    {{-- Posts Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        @if($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($posts as $post)
                    <article class="group bg-white rounded-2xl border border-gray-200/80 overflow-hidden card-hover">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                            <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-50 to-gray-50">
                                        <svg class="w-12 h-12 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 md:p-6">
                                <time class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ $post->created_at->format('M d, Y') }}</time>
                                <h2 class="font-bold text-gray-900 group-hover:text-brand-700 transition-colors mt-2 mb-2 line-clamp-2 text-lg">{{ $post->title }}</h2>
                                @if($post->excerpt)
                                    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $post->excerpt }}</p>
                                @endif
                                <span class="inline-flex items-center gap-1 text-brand-600 text-sm font-semibold mt-3 group-hover:gap-2 transition-all">
                                    Read more
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                <h2 class="text-xl font-bold text-gray-900 mb-2">No posts yet</h2>
                <p class="text-gray-500">Check back soon for news and updates.</p>
            </div>
        @endif
    </section>
@endsection
