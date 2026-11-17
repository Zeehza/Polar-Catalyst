@extends('layouts.public', ['title' => 'Results & Leaderboard'])

@section('content')
<div class="flex flex-col min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Header Section -->
    <section class="relative px-4 py-14 md:py-18 text-center bg-brand-950 border-b border-brand-900/60 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.04] bg-size-[32px_32px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-brand-500/15 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 container mx-auto max-w-4xl flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-3.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 text-xs font-bold uppercase tracking-widest">
                <x-lucide-trophy class="h-3.5 w-3.5" />
                <span>Hall of Fame &amp; Standings</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-3">
                Results &amp; Leaderboard
            </h1>
            <p class="text-sm md:text-base text-brand-200/90 max-w-xl text-pretty">
                Rekap podium juara, persentase kemenangan, dan riwayat hasil laga per season.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="container mx-auto px-4 py-10 md:py-14 md:px-8 max-w-6xl">
        @if (empty($tournamentGroups) || count($tournamentGroups) === 0)
            <div class="text-center py-20 px-6 bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm max-w-md mx-auto">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-400">
                    <x-lucide-trophy class="h-7 w-7" />
                </div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-1">
                    Belum Ada Hasil Turnamen
                </h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    Hasil pertandingan dan leaderboard akan muncul setelah turnamen dimulai.
                </p>
            </div>
        @else
            <div class="flex flex-col gap-12">
                @foreach ($tournamentGroups as $group)
                    <livewire:tournament-result-group
                        :key="$group['tournamentName']"
                        :tournamentName="$group['tournamentName']"
                        :game="$group['game']"
                        :seasonIds="$group['seasonIds']"
                    />
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
