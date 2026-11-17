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
    <div class="flex flex-col items-center justify-center p-12 text-center bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800">
        <x-lucide-swords class="h-8 w-8 text-neutral-400 mb-3" />
        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
            Belum ada bagan pertandingan yang dapat ditampilkan.
        </p>
    </div>
@else
    <div x-data="{ hoveredTeamId: null }" class="flex flex-col gap-6 w-full">
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-neutral-50 dark:bg-neutral-950 rounded-2xl border border-neutral-200 dark:border-neutral-800">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl shrink-0">
                    <x-lucide-git-commit class="h-5 w-5" />
                </div>
                <div class="flex flex-col gap-0.5">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h4 class="text-base font-bold text-neutral-900 dark:text-white">
                            Bagan Playoff
                        </h4>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700">
                            {{ $isDoubleElimination ? 'Double Elimination' : 'Single Elimination' }}
                        </span>
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Sorot nama tim untuk melihat alur bagan
                    </p>
                </div>
            </div>

            @if ($championName)
                <div class="flex items-center gap-2 px-3.5 py-1.5 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-xl text-amber-900 dark:text-amber-200 text-xs font-bold self-start sm:self-auto shadow-xs shrink-0">
                    <x-lucide-trophy class="h-4 w-4 text-amber-500 shrink-0" />
                    <span>Juara: {{ $championName }}</span>
                </div>
            @endif
        </div>

        <!-- Horizontal Scrollable Bracket Canvas -->
        <div class="w-full overflow-x-auto pb-6 scrollbar-thin">
            @if ($isDoubleElimination)
                {{-- DOUBLE ELIMINATION --}}
                <div class="flex flex-col gap-10 min-w-max pr-6">
                    <!-- UPPER BRACKET -->
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-1 bg-brand-500 rounded-full"></div>
                            <h5 class="text-sm font-bold text-neutral-800 dark:text-neutral-200 uppercase tracking-wider">
                                Upper Bracket
                            </h5>
                        </div>

                        <div class="flex items-stretch gap-8">
                            @foreach ($upperRounds as $round)
                                <div class="flex flex-col gap-3">
                                    <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wider text-center pb-1 border-b border-neutral-200 dark:border-neutral-800">
                                        {{ $round['title'] }}
                                    </div>
                                    <div class="flex flex-col justify-around gap-6 h-full py-2">
                                        @foreach ($round['series'] as $series)
                                            @include('components.bracket-match-card', ['series' => $series])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            @if ($grandFinal)
                                <div class="flex flex-col gap-3 pl-4 border-l border-dashed border-neutral-300 dark:border-neutral-700">
                                    <div class="text-xs font-bold text-brand-600 dark:text-brand-400 uppercase tracking-wider text-center pb-1 border-b border-brand-300 dark:border-brand-700 flex items-center justify-center gap-1.5">
                                        <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500" />
                                        Grand Final
                                    </div>
                                    <div class="flex flex-col justify-center gap-4 h-full py-2">
                                        @include('components.bracket-match-card', ['series' => $grandFinal, 'customLabel' => 'Laga Puncak'])
                                        @if (!empty($grandFinal['winnerId']))
                                            @php
                                                $champ = ($grandFinal['teamA']['id'] ?? '') === $grandFinal['winnerId'] ? $grandFinal['teamA']['name'] : ($grandFinal['teamB']['name'] ?? 'TBD');
                                            @endphp
                                            <div class="p-3 bg-linear-to-r from-amber-50 to-amber-100/60 dark:from-amber-950/40 dark:to-amber-900/20 border border-amber-300 dark:border-amber-800 rounded-xl text-center">
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400 block mb-0.5">
                                                    Tournament Champion
                                                </span>
                                                <span class="text-sm font-black text-amber-900 dark:text-amber-200">
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
                    <div class="flex flex-col gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-800">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-1 bg-amber-500 rounded-full"></div>
                            <h5 class="text-sm font-bold text-neutral-800 dark:text-neutral-200 uppercase tracking-wider">
                                Lower Bracket
                            </h5>
                        </div>

                        <div class="flex items-stretch gap-8">
                            @foreach ($lowerRounds as $round)
                                <div class="flex flex-col gap-3">
                                    <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wider text-center pb-1 border-b border-neutral-200 dark:border-neutral-800">
                                        {{ $round['title'] }}
                                    </div>
                                    <div class="flex flex-col justify-around gap-6 h-full py-2">
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
                <div class="flex items-stretch gap-8 min-w-max pr-6">
                    @foreach ($singleElimRounds as $round)
                        <div class="flex flex-col gap-3">
                            <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wider text-center pb-1 border-b border-neutral-200 dark:border-neutral-800">
                                {{ $round['title'] }}
                            </div>
                            <div class="flex flex-col justify-around gap-6 h-full py-2">
                                @foreach ($round['series'] as $series)
                                    @include('components.bracket-match-card', ['series' => $series])
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    @if ($bronzeMatch)
                        <div class="flex flex-col gap-3 pl-4 border-l border-dashed border-neutral-300 dark:border-neutral-700">
                            <div class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider text-center pb-1 border-b border-amber-300 dark:border-amber-700">
                                Perebutan Juara 3
                            </div>
                            <div class="flex flex-col justify-center gap-4 h-full py-2">
                                @include('components.bracket-match-card', ['series' => $bronzeMatch, 'customLabel' => 'Bronze Match'])
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif
