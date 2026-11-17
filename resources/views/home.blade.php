@extends('layouts.public', ['title' => 'Home'])

@section('content')
<div class="flex flex-col">
    <!-- Hero Section -->
    <section class="relative flex flex-col items-center justify-center px-4 pt-32 pb-48 text-center md:pt-48 md:pb-64 bg-linear-to-b from-brand-50/50 to-white dark:from-brand-950/30 dark:to-neutral-950 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-black/[0.02] dark:bg-grid-white/[0.02] bg-size-[32px_32px]"></div>

        <!-- Catalyst Logo Background -->
        <div
            class="absolute inset-0 z-0 opacity-10 dark:opacity-25 pointer-events-none"
            style="background-image: url('/Catalyst.svg'); background-position: center; background-size: 80% auto; background-repeat: no-repeat;"
        ></div>

        <div class="relative z-10 flex max-w-200 flex-col items-center gap-6 pt-4">
            <h1 class="text-5xl font-extrabold tracking-tight text-neutral-900 dark:text-white sm:text-6xl md:text-7xl">
                POLAR CATALYST
            </h1>
            <h2 class="text-lg font-semibold tracking-wide text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-300 sm:text-xl md:text-4xl">
                Community Organizer &amp; Creative Marketing Collective
            </h2>

            <p class="max-w-150 text-lg text-neutral-600 dark:text-neutral-400 md:text-xl">
                From Community To Community For Community
                <br />
                <i>"We Don't Follow The Crowd, We Move It."</i>
            </p>
        </div>
    </section>

    <!-- Latar Belakang Section (Clean Editorial, No Card Box) -->
    <section class="container mx-auto px-4 py-24 md:px-8">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <div class="inline-block rounded-full bg-brand-100 px-3 py-1 text-sm font-medium text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 mb-4">
                Latar Belakang
            </div>
            <h2 class="text-3xl font-bold tracking-tight md:text-4xl text-neutral-900 dark:text-white">
                Apa itu
                <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-400">
                    Polar Catalyst
                </span>
                ?
            </h2>
            <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed">
                Polar Catalyst adalah Community Organizer dan kolektif kreatif yang
                berfokus pada pengembangan komunitas, penciptaan pengalaman, dan
                strategi marketing kreatif, Kami hadir untuk menghidupkan komunitas,
                menghadirkan pengalaman yang berbeda, dan mengubah ide-ide yang
                tidak terpikirkan sebelumnya menjadi sesuatu yang nyata dan
                berdampak.
            </p>
        </div>
    </section>

    <!-- Feature Highlights (Clean Grid Columns, No Heavy Boxes) -->
    <section class="container mx-auto px-4 py-20 md:px-8 max-w-6xl">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-neutral-200/80 dark:divide-neutral-800">
            <div class="flex flex-col items-center text-center px-4 pt-6 md:pt-0">
                <div class="mb-5 rounded-full bg-brand-100 p-4 text-brand-600 dark:bg-brand-900/40 dark:text-brand-400">
                    <x-lucide-trophy class="h-6 w-6" />
                </div>
                <h3 class="mb-2 text-xl font-bold text-neutral-900 dark:text-white">
                    Live Leaderboard
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 text-sm md:text-base leading-relaxed">
                    Pantau pergerakan bracket dan hasil turnamen secara real-time
                    transparan saat event berjalan.
                </p>
            </div>

            <div class="flex flex-col items-center text-center px-4 pt-6 md:pt-0">
                <div class="mb-5 rounded-full bg-brand-100 p-4 text-brand-600 dark:bg-brand-900/40 dark:text-brand-400">
                    <x-lucide-calendar class="h-6 w-6" />
                </div>
                <h3 class="mb-2 text-xl font-bold text-neutral-900 dark:text-white">
                    Jadwal Event
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 text-sm md:text-base leading-relaxed">
                    Jangan lewatkan setiap match! Cek jadwal event yang sedang
                    berjalan.
                </p>
            </div>

            <div class="flex flex-col items-center text-center px-4 pt-6 md:pt-0">
                <div class="mb-5 rounded-full bg-brand-100 p-4 text-brand-600 dark:bg-brand-900/40 dark:text-brand-400">
                    <x-lucide-users class="h-6 w-6" />
                </div>
                <h3 class="mb-2 text-xl font-bold text-neutral-900 dark:text-white">
                    Community Support
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 text-sm md:text-base leading-relaxed">
                    Bergabung dengan para penggemar Vtuber dari berbagai tempat dan
                    dukung komunitasmu agar Juara.
                </p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="container mx-auto px-4 py-24 md:px-8 max-w-6xl">
        <div class="flex flex-col md:flex-row items-center gap-12 md:gap-16">
            <div class="w-full md:w-1/2">
                <div class="aspect-video rounded-3xl bg-neutral-100 dark:bg-neutral-900 overflow-hidden relative border border-neutral-200 dark:border-neutral-800 shadow-sm flex items-center justify-center">
                    <div class="absolute inset-0 bg-brand-500/10 dark:bg-brand-500/20 mix-blend-overlay"></div>
                    <div class="relative z-10 text-brand-500/40 dark:text-brand-500/30">
                        <x-lucide-trophy class="w-24 h-24" />
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 space-y-6">
                <h2 class="text-3xl font-bold tracking-tight md:text-4xl text-neutral-900 dark:text-white">
                    Explore Our
                    <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-400">
                        Event
                    </span>
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed">
                    Polar Catalyst hadir sebagai wadah pemersatu bagi para penggemar
                    Virtual di Indonesia. Kami menyelenggarakan berbagai turnamen
                    kompetitif, event komunitas, dan aktivitas kolaboratif lainnya.
                </p>
                <ul class="space-y-4 text-neutral-700 dark:text-neutral-300">
                    <li class="flex items-center gap-3">
                        <div class="rounded-full bg-brand-100 p-1 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 shrink-0">
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </div>
                        <span class="font-medium">Fandom Clash Arena</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="rounded-full bg-brand-100 p-1 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 shrink-0">
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </div>
                        <span class="font-medium">Chill and Talk</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="rounded-full bg-brand-100 p-1 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 shrink-0">
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </div>
                        <span class="font-medium">Random Giveaway</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative overflow-hidden bg-brand-950 py-24 text-center">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.05] bg-size-[32px_32px]"></div>
        <div class="absolute left-1/2 top-1/2 z-0 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-500/20 blur-[120px] h-75 w-75 pointer-events-none"></div>

        <div class="relative z-10 container mx-auto px-4 md:px-8 flex flex-col items-center">
            <h2 class="mb-6 text-3xl font-bold tracking-tight text-white md:text-5xl">
                The Crowd Is Waiting, Come Join the Catalyst
            </h2>
            <p class="mb-10 max-w-2xl text-lg text-brand-200">
                Sebuah event tidak akan hidup tanpa orang-orang di baliknya dan
                Sebuah komunitas tidak akan bergerak tanpa mereka yang berani
                menjadi pemicunya. Bergabunglah dengan kami.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a
                    href="{{ route('contact') }}"
                    class="inline-flex h-12 items-center justify-center rounded-full bg-white px-8 text-sm font-medium text-brand-950 shadow-lg transition-all hover:bg-neutral-100 hover:scale-105 active:scale-95"
                >
                    Punya Saran?
                </a>
                <a
                    href="https://discord.gg/Wb4eMan7rg"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex h-12 items-center justify-center rounded-full border border-brand-800 bg-brand-900/50 px-8 text-sm font-medium text-white transition-all hover:bg-brand-800 hover:scale-105 active:scale-95"
                >
                    Bergabung Sekarang
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
