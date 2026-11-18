@props([
    'matches' => [],
    'tournamentName' => '',
    'championName' => null,
])

@php
    $bracket = \App\Services\TournamentService::getBracketData($matches);
    $isDoubleElimination = $bracket['isDoubleElimination'];
    $upperRounds = $bracket['upperRounds'];
    $lowerRounds = $bracket['lowerRounds'];
    $grandFinal = $bracket['grandFinal'];
    $singleElimRounds = $bracket['singleElimRounds'];
    $bronzeMatch = $bracket['bronzeMatch'];
@endphp

@if(empty($matches) || count($matches) === 0)
    <div class="flex flex-col items-center justify-center p-10 text-center bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200/80 dark:border-neutral-800">
        <x-lucide-swords class="h-8 w-8 text-neutral-400 mb-2 opacity-60" />
        <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">
            Bagan pertandingan belum tersedia.
        </p>
    </div>
@else
    <div x-data="{ hoveredTeamId: null }" class="flex flex-col gap-5 w-full">
        <!-- Header Info Ribbon -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3.5 bg-neutral-50/80 dark:bg-neutral-950/60 rounded-2xl border border-neutral-200/80 dark:border-neutral-800">
            <div class="flex items-center gap-2 flex-wrap">
                <h4 class="text-xs font-black uppercase tracking-wider text-neutral-900 dark:text-white">
                    Bagan Playoff
                </h4>
                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-neutral-200/60 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400">
                    {{ $isDoubleElimination ? 'Double Elimination' : 'Single Elimination' }}
                </span>
                <span class="text-[11px] text-neutral-400 font-medium hidden sm:inline">
                    &bull; Sorot nama tim untuk highlight alur bagan
                </span>
            </div>

            @if ($championName)
                <div class="flex items-center gap-2 px-3 py-1 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-800 dark:text-amber-300 text-xs font-black self-start sm:self-auto shrink-0 shadow-2xs">
                    <span>Juara: {{ $championName }}</span>
                </div>
            @endif
        </div>

        <!-- Bracket Canvas -->
        <div class="w-full overflow-x-auto lg:overflow-x-visible pb-2 scrollbar-thin">
            @if ($isDoubleElimination)
                {{-- DOUBLE ELIMINATION --}}
                <div class="flex flex-col gap-8 w-full min-w-[680px] lg:min-w-0">
                    <!-- UPPER BRACKET -->
                    <div class="flex flex-col gap-3 w-full">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                            <h5 class="text-xs font-black uppercase tracking-wider text-neutral-700 dark:text-neutral-300">
                                Upper Bracket
                            </h5>
                        </div>

                        <div class="flex items-stretch gap-2.5 sm:gap-3.5 md:gap-4 w-full">
                            @foreach ($upperRounds as $round)
                                <div class="flex-1 min-w-0 flex flex-col gap-2.5">
                                    <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider text-center pb-1 border-b border-neutral-200/80 dark:border-neutral-800 truncate">
                                        {{ $round['title'] }}
                                    </div>
                                    <div class="flex flex-col justify-around gap-3 h-full py-1">
                                        @foreach ($round['series'] as $series)
                                            @include('components.bracket-match-card', ['series' => $series])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            @if ($grandFinal)
                                <div class="flex-1 min-w-0 flex flex-col gap-2.5 pl-2.5 sm:pl-3.5 md:pl-4 border-l border-dashed border-neutral-300 dark:border-neutral-700">
                                    <div class="text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider text-center pb-1 border-b border-amber-400/40 truncate">
                                        <span>Grand Final</span>
                                    </div>
                                    <div class="flex flex-col justify-center gap-3 h-full py-1">
                                        @include('components.bracket-match-card', ['series' => $grandFinal, 'customLabel' => 'Laga Puncak'])
                                        @if (!empty($grandFinal['winnerId']))
                                            @php
                                                $champ = ($grandFinal['teamA']['id'] ?? '') === $grandFinal['winnerId'] ? $grandFinal['teamA']['name'] : ($grandFinal['teamB']['name'] ?? 'TBD');
                                            @endphp
                                            <div class="p-2 bg-linear-to-r from-amber-500/15 via-amber-400/10 to-transparent border border-amber-500/30 rounded-xl text-center">
                                                <span class="text-[9px] font-black uppercase tracking-wider text-amber-700 dark:text-amber-400 block">
                                                    Champion
                                                </span>
                                                <span class="text-xs font-black text-amber-900 dark:text-amber-200 truncate block">
                                                    {{ $champ }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- LOWER BRACKET -->
                    <div class="flex flex-col gap-3 pt-6 border-t border-neutral-200/80 dark:border-neutral-800 w-full">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                            <h5 class="text-xs font-black uppercase tracking-wider text-neutral-700 dark:text-neutral-300">
                                Lower Bracket
                            </h5>
                        </div>

                        <div class="flex items-stretch gap-2.5 sm:gap-3.5 md:gap-4 w-full">
                            @foreach ($lowerRounds as $round)
                                <div class="flex-1 min-w-0 flex flex-col gap-2.5">
                                    <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider text-center pb-1 border-b border-neutral-200/80 dark:border-neutral-800 truncate">
                                        {{ $round['title'] }}
                                    </div>
                                    <div class="flex flex-col justify-around gap-3 h-full py-1">
                                        @foreach ($round['series'] as $series)
                                            @include('components.bracket-match-card', ['series' => $series])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                {{-- SINGLE ELIMINATION --}}
                <div class="flex items-stretch gap-2.5 sm:gap-3.5 md:gap-4 w-full min-w-[600px] lg:min-w-0">
                    @foreach ($singleElimRounds as $round)
                        <div class="flex-1 min-w-0 flex flex-col gap-2.5">
                            <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider text-center pb-1 border-b border-neutral-200/80 dark:border-neutral-800 truncate">
                                {{ $round['title'] }}
                            </div>
                            <div class="flex flex-col justify-around gap-3 h-full py-1">
                                @foreach ($round['series'] as $series)
                                    @include('components.bracket-match-card', ['series' => $series])
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    @if ($bronzeMatch)
                        <div class="flex-1 min-w-0 flex flex-col gap-2.5 pl-2.5 sm:pl-3.5 md:pl-4 border-l border-dashed border-neutral-300 dark:border-neutral-700">
                            <div class="text-[10px] font-black text-amber-700 dark:text-amber-500 uppercase tracking-wider text-center pb-1 border-b border-amber-600/30 truncate">
                                Juara 3
                            </div>
                            <div class="flex flex-col justify-center gap-3 h-full py-1">
                                @include('components.bracket-match-card', ['series' => $bronzeMatch, 'customLabel' => 'Bronze Match'])
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif
