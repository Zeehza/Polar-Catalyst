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
    class="w-full min-w-0 rounded-xl border transition-all shadow-2xs overflow-hidden flex flex-col"
    :class="(hoveredTeamId && (hoveredTeamId === '{{ $teamAId }}' || hoveredTeamId === '{{ $teamBId }}'))
        ? 'border-brand-500 ring-2 ring-brand-500/20 bg-white dark:bg-neutral-900'
        : 'border-neutral-200/80 dark:border-neutral-800 bg-white dark:bg-neutral-900/90 hover:border-neutral-300 dark:hover:border-neutral-700'"
>
    <!-- Match Header -->
    <div class="px-2.5 py-1 bg-neutral-50/80 dark:bg-neutral-950/70 border-b border-neutral-200/80 dark:border-neutral-800 flex items-center justify-between text-[10px] md:text-[11px] font-semibold text-neutral-500 dark:text-neutral-400">
        <div class="flex items-center gap-1 min-w-0 truncate">
            <span class="font-mono font-bold text-neutral-700 dark:text-neutral-300 shrink-0">
                M{{ $series['matchOrder'] }}
            </span>
            @if ($customLabel)
                <span class="text-neutral-400 truncate">&bull; {{ $customLabel }}</span>
            @endif
        </div>
        <div class="shrink-0">
            @if ($series['status'] === 'COMPLETED')
                <span class="text-[9px] md:text-[10px] px-1.5 py-0.5 rounded-md bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 font-bold">
                    Selesai
                </span>
            @elseif ($series['status'] === 'ONGOING')
                <span class="text-[9px] md:text-[10px] px-1.5 py-0.5 rounded-md bg-red-500/10 text-red-600 dark:text-red-400 font-bold flex items-center gap-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Live
                </span>
            @else
                <span class="text-[9px] md:text-[10px] text-neutral-400 flex items-center gap-1 font-medium">
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
        class="flex items-center justify-between px-2.5 py-1.5 transition-colors cursor-pointer border-b border-neutral-100 dark:border-neutral-800/60 {{ $isWinnerA ? 'bg-brand-500/10 dark:bg-brand-500/15' : 'hover:bg-neutral-50 dark:hover:bg-neutral-800/40' }}"
        :class="hoveredTeamId === '{{ $teamAId }}' ? 'bg-brand-500/15 text-brand-700 dark:text-brand-300 font-bold' : ''"
    >
        <div class="flex items-center gap-1.5 min-w-0 pr-1.5">
            <div class="w-4 h-4 md:w-5 md:h-5 rounded bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center shrink-0 text-[8px] md:text-[9px] font-black {{ $isWinnerA ? 'text-brand-600 dark:text-brand-400' : 'text-neutral-400' }}">
                @if (!empty($series['teamA']['logoUrl']))
                    <img src="{{ $series['teamA']['logoUrl'] }}" alt="{{ $series['teamA']['name'] ?? 'TBD' }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                @else
                    {{ strtoupper(substr($series['teamA']['name'] ?? 'T', 0, 2)) }}
                @endif
            </div>
            <span
                class="text-[11px] md:text-xs truncate {{ $isWinnerA ? 'font-bold text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 font-medium' }}"
                title="{{ $series['teamA']['name'] ?? 'TBD' }}"
            >
                {{ $series['teamA']['name'] ?? 'TBD' }}
            </span>
            @if ($isWinnerA)
                <x-lucide-trophy class="h-3 w-3 text-amber-500 shrink-0" />
            @endif
        </div>
        <span class="font-mono text-[11px] md:text-xs px-1.5 py-0.5 rounded-md shrink-0 font-bold tabular-nums {{ $isWinnerA ? 'bg-brand-500 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
            {{ $series['gamesWonA'] }}
        </span>
    </div>

    <!-- Team B Row -->
    <div
        @if ($teamBId)
            x-on:mouseenter="hoveredTeamId = '{{ $teamBId }}'"
            x-on:mouseleave="hoveredTeamId = null"
        @endif
        class="flex items-center justify-between px-2.5 py-1.5 transition-colors cursor-pointer {{ $isWinnerB ? 'bg-brand-500/10 dark:bg-brand-500/15' : 'hover:bg-neutral-50 dark:hover:bg-neutral-800/40' }}"
        :class="hoveredTeamId === '{{ $teamBId }}' ? 'bg-brand-500/15 text-brand-700 dark:text-brand-300 font-bold' : ''"
    >
        <div class="flex items-center gap-1.5 min-w-0 pr-1.5">
            <div class="w-4 h-4 md:w-5 md:h-5 rounded bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center shrink-0 text-[8px] md:text-[9px] font-black {{ $isWinnerB ? 'text-brand-600 dark:text-brand-400' : 'text-neutral-400' }}">
                @if (!empty($series['teamB']['logoUrl']))
                    <img src="{{ $series['teamB']['logoUrl'] }}" alt="{{ $series['teamB']['name'] ?? 'TBD' }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                @else
                    {{ strtoupper(substr($series['teamB']['name'] ?? 'T', 0, 2)) }}
                @endif
            </div>
            <span
                class="text-[11px] md:text-xs truncate {{ $isWinnerB ? 'font-bold text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 font-medium' }}"
                title="{{ $series['teamB']['name'] ?? 'TBD' }}"
            >
                {{ $series['teamB']['name'] ?? 'TBD' }}
            </span>
            @if ($isWinnerB)
                <x-lucide-trophy class="h-3 w-3 text-amber-500 shrink-0" />
            @endif
        </div>
        <span class="font-mono text-[11px] md:text-xs px-1.5 py-0.5 rounded-md shrink-0 font-bold tabular-nums {{ $isWinnerB ? 'bg-brand-500 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
            {{ $series['gamesWonB'] }}
        </span>
    </div>
</div>
