@props([
    'series',
    'customLabel' => null,
])

@php
    $teamAId = $series['teamA']['id'] ?? '';
    $teamBId = $series['teamB']['id'] ?? '';
    $isWinnerA = !empty($series['winnerId']) && $teamAId === $series['winnerId'];
    $isWinnerB = !empty($series['winnerId']) && $teamBId === $series['winnerId'];
@endphp

<div
    class="w-64 rounded-xl border transition-all shadow-xs overflow-hidden flex flex-col"
    :class="(hoveredTeamId && (hoveredTeamId === '{{ $teamAId }}' || hoveredTeamId === '{{ $teamBId }}'))
        ? 'border-brand-500 ring-2 ring-brand-500/20 bg-white dark:bg-neutral-900'
        : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900/90 hover:border-neutral-300 dark:hover:border-neutral-700'"
>
    <!-- Match Header -->
    <div class="px-3 py-1.5 bg-neutral-50 dark:bg-neutral-950/70 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between text-[11px] font-semibold text-neutral-500 dark:text-neutral-400">
        <div class="flex items-center gap-1.5">
            <span class="font-mono font-bold text-neutral-700 dark:text-neutral-300">
                M{{ $series['matchOrder'] }}
            </span>
            @if ($customLabel)
                <span>• {{ $customLabel }}</span>
            @endif
        </div>
        <div>
            @if ($series['status'] === 'COMPLETED')
                <span class="text-[10px] px-1.5 py-0.5 rounded bg-neutral-200/60 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 font-medium">
                    Selesai
                </span>
            @elseif ($series['status'] === 'ONGOING')
                <span class="text-[10px] px-1.5 py-0.5 rounded bg-red-100 text-red-600 dark:bg-red-950/60 dark:text-red-400 font-bold flex items-center gap-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Live
                </span>
            @else
                <span class="text-[10px] text-neutral-400 flex items-center gap-1">
                    <x-lucide-clock class="h-2.5 w-2.5" />
                    Jadwal
                </span>
            @endif
        </div>
    </div>

    <!-- Team A Row -->
    <div
        @if ($teamAId)
            x-on:mouseenter="hoveredTeamId = '{{ $teamAId }}'"
            x-on:mouseleave="hoveredTeamId = null"
        @endif
        class="flex items-center justify-between px-3 py-2 transition-colors cursor-pointer border-b border-neutral-100 dark:border-neutral-800/60 {{ $isWinnerA ? 'bg-emerald-50/40 dark:bg-emerald-950/15' : 'hover:bg-neutral-50 dark:hover:bg-neutral-800/40' }}"
        :class="hoveredTeamId === '{{ $teamAId }}' ? 'bg-brand-500/15 text-brand-700 dark:text-brand-300 font-bold' : ''"
    >
        <div class="flex items-center gap-2 min-w-0 pr-2">
            @if ($isWinnerA)
                <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500 shrink-0" />
            @else
                <div class="h-1.5 w-1.5 rounded-full bg-neutral-300 dark:bg-neutral-700 shrink-0"></div>
            @endif
            <span
                class="text-xs truncate {{ $isWinnerA ? 'font-bold text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 font-medium' }}"
                title="{{ $series['teamA']['name'] ?? 'TBD' }}"
            >
                {{ $series['teamA']['name'] ?? 'TBD' }}
            </span>
        </div>
        <span class="font-mono text-xs px-1.5 py-0.5 rounded shrink-0 font-bold {{ $isWinnerA ? 'bg-brand-500 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
            {{ $series['gamesWonA'] }}
        </span>
    </div>

    <!-- Team B Row -->
    <div
        @if ($teamBId)
            x-on:mouseenter="hoveredTeamId = '{{ $teamBId }}'"
            x-on:mouseleave="hoveredTeamId = null"
        @endif
        class="flex items-center justify-between px-3 py-2 transition-colors cursor-pointer {{ $isWinnerB ? 'bg-emerald-50/40 dark:bg-emerald-950/15' : 'hover:bg-neutral-50 dark:hover:bg-neutral-800/40' }}"
        :class="hoveredTeamId === '{{ $teamBId }}' ? 'bg-brand-500/15 text-brand-700 dark:text-brand-300 font-bold' : ''"
    >
        <div class="flex items-center gap-2 min-w-0 pr-2">
            @if ($isWinnerB)
                <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500 shrink-0" />
            @else
                <div class="h-1.5 w-1.5 rounded-full bg-neutral-300 dark:bg-neutral-700 shrink-0"></div>
            @endif
            <span
                class="text-xs truncate {{ $isWinnerB ? 'font-bold text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 font-medium' }}"
                title="{{ $series['teamB']['name'] ?? 'TBD' }}"
            >
                {{ $series['teamB']['name'] ?? 'TBD' }}
            </span>
        </div>
        <span class="font-mono text-xs px-1.5 py-0.5 rounded shrink-0 font-bold {{ $isWinnerB ? 'bg-brand-500 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
            {{ $series['gamesWonB'] }}
        </span>
    </div>
</div>
