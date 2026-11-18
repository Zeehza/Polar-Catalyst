@extends('layouts.public', ['title' => 'Events'])

@section('content')
<div class="flex flex-col min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Header Section -->
    <section class="relative px-4 py-14 md:py-18 text-center bg-brand-950 border-b border-brand-900/60 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.04] bg-size-[32px_32px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-brand-500/15 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 container mx-auto max-w-4xl flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-3.5 rounded-full bg-brand-500/10 text-brand-400 border border-brand-500/20 text-xs font-bold uppercase tracking-widest">
                <span class="h-2 w-2 rounded-full bg-brand-400 animate-pulse"></span>
                <span>Tournament Arena</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-3">
                Events &amp; Schedules
            </h1>
            <p class="text-sm md:text-base text-brand-200/90 max-w-xl text-pretty">
                Pantau jadwal pertandingan, hasil terbaru, dan status bracket turnamen komunitas Polar Catalyst per season.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="container mx-auto px-4 py-10 md:py-14 md:px-6 lg:px-8 max-w-7xl">
        @if (empty($tournamentGroups) || count($tournamentGroups) === 0)
            <div class="text-center py-20 px-6 bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm max-w-md mx-auto">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-400">
                    <x-lucide-calendar class="h-7 w-7" />
                </div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-1">
                    Belum Ada Event Aktif
                </h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-6">
                    Jadwal turnamen berikutnya akan segera diumumkan di server Discord komunitas.
                </p>
                <a
                    href="https://discord.gg/Wb4eMan7rg"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold transition-all shadow-sm hover:scale-[1.02] active:scale-[0.98]"
                >
                    <span>Gabung Discord Komunitas</span>
                    <x-lucide-arrow-right class="h-4 w-4" />
                </a>
            </div>
        @else
            <div class="flex flex-col gap-10">
                @foreach ($tournamentGroups as $group)
                    <livewire:tournament-event-group
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
