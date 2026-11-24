<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="darkreader-lock">
    <link rel="icon" href="/favicon.ico">

    <title>{{ isset($title) ? $title . ' | Polar Catalyst' : 'Polar Catalyst' }}</title>
    <meta name="description" content="{{ $description ?? 'Official online presence of Polar Catalyst' }}">

    <!-- Inter Font (Non-blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    </noscript>

    <!-- Dark Mode Init Script (No FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <noscript>
        <style>
            .reveal-on-scroll { opacity: 1 !important; transform: none !important; }
        </style>
    </noscript>
</head>
<body class="min-h-screen antialiased bg-white text-neutral-900 dark:bg-neutral-950 dark:text-neutral-50 flex flex-col font-sans">
    @include('partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @livewireScripts
</body>
</html>
