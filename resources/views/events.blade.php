@extends('layouts.public', ['title' => 'Events'])

@section('content')
<div class="flex flex-col min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Header Section -->
    <section class="relative px-4 py-20 text-center bg-brand-950 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.05] bg-size-[32px_32px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-brand-500/20 rounded-full blur-[100px] z-0"></div>

        <div class="relative z-10 container mx-auto flex flex-col items-center">
            <div class="mb-4 rounded-full bg-brand-500/10 p-4 text-brand-400 border border-brand-500/20">
                <x-lucide-calendar class="h-8 w-8" />
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-4">
                Events &amp; Schedules
            </h1>
            <p class="max-w-2xl text-lg text-brand-200">
                Pantau jadwal pertandingan, hasil terbaru, dan status bracket
                turnamen komunitas Polar Catalyst per season.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="container mx-auto px-4 py-16 md:px-8 max-w-5xl">
        @if (empty($tournamentGroups) || count($tournamentGroups) === 0)
            <div class="text-center py-24 bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
                <x-lucide-trophy class="mx-auto h-12 w-12 text-neutral-300 dark:text-neutral-700 mb-4" />
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    Belum Ada Event
                </h2>
                <p class="text-neutral-500 dark:text-neutral-400">
                    Jadwal event berikutnya akan segera diumumkan.
                </p>
            </div>
        @else
            <div class="flex flex-col gap-12">
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
