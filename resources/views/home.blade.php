@extends('layouts.public', ['title' => 'Home'])

@section('content')
<div class="flex flex-col">
    <!-- Hero Section -->
    <section class="relative flex flex-col items-center justify-center px-4 pt-32 pb-48 text-center md:pt-48 md:pb-64 bg-linear-to-b from-brand-50/50 to-white dark:from-brand-950/30 dark:to-neutral-950 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-black/[0.02] dark:bg-grid-white/[0.02] bg-size-[32px_32px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-120 h-120 bg-brand-500/10 rounded-full blur-[140px] pointer-events-none"></div>

        <!-- Catalyst Logo Background -->
        <div
            class="absolute inset-0 z-0 opacity-10 dark:opacity-20 pointer-events-none"
            style="background-image: url('/Catalyst.svg'); background-position: center; background-size: 80% auto; background-repeat: no-repeat;"
        ></div>

        <div class="relative z-10 flex max-w-200 flex-col items-center gap-6 pt-4">
            <h1 class="text-5xl font-extrabold tracking-tight text-neutral-900 dark:text-white sm:text-6xl md:text-7xl">
                POLAR CATALYST
            </h1>
            <h2 class="text-lg font-semibold tracking-wide text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-300 sm:text-xl md:text-4xl">
                Community Organizer &amp; Creative Marketing Collective
            </h2>

            <p class="max-w-150 text-lg text-neutral-600 dark:text-neutral-400 md:text-xl leading-relaxed">
                From Community To Community For Community
                <br />
                <i>"We Don't Follow The Crowd, We Move It."</i>
            </p>
        </div>
    </section>

    <!-- Latar Belakang Section -->
    <section class="container mx-auto px-4 py-20 md:py-24 md:px-8 max-w-5xl">
        <div class="p-8 md:p-14 rounded-3xl bg-white/70 dark:bg-neutral-900/50 backdrop-blur-sm border border-neutral-200/80 dark:border-neutral-800 shadow-xs text-center space-y-6">
            <div class="inline-block rounded-full bg-brand-100 dark:bg-brand-900/30 px-3.5 py-1 text-sm font-semibold text-brand-600 dark:text-brand-400 border border-brand-500/20">
                Latar Belakang
            </div>
            <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl text-neutral-900 dark:text-white">
                Apa itu
                <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-400">
                    Polar Catalyst
                </span>
                ?
            </h2>
            <p class="text-base md:text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed max-w-3xl mx-auto">
                Polar Catalyst adalah Community Organizer dan kolektif kreatif yang
                berfokus pada pengembangan komunitas, penciptaan pengalaman, dan
                strategi marketing kreatif, Kami hadir untuk menghidupkan komunitas,
                menghadirkan pengalaman yang berbeda, dan mengubah ide-ide yang
                tidak terpikirkan sebelumnya menjadi sesuatu yang nyata dan
                berdampak.
            </p>
        </div>
    </section>

    <!-- Feature Highlights -->
    <section class="container mx-auto px-4 py-16 md:py-24 md:px-8 max-w-6xl">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <a
                href="{{ route('results') }}"
                class="group flex flex-col items-center text-center p-8 rounded-3xl bg-white border border-neutral-200/80 shadow-xs dark:bg-neutral-900/60 dark:border-neutral-800 transition-all hover:-translate-y-1.5 hover:shadow-xl hover:border-brand-500/40 cursor-pointer"
            >
                <div class="mb-5 w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-500 dark:bg-amber-500/15 flex items-center justify-center border border-amber-500/20 group-hover:scale-105 transition-transform">
                    <x-lucide-trophy class="h-7 w-7" />
                </div>
                <h3 class="mb-2 text-xl font-bold dark:text-white group-hover:text-brand-500 transition-colors">
                    Live Leaderboard
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed text-sm md:text-base">
                    Pantau pergerakan bracket dan hasil turnamen secara real-time
                    transparan saat event berjalan.
                </p>
            </a>

            <a
                href="{{ route('events') }}"
                class="group flex flex-col items-center text-center p-8 rounded-3xl bg-white border border-neutral-200/80 shadow-xs dark:bg-neutral-900/60 dark:border-neutral-800 transition-all hover:-translate-y-1.5 hover:shadow-xl hover:border-brand-500/40 cursor-pointer"
            >
                <div class="mb-5 w-14 h-14 rounded-2xl bg-brand-500/10 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center justify-center border border-brand-500/20 group-hover:scale-105 transition-transform">
                    <x-lucide-calendar class="h-7 w-7" />
                </div>
                <h3 class="mb-2 text-xl font-bold dark:text-white group-hover:text-brand-500 transition-colors">
                    Jadwal Event
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed text-sm md:text-base">
                    Jangan lewatkan setiap match! Cek jadwal event yang sedang
                    berjalan.
                </p>
            </a>

            <a
                href="https://discord.gg/Wb4eMan7rg"
                target="_blank"
                rel="noopener noreferrer"
                class="group flex flex-col items-center text-center p-8 rounded-3xl bg-white border border-neutral-200/80 shadow-xs dark:bg-neutral-900/60 dark:border-neutral-800 transition-all hover:-translate-y-1.5 hover:shadow-xl hover:border-brand-500/40 cursor-pointer"
            >
                <div class="mb-5 w-14 h-14 rounded-2xl bg-cyan-500/10 text-cyan-600 dark:bg-cyan-500/15 dark:text-cyan-400 flex items-center justify-center border border-cyan-500/20 group-hover:scale-105 transition-transform">
                    <x-lucide-users class="h-7 w-7" />
                </div>
                <h3 class="mb-2 text-xl font-bold dark:text-white group-hover:text-brand-500 transition-colors">
                    Community Support
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed text-sm md:text-base">
                    Bergabung dengan para penggemar Vtuber dari berbagai tempat dan
                    dukung komunitasmu agar Juara.
                </p>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section class="container mx-auto px-4 py-20 md:py-24 md:px-8 max-w-6xl">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2">
                <div class="aspect-video rounded-3xl bg-linear-to-br from-brand-950/90 via-neutral-900 to-neutral-950 overflow-hidden relative border border-brand-800/40 shadow-md flex items-center justify-center group">
                    <div class="absolute inset-0 bg-brand-500/10 mix-blend-overlay"></div>
                    <div class="absolute inset-0 bg-grid-white/[0.04] bg-size-[24px_24px]"></div>
                    <div class="relative z-10 flex flex-col items-center gap-3 text-brand-400 group-hover:scale-105 transition-transform duration-300">
                        <div class="w-20 h-20 rounded-2xl bg-brand-500/15 border border-brand-500/30 flex items-center justify-center text-brand-400 shadow-md">
                            <x-lucide-trophy class="w-10 h-10" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-300/80">Polar Arena</span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 space-y-6">
                <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl text-neutral-900 dark:text-white">
                    Explore Our
                    <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-400">
                        Event
                    </span>
                </h2>
                <p class="text-base md:text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed">
                    Polar Catalyst hadir sebagai wadah pemersatu bagi para penggemar
                    Virtual di Indonesia. Kami menyelenggarakan berbagai turnamen
                    kompetitif, event komunitas, dan aktivitas kolaboratif lainnya.
                </p>
                <ul class="space-y-3.5 text-neutral-700 dark:text-neutral-300">
                    <li class="flex items-center gap-3 p-3 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800/80 hover:border-brand-500/30 hover:bg-white dark:hover:bg-neutral-900 transition-all">
                        <div class="rounded-xl bg-brand-100 p-2 text-brand-600 dark:bg-brand-900/40 dark:text-brand-400 shrink-0">
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </div>
                        <span class="font-semibold text-sm md:text-base text-neutral-900 dark:text-white">Fandom Clash Arena</span>
                    </li>
                    <li class="flex items-center gap-3 p-3 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800/80 hover:border-brand-500/30 hover:bg-white dark:hover:bg-neutral-900 transition-all">
                        <div class="rounded-xl bg-brand-100 p-2 text-brand-600 dark:bg-brand-900/40 dark:text-brand-400 shrink-0">
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </div>
                        <span class="font-semibold text-sm md:text-base text-neutral-900 dark:text-white">Chill and Talk</span>
                    </li>
                    <li class="flex items-center gap-3 p-3 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800/80 hover:border-brand-500/30 hover:bg-white dark:hover:bg-neutral-900 transition-all">
                        <div class="rounded-xl bg-brand-100 p-2 text-brand-600 dark:bg-brand-900/40 dark:text-brand-400 shrink-0">
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </div>
                        <span class="font-semibold text-sm md:text-base text-neutral-900 dark:text-white">Random Giveaway</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative overflow-hidden bg-brand-950 py-24 text-center border-t border-brand-900/60">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.05] bg-size-[32px_32px]"></div>
        <div class="absolute left-1/2 top-1/2 z-0 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-500/20 blur-[120px] h-75 w-75 pointer-events-none"></div>

        <div class="relative z-10 container mx-auto px-4 md:px-8 flex flex-col items-center">
            <h2 class="mb-6 text-3xl font-extrabold tracking-tight text-white md:text-5xl">
                The Crowd Is Waiting, Come Join the Catalyst
            </h2>
            <p class="mb-10 max-w-2xl text-base md:text-lg text-brand-200 leading-relaxed">
                Sebuah event tidak akan hidup tanpa orang-orang di baliknya dan
                Sebuah komunitas tidak akan bergerak tanpa mereka yang berani
                menjadi pemicunya. Bergabunglah dengan kami.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a
                    href="{{ route('contact') }}"
                    class="inline-flex h-12 items-center justify-center rounded-full bg-white px-8 text-sm font-bold text-brand-950 shadow-lg transition-all hover:bg-neutral-100 hover:scale-105 active:scale-95"
                >
                    Punya Saran?
                </a>
                <a
                    href="https://discord.gg/Wb4eMan7rg"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex h-12 items-center justify-center rounded-full border border-brand-800 bg-brand-900/50 px-8 text-sm font-bold text-white transition-all hover:bg-brand-800 hover:scale-105 active:scale-95"
                >
                    Bergabung Sekarang
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
