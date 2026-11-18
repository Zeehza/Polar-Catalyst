<div>
@if ($activeSeason)
<div class="flex flex-col bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm p-6 md:p-8 transition-all gap-8">
    <!-- Tournament Header with Season Switcher -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-neutral-200/80 dark:border-neutral-800">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400 bg-brand-500/10 border border-brand-500/20">
                    {{ $game }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $activeSeason->status === 'ONGOING' ? 'bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20' : 'bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20' }}">
                    @if ($activeSeason->status === 'ONGOING')
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        <span>LIVE NOW</span>
                    @else
                        <span>SELESAI</span>
                    @endif
                </span>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400">
                    {{ $activeSeason->type === 'GROUP_STAGE' ? 'Group Stage' : 'Playoff Bracket' }}
                </span>
            </div>

            <h2 class="text-2xl md:text-3xl font-black text-neutral-900 dark:text-white tracking-tight">
                {{ $tournamentName }}
            </h2>
        </div>

        <!-- Season Selector Tabs (Segmented Control) -->
        @if ($seasons->count() > 1)
            <div class="flex flex-col sm:items-end gap-1.5 shrink-0">
                <div class="inline-flex p-1 bg-neutral-200/60 dark:bg-neutral-800 rounded-2xl border border-neutral-300/40 dark:border-neutral-700/60 gap-1">
                    @foreach ($seasons as $s)
                        @php $isSelected = $s->id === $activeSeason->id; @endphp
                        <button
                            type="button"
                            wire:click="selectSeason('{{ $s->id }}')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $isSelected ? 'bg-white dark:bg-neutral-900 text-neutral-950 dark:text-white shadow-xs' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                        >
                            <span>{{ $s->season }}</span>
                            @if ($s->status === 'ONGOING')
                                <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if ($activeSeason->status === 'COMPLETED' && count($leaderboard) > 0)
        <!-- Championship Podium Showcase -->
        <div class="flex flex-col items-center py-2 w-full">
            <div class="flex justify-center items-end gap-3 sm:gap-6 pt-6 w-full max-w-2xl border-b-2 border-neutral-200/80 dark:border-neutral-800 pb-0">
                <!-- 2nd Place (Silver) -->
                @if (isset($leaderboard[1]))
                    <div class="flex flex-col items-center w-1/3 max-w-36 pb-0 group">
                        <div class="inline-flex p-1.5 rounded-xl bg-slate-500/10 text-slate-500 dark:text-slate-400 border border-slate-500/20 mb-2">
                            <x-lucide-medal class="h-4 w-4" />
                        </div>
                        <div class="w-14 h-14 sm:w-18 sm:h-18 rounded-2xl p-1 bg-white dark:bg-neutral-900 border-2 border-slate-400/50 shadow-sm flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                            @if ($leaderboard[1]['logoUrl'])
                                <img src="{{ $leaderboard[1]['logoUrl'] }}" alt="{{ $leaderboard[1]['name'] }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                            @else
                                <span class="font-black text-sm text-slate-500 dark:text-slate-300">
                                    {{ strtoupper(substr($leaderboard[1]['name'], 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <div class="text-center font-bold text-xs sm:text-sm text-neutral-800 dark:text-neutral-200 truncate w-full px-1">
                            {{ $leaderboard[1]['name'] }}
                        </div>
                        <span class="inline-block mt-1 mb-2 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 tabular-nums">
                            {{ round($leaderboard[1]['winRate']) }}% WR
                        </span>
                        <div class="w-full h-18 sm:h-22 bg-linear-to-t from-slate-300/80 to-slate-200/40 dark:from-slate-800/80 dark:to-slate-800/30 rounded-t-2xl border border-b-0 border-slate-300 dark:border-slate-700 flex justify-center items-center shadow-xs">
                            <span class="font-black text-2xl sm:text-3xl text-slate-500/50 dark:text-slate-400/30">2</span>
                        </div>
                    </div>
                @endif

                <!-- 1st Place (Gold / Champion) -->
                @if (isset($leaderboard[0]))
                    <div class="flex flex-col items-center w-1/3 max-w-44 z-10 pb-0 group">
                        <div class="inline-flex p-2 rounded-2xl bg-amber-500/15 text-amber-500 border border-amber-500/30 mb-2 shadow-sm animate-bounce" style="animation-duration: 2.5s;">
                            <x-lucide-trophy class="h-5 w-5" />
                        </div>
                        <div class="w-18 h-18 sm:w-24 sm:h-24 rounded-2xl p-1 bg-white dark:bg-neutral-900 border-2 border-amber-400 shadow-md ring-4 ring-amber-400/20 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                            @if ($leaderboard[0]['logoUrl'])
                                <img src="{{ $leaderboard[0]['logoUrl'] }}" alt="{{ $leaderboard[0]['name'] }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                            @else
                                <span class="font-black text-lg sm:text-xl text-amber-500">
                                    {{ strtoupper(substr($leaderboard[0]['name'], 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <div class="text-center font-black text-sm sm:text-base text-brand-600 dark:text-brand-400 truncate w-full px-1">
                            {{ $leaderboard[0]['name'] }}
                        </div>
                        <span class="inline-flex items-center gap-1 mt-1 mb-2 px-2.5 py-0.5 rounded-md text-[11px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30 tabular-nums">
                            <span>CHAMPION</span>
                            <span>&bull;</span>
                            <span>{{ round($leaderboard[0]['winRate']) }}% WR</span>
                        </span>
                        <div class="w-full h-26 sm:h-32 bg-linear-to-t from-amber-500/30 via-amber-400/20 to-amber-300/10 dark:from-amber-500/25 dark:via-amber-600/15 dark:to-transparent rounded-t-2xl border border-b-0 border-amber-400/50 flex justify-center items-center shadow-md">
                            <span class="font-black text-3xl sm:text-4xl text-amber-500/60 dark:text-amber-400/40">1</span>
                        </div>
                    </div>
                @endif

                <!-- 3rd Place (Bronze) -->
                @if (isset($leaderboard[2]))
                    <div class="flex flex-col items-center w-1/3 max-w-36 pb-0 group">
                        <div class="inline-flex p-1.5 rounded-xl bg-amber-800/10 text-amber-700 dark:text-amber-500 border border-amber-800/20 mb-2">
                            <x-lucide-medal class="h-4 w-4" />
                        </div>
                        <div class="w-14 h-14 sm:w-18 sm:h-18 rounded-2xl p-1 bg-white dark:bg-neutral-900 border-2 border-amber-700/40 shadow-sm flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                            @if ($leaderboard[2]['logoUrl'])
                                <img src="{{ $leaderboard[2]['logoUrl'] }}" alt="{{ $leaderboard[2]['name'] }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                            @else
                                <span class="font-black text-sm text-amber-700 dark:text-amber-500">
                                    {{ strtoupper(substr($leaderboard[2]['name'], 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <div class="text-center font-bold text-xs sm:text-sm text-neutral-800 dark:text-neutral-200 truncate w-full px-1">
                            {{ $leaderboard[2]['name'] }}
                        </div>
                        <span class="inline-block mt-1 mb-2 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100/70 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 tabular-nums">
                            {{ round($leaderboard[2]['winRate']) }}% WR
                        </span>
                        <div class="w-full h-14 sm:h-18 bg-linear-to-t from-amber-800/30 to-amber-700/10 dark:from-amber-900/40 dark:to-amber-950/20 rounded-t-2xl border border-b-0 border-amber-800/30 dark:border-amber-700/40 flex justify-center items-center shadow-xs">
                            <span class="font-black text-2xl sm:text-3xl text-amber-800/40 dark:text-amber-600/30">3</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Details toggle button -->
            <div x-data="{ isOpen: false }" class="flex flex-col items-center w-full mt-6">
                <button
                    type="button"
                    x-on:click="isOpen = !isOpen"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold border border-neutral-200 dark:border-neutral-700 bg-neutral-100 hover:bg-neutral-200/80 dark:bg-neutral-800 dark:hover:bg-neutral-700 text-neutral-800 dark:text-neutral-200 transition-all cursor-pointer shadow-2xs hover:scale-[1.02] active:scale-[0.98]"
                >
                    <span x-text="isOpen ? 'Sembunyikan Klasemen &amp; Bracket' : 'Lihat Klasemen &amp; Detail Match'"></span>
                    <x-lucide-chevron-up class="h-3.5 w-3.5" x-show="isOpen" />
                    <x-lucide-chevron-down class="h-3.5 w-3.5" x-show="!isOpen" />
                </button>

                <div x-show="isOpen" x-cloak class="w-full mt-8 text-left transition-all">
                    @include('partials.tournament-result-details')
                </div>
            </div>
        </div>
    @else
        @include('partials.tournament-result-details')
    @endif
</div>
@endif
</div>
