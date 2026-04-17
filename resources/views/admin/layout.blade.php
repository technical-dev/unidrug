<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Unidrug Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-6 h-16 border-b border-white/10">
                <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-lg font-extrabold tracking-tight">uni<span class="text-brand-400">drug</span></span>
                <span class="text-[10px] bg-brand-500/20 text-brand-300 font-bold px-2 py-0.5 rounded-full ml-auto uppercase">Admin</span>
            </div>

            {{-- Nav --}}
            <nav class="px-4 py-6 space-y-1">
                @php $route = request()->route()?->getName(); @endphp

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.products') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.categories') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    Categories
                </a>

                <a href="{{ route('admin.quotes.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.quotes') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Orders
                    @if($pendingQuotes = \App\Models\QuoteRequest::where('status', 'pending')->count())
                        <span class="ml-auto bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingQuotes }}</span>
                    @endif
                </a>

                <div class="border-t border-white/10 my-4"></div>

                <p class="px-3 mb-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Content</p>

                <a href="{{ route('admin.banners.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.banners') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3h18a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 21 21H3a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 3 3z"/></svg>
                    Banners
                </a>

                <a href="{{ route('admin.posts.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.posts') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                    Blog Posts
                </a>

                <a href="{{ route('admin.subscribers.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.subscribers') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    Subscribers
                    @if($subscriberCount = \App\Models\Subscriber::where('is_active', true)->count())
                        <span class="ml-auto bg-brand-500/20 text-brand-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $subscriberCount }}</span>
                    @endif
                </a>

                <div class="border-t border-white/10 my-4"></div>

                <p class="px-3 mb-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Requests</p>

                <a href="{{ route('admin.job-applications.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.job-applications') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    Job Applications
                    @if($newApps = \App\Models\JobApplication::where('created_at', '>=', now()->subDays(7))->count())
                        <span class="ml-auto bg-brand-500/20 text-brand-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $newApps }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.service-requests.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.service-requests') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384 3.183a.667.667 0 01-.966-.723l1.03-5.99L1.72 7.44a.667.667 0 01.37-1.138l6.02-.877L10.8.89a.667.667 0 011.2 0l2.69 5.535 6.02.877a.667.667 0 01.37 1.138l-4.38 4.2 1.03 5.99a.667.667 0 01-.966.723L11.42 15.17z"/></svg>
                    Service Requests
                    @if($pendingServices = \App\Models\ServiceRequest::where('status', 'pending')->count())
                        <span class="ml-auto bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingServices }}</span>
                    @endif
                </a>

                <div class="border-t border-white/10 my-4"></div>

                <div class="border-t border-white/10 my-4"></div>

                <p class="px-3 mb-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest">System</p>

                <a href="{{ route('admin.settings.edit') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ str_starts_with($route, 'admin.settings') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>

                <a href="{{ url('/') }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    View Store
                </a>
            </nav>

            {{-- User --}}
            <div class="absolute bottom-0 left-0 right-0 border-t border-white/10 px-4 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-brand-500/20 rounded-full flex items-center justify-center text-brand-300 text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-1.5 text-gray-500 hover:text-red-400 transition-colors rounded-lg" title="Logout">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200 h-16 flex items-center px-4 lg:px-8">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-gray-500 hover:bg-gray-100 rounded-xl mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
                <h1 class="text-lg font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                <div class="ml-auto flex items-center gap-3">
                    @yield('page-actions')
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-4 lg:mx-8 mt-4">
                    <div class="flex items-center gap-3 bg-brand-50 border border-brand-200 text-brand-800 px-4 py-3 rounded-xl text-sm font-medium">
                        <svg class="w-5 h-5 text-brand-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <main class="p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
