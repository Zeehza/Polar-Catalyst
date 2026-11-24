<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="darkreader-lock">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <title>{{ isset($title) ? $title . ' | Admin Dashboard' : 'Polar Admin' }}</title>

    <!-- Inter Font (Non-blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    </noscript>

    <!-- Dark Mode Init Script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen antialiased bg-neutral-100 text-neutral-900 dark:bg-neutral-950 dark:text-neutral-50 font-sans" x-data="{ mobileSidebarOpen: false }">
    <div class="flex h-screen bg-neutral-100 dark:bg-neutral-950 overflow-hidden">
        <!-- Desktop Sidebar -->
        <aside class="w-64 bg-white dark:bg-neutral-900 border-r border-neutral-200 dark:border-neutral-800 flex flex-col hidden md:flex shrink-0">
            <div class="h-16 flex items-center justify-between px-6 border-b border-neutral-200 dark:border-neutral-800">
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg text-brand-500">
                    Polar Admin
                </a>
                <button
                    type="button"
                    onclick="toggleTheme()"
                    aria-label="Toggle theme"
                    class="relative inline-flex h-8 w-8 items-center justify-center rounded-md border border-neutral-200 bg-white text-xs font-medium transition-colors hover:bg-brand-50 hover:text-brand-600 focus-visible:outline-none dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-brand-950 dark:hover:text-brand-400 cursor-pointer"
                >
                    <x-lucide-sun class="h-3.5 w-3.5 block dark:hidden" />
                    <x-lucide-moon class="h-3.5 w-3.5 hidden dark:block" />
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-100 dark:bg-neutral-800 text-brand-600 dark:text-brand-400' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                >
                    <x-lucide-layout-dashboard class="h-5 w-5" /> Dashboard
                </a>
                <a
                    href="{{ route('admin.turnamen') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.turnamen*') ? 'bg-neutral-100 dark:bg-neutral-800 text-brand-600 dark:text-brand-400' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                >
                    <x-lucide-trophy class="h-5 w-5" /> Turnamen
                </a>
                <a
                    href="{{ route('admin.pesan') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.pesan') ? 'bg-neutral-100 dark:bg-neutral-800 text-brand-600 dark:text-brand-400' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                >
                    <x-lucide-mail class="h-5 w-5" /> Pesan Masuk
                </a>
            </nav>

            <div class="p-4 border-t border-neutral-200 dark:border-neutral-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors font-medium cursor-pointer"
                    >
                        <x-lucide-log-out class="h-4 w-4" /> Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Drawer Backdrop -->
        <div
            x-show="mobileSidebarOpen"
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 md:hidden"
            @click="mobileSidebarOpen = false"
        ></div>

        <!-- Mobile Drawer Sidebar -->
        <aside
            x-show="mobileSidebarOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-250 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-72 max-w-[80vw] bg-white dark:bg-neutral-900 border-r border-neutral-200 dark:border-neutral-800 flex flex-col z-50 md:hidden shadow-2xl"
        >
            <div class="h-16 flex items-center justify-between px-6 border-b border-neutral-200 dark:border-neutral-800">
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg text-brand-500">
                    Polar Admin
                </a>
                <button
                    type="button"
                    @click="mobileSidebarOpen = false"
                    class="p-2 rounded-xl text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
                    aria-label="Tutup menu navigasi"
                >
                    <x-lucide-x class="h-5 w-5" />
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a
                    href="{{ route('admin.dashboard') }}"
                    @click="mobileSidebarOpen = false"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-100 dark:bg-neutral-800 text-brand-600 dark:text-brand-400 font-bold' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                >
                    <x-lucide-layout-dashboard class="h-5 w-5" /> Dashboard
                </a>
                <a
                    href="{{ route('admin.turnamen') }}"
                    @click="mobileSidebarOpen = false"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.turnamen*') ? 'bg-neutral-100 dark:bg-neutral-800 text-brand-600 dark:text-brand-400 font-bold' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                >
                    <x-lucide-trophy class="h-5 w-5" /> Turnamen
                </a>
                <a
                    href="{{ route('admin.pesan') }}"
                    @click="mobileSidebarOpen = false"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.pesan') ? 'bg-neutral-100 dark:bg-neutral-800 text-brand-600 dark:text-brand-400 font-bold' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                >
                    <x-lucide-mail class="h-5 w-5" /> Pesan Masuk
                </a>
            </nav>

            <div class="p-4 border-t border-neutral-200 dark:border-neutral-800 flex flex-col gap-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors font-bold cursor-pointer"
                    >
                        <x-lucide-log-out class="h-4 w-4" /> Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-neutral-50 dark:bg-neutral-950 flex flex-col">
            <!-- Mobile Header -->
            <header class="md:hidden h-16 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between px-4 shrink-0">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="mobileSidebarOpen = true"
                        class="p-2 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
                        aria-label="Buka menu navigasi"
                    >
                        <x-lucide-menu class="h-5 w-5" />
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="font-bold text-brand-500">
                        Polar Admin
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        onclick="toggleTheme()"
                        aria-label="Toggle theme"
                        class="p-2 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
                    >
                        <x-lucide-sun class="h-4 w-4 block dark:hidden" />
                        <x-lucide-moon class="h-4 w-4 hidden dark:block" />
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" aria-label="Sign Out" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors cursor-pointer">
                            <x-lucide-log-out class="h-4 w-4" />
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-4 md:p-8 flex-1">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
    function toggleTheme() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }
    </script>

    @livewireScripts
</body>
</html>
