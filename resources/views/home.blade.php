@extends('layouts.public', ['title' => 'Home'])

@section('content')
<div class="flex flex-col">
    <!-- Hero Section -->
    <section class="relative flex flex-col items-center justify-center px-4 pt-28 pb-40 text-center md:pt-40 md:pb-52 bg-linear-to-b from-brand-50/50 to-white dark:from-brand-950/30 dark:to-neutral-950 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-black/[0.02] dark:bg-grid-white/[0.02] bg-size-[32px_32px]"></div>

        <!-- Catalyst Logo Background -->
        <div
            class="absolute inset-0 z-0 opacity-10 dark:opacity-25 pointer-events-none"
            style="background-image: url('/Catalyst.svg'); background-position: center; background-size: 80% auto; background-repeat: no-repeat;"
        ></div>

        <div class="relative z-10 flex max-w-200 flex-col items-center gap-5 pt-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 text-xs font-bold uppercase tracking-widest">
                <span class="h-2 w-2 rounded-full bg-brand-500 animate-pulse"></span>
                <span>Community &amp; Creative Collective</span>
            </div>
            <h1 class="text-4xl font-black tracking-tight text-neutral-900 dark:text-white sm:text-6xl md:text-7xl">
                POLAR CATALYST
            </h1>
            <h2 class="text-base font-semibold tracking-wide text-transparent bg-clip-text bg-linear-to-r from-brand-500 to-brand-300 sm:text-xl md:text-3xl max-w-2xl text-pretty">
                Creative Marketing Collective &amp; Community Organizer
            </h2>

            <p class="max-w-md text-sm md:text-base text-neutral-600 dark:text-neutral-400">
                From Community To Community For Community
                <br />
                <span class="italic font-medium">&ldquo;We Don't Follow The Crowd, We Move It.&rdquo;</span>
            </p>

            <div class="flex items-center gap-3 pt-2">
                <a
                    href="{{ route('events') }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-brand-500 hover:bg-brand-600 text-white text-xs md:text-sm font-bold transition-all shadow-sm hover:scale-[1.02] active:scale-[0.98]"
                >
                    <x-lucide-calendar class="h-4 w-4" />
                    <span>Jadwal Event</span>
                </a>
                <a
                    href="{{ route('results') }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 text-neutral-800 dark:text-neutral-200 text-xs md:text-sm font-bold transition-all border border-neutral-200 dark:border-neutral-700 hover:scale-[1.02] active:scale-[0.98]"
                >
                    <x-lucide-trophy class="h-4 w-4 text-amber-500" />
                    <span>Leaderboard</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Latar Belakang Section -->
    <section class="container mx-auto px-4 py-18 md:px-8 max-w-4xl text-center space-y-4">
        <div class="inline-block rounded-full bg-brand-500/10 px-3 py-1 text-xs font-bold text-brand-600 dark:text-brand-400 border border-brand-500/20 uppercase tracking-wider">
            Tentang Kami
        </div>
        <h2 class="text-2xl md:text-4xl font-black tracking-tight text-neutral-900 dark:text-white">
            Pemicu Pergerakan Komunitas Kreatif
        </h2>
        <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 leading-relaxed text-pretty">
            Polar Catalyst berfokus pada pengembangan komunitas, penciptaan pengalaman kompetitif esports, dan aktivasi kreatif yang menghadirkan dampak nyata bagi para kreator dan penikmat konten virtual di Indonesia.
        </p>
    </section>

    <!-- Feature Highlights -->
    <section class="container mx-auto px-4 py-12 md:px-8 max-w-6xl">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <a
                href="{{ route('results') }}"
                class="group flex flex-col p-6 rounded-3xl bg-white border border-neutral-200/80 shadow-xs dark:bg-neutral-900 dark:border-neutral-800 transition-all hover:border-brand-500/50 hover:shadow-md hover:-translate-y-1"
            >
                <div class="mb-4 w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center border border-amber-500/20 group-hover:scale-105 transition-transform">
                    <x-lucide-trophy class="h-6 w-6" />
                </div>
                <h3 class="mb-1 text-lg font-bold text-neutral-900 dark:text-white group-hover:text-brand-500 transition-colors">
                    Hasil &amp; Leaderboard
                </h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-4 leading-relaxed">
                    Podium juara, perolehan win rate, dan rekap peringkat akhir turnamen.
                </p>
                <div class="mt-auto flex items-center gap-1.5 text-xs font-bold text-brand-600 dark:text-brand-400">
                    <span>Lihat Leaderboard</span>
                    <x-lucide-arrow-right class="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>

            <a
                href="{{ route('events') }}"
                class="group flex flex-col p-6 rounded-3xl bg-white border border-neutral-200/80 shadow-xs dark:bg-neutral-900 dark:border-neutral-800 transition-all hover:border-brand-500/50 hover:shadow-md hover:-translate-y-1"
            >
                <div class="mb-4 w-12 h-12 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center border border-brand-500/20 group-hover:scale-105 transition-transform">
                    <x-lucide-calendar class="h-6 w-6" />
                </div>
                <h3 class="mb-1 text-lg font-bold text-neutral-900 dark:text-white group-hover:text-brand-500 transition-colors">
                    Jadwal Pertandingan
                </h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-4 leading-relaxed">
                    Pantau match live, roster tim peserta, dan alur bagan playoff.
                </p>
                <div class="mt-auto flex items-center gap-1.5 text-xs font-bold text-brand-600 dark:text-brand-400">
                    <span>Cek Jadwal &amp; Bracket</span>
                    <x-lucide-arrow-right class="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>

            <a
                href="https://discord.gg/Wb4eMan7rg"
                target="_blank"
                rel="noopener noreferrer"
                class="group flex flex-col p-6 rounded-3xl bg-white border border-neutral-200/80 shadow-xs dark:bg-neutral-900 dark:border-neutral-800 transition-all hover:border-brand-500/50 hover:shadow-md hover:-translate-y-1"
            >
                <div class="mb-4 w-12 h-12 rounded-2xl bg-cyan-500/10 text-cyan-500 flex items-center justify-center border border-cyan-500/20 group-hover:scale-105 transition-transform">
                    <x-lucide-users class="h-6 w-6" />
                </div>
                <h3 class="mb-1 text-lg font-bold text-neutral-900 dark:text-white group-hover:text-brand-500 transition-colors">
                    Komunitas Discord
                </h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-4 leading-relaxed">
                    Ruang diskusi dan nobar bagi para penggemar kreator virtual di Indonesia.
                </p>
                <div class="mt-auto flex items-center gap-1.5 text-xs font-bold text-brand-600 dark:text-brand-400">
                    <span>Gabung Server Discord</span>
                    <x-lucide-arrow-right class="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>
        </div>
    </section>

    <!-- Tournament Showcase Section -->
    <section class="container mx-auto px-4 py-16 md:px-8 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Left Card: Tournament Preview -->
            <div class="lg:col-span-6 p-6 sm:p-8 rounded-3xl bg-linear-to-br from-brand-950 to-neutral-950 border border-brand-800/40 text-white shadow-md relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col gap-5">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-brand-400 bg-brand-500/20 border border-brand-500/30">
                            <x-lucide-gamepad-2 class="h-3.5 w-3.5" />
                            Mobile Legends
                        </span>
                        <span class="text-xs font-bold text-brand-300/80 bg-brand-900/50 px-2.5 py-0.5 rounded-md border border-brand-800">
                            Double Elimination
                        </span>
                    </div>

                    <div>
                        <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-2">
                            Fandom Clash Arena
                        </h3>
                        <p class="text-xs text-brand-200/80 leading-relaxed">
                            Turnamen kompetitif antar fandom Vtuber Indonesia dengan format playoff resmi dan live match updates.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a
                            href="{{ route('events') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold transition-all shadow-sm hover:scale-[1.02] active:scale-[0.98]"
                        >
                            <span>Buka Bagan &amp; Jadwal</span>
                            <x-lucide-arrow-right class="h-3.5 w-3.5" />
                        </a>
                        <a
                            href="{{ route('results') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-900/60 hover:bg-brand-900 text-brand-200 border border-brand-700/60 text-xs font-bold transition-all hover:scale-[1.02] active:scale-[0.98]"
                        >
                            <x-lucide-trophy class="h-3.5 w-3.5 text-amber-400" />
                            <span>Lihat Hasil Juara</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Content: Event Activities -->
            <div class="lg:col-span-6 flex flex-col gap-5">
                <div>
                    <span class="inline-block rounded-full bg-brand-500/10 px-3 py-1 text-xs font-bold text-brand-600 dark:text-brand-400 border border-brand-500/20 uppercase tracking-wider mb-2">
                        Aktivitas
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-neutral-900 dark:text-white">
                        Ekosistem Event Polar Catalyst
                    </h2>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200/70 dark:border-neutral-800">
                        <div class="w-9 h-9 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                            <x-lucide-trophy class="h-4 w-4" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Fandom Clash Arena</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Turnamen kompetitif komunitas dengan live update bracket.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200/70 dark:border-neutral-800">
                        <div class="w-9 h-9 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                            <x-lucide-sparkles class="h-4 w-4" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Chill &amp; Talk</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Sesi santai, nobar event, dan temu komunitas kreator.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200/70 dark:border-neutral-800">
                        <div class="w-9 h-9 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                            <x-lucide-gift class="h-4 w-4" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Random Giveaway</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Apresiasi merchandise dan hadiah spesial untuk member aktif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative overflow-hidden bg-brand-950 py-20 text-center border-t border-brand-900/60">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.04] bg-size-[32px_32px]"></div>
        <div class="absolute left-1/2 top-1/2 z-0 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-500/15 blur-[100px] h-64 w-64 pointer-events-none"></div>

        <div class="relative z-10 container mx-auto px-4 md:px-8 max-w-2xl flex flex-col items-center">
            <h2 class="mb-3 text-2xl md:text-4xl font-black tracking-tight text-white">
                The Crowd Is Waiting, Join the Catalyst
            </h2>
            <p class="mb-8 text-xs md:text-sm text-brand-200/90 leading-relaxed text-pretty">
                Sebuah event hidup berkat orang-orang di baliknya. Bergabunglah bersama kami dan jadilah bagian dari setiap momen seru.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a
                    href="https://discord.gg/Wb4eMan7rg"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex h-11 items-center justify-center rounded-full bg-white px-7 text-xs font-bold text-brand-950 shadow-sm transition-all hover:bg-neutral-100 hover:scale-[1.02] active:scale-[0.98]"
                >
                    Bergabung Sekarang
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="inline-flex h-11 items-center justify-center rounded-full border border-brand-700/80 bg-brand-900/40 px-7 text-xs font-bold text-white transition-all hover:bg-brand-900 hover:scale-[1.02] active:scale-[0.98]"
                >
                    Punya Saran?
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
