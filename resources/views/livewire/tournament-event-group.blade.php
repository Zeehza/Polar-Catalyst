@if ($activeSeason)
<div class="flex flex-col gap-6 bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm overflow-hidden transition-all">
    <!-- Tournament Parent Header -->
    <div class="p-6 md:p-8 bg-linear-to-r from-neutral-50 via-white to-neutral-50/50 dark:from-neutral-950 dark:via-neutral-900 dark:to-neutral-950 border-b border-neutral-200 dark:border-neutral-800">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2.5 mb-2.5">
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400 bg-brand-500/10 px-3 py-1 rounded-full border border-brand-500/20 flex items-center gap-1.5">
                        <x-lucide-map-pin class="h-3 w-3" />
                        {{ $game }}
                    </span>
                    <span class="text-xs text-neutral-500 font-medium">
                        {{ $seasons->count() }} {{ $seasons->count() > 1 ? 'Seasons' : 'Season' }}
                    </span>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                    {{ $tournamentName }}
                </h2>
                @if ($activeSeason->description)
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-2 max-w-2xl leading-relaxed">
                        {{ $activeSeason->description }}
                    </p>
                @endif
            </div>

            <!-- Season Selector Tabs -->
            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                    Pilih Season
                </span>
                <div class="inline-flex flex-wrap p-1.5 bg-neutral-100 dark:bg-neutral-800/80 rounded-2xl border border-neutral-200/60 dark:border-neutral-700/60 gap-1.5 shadow-inner">
                    @foreach ($seasons as $s)
                        @php $isSelected = $s->id === $activeSeason->id; @endphp
                        <button
                            type="button"
                            wire:click="selectSeason('{{ $s->id }}')"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all cursor-pointer {{ $isSelected ? 'bg-white dark:bg-neutral-900 text-neutral-950 dark:text-white shadow-sm ring-1 ring-neutral-200 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-200/50 dark:hover:bg-neutral-700/50' }}"
                        >
                            <span>{{ $s->season }}</span>
                            @if ($s->status === 'ONGOING')
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                            @endif
                            @if ($s->status === 'COMPLETED')
                                <span class="text-[10px] font-semibold text-neutral-400 dark:text-neutral-500">
                                    (Selesai)
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Active Season Sub-bar -->
        <div class="mt-6 pt-5 border-t border-neutral-200/70 dark:border-neutral-800/70 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $activeSeason->status === 'ONGOING' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($activeSeason->status === 'UPCOMING' ? 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' : 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300') }}">
                    {{ $activeSeason->status === 'ONGOING' ? 'Live' : $activeSeason->status }}
                </span>
                <span class="text-xs font-semibold text-neutral-600 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-800 px-3 py-1 rounded-full">
                    Format: {{ $activeSeason->type === 'GROUP_STAGE' ? 'Group Stage' : 'Playoff' }}
                </span>
            </div>

            <div class="flex items-center gap-2 text-xs md:text-sm font-medium text-neutral-600 dark:text-neutral-400 bg-white dark:bg-neutral-950 px-3.5 py-1.5 rounded-lg border border-neutral-200/60 dark:border-neutral-800 shadow-2xs">
                <x-lucide-clock class="h-4 w-4 text-brand-500" />
                <span>
                    {{ $activeSeason->startDate ? $activeSeason->startDate->translatedFormat('d M Y') : '' }}
                    @if ($activeSeason->endDate)
                        - {{ $activeSeason->endDate->translatedFormat('d M Y') }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Season Body Content -->
    <div class="p-6 md:p-8 pt-0 flex flex-col gap-8">
        <!-- Teams List (MPL Style Shields) -->
        @if (count($displayTeams) > 0)
            <div class="flex flex-col gap-6 py-6 border-b border-neutral-200 dark:border-neutral-800">
                <div class="flex items-center justify-between">
                    <h3
                        class="text-xl md:text-2xl font-black text-neutral-900 dark:text-white uppercase tracking-[0.15em] opacity-80"
                        style="font-family: Impact, 'Arial Black', sans-serif;"
                    >
                        {{ $activeSeason->type === 'GROUP_STAGE' ? 'TOP TEAMS • ' . $activeSeason->season : 'TIM PESERTA • ' . $activeSeason->season }}
                    </h3>
                    <span class="text-xs font-medium text-neutral-400">
                        {{ count($displayTeams) }} Tim
                    </span>
                </div>

                <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                    @foreach ($displayTeams as $team)
                        <div class="relative w-24 md:w-30 flex flex-col items-center group transition-transform hover:-translate-y-1">
                            <!-- Shield Shape -->
                            <div
                                class="w-full aspect-3/5 bg-white hover:bg-neutral-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 shadow-md border-b-4 border-brand-800 flex flex-col items-center relative overflow-hidden transition-colors"
                                style="clip-path: polygon(0 0, 100% 0, 100% 75%, 50% 100%, 0 75%);"
                            >
                                <div class="w-full h-7 md:h-8 bg-[#7a1818] flex items-center justify-center text-[10px] md:text-xs font-bold text-white uppercase tracking-wider px-1 text-center leading-tight">
                                    {{ $team->name }}
                                </div>
                                <div class="flex-1 w-full flex items-center justify-center p-2 pb-6">
                                    @if ($team->logoUrl)
                                        <img
                                            src="{{ $team->logoUrl }}"
                                            alt="{{ $team->name }}"
                                            class="w-full h-full object-contain filter drop-shadow-sm"
                                        />
                                    @else
                                        <div class="text-4xl font-black text-neutral-200 dark:text-neutral-800 opacity-50">
                                            ?
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Toggle between Schedule and Bracket if Playoff and has matches -->
        @if ($activeSeason->type === 'PLAYOFF' && $activeSeason->matches->count() > 0)
            <div class="flex items-center justify-between pb-2 border-b border-neutral-200 dark:border-neutral-800">
                <div class="inline-flex p-1 bg-neutral-100 dark:bg-neutral-800/80 rounded-2xl border border-neutral-200/60 dark:border-neutral-700/60 gap-1 shadow-inner">
                    <button
                        type="button"
                        wire:click="setEventView('schedule')"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all cursor-pointer {{ $eventView === 'schedule' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-sm ring-1 ring-neutral-200 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                    >
                        <x-lucide-clock class="h-4 w-4" />
                        Jadwal Pertandingan
                    </button>
                    <button
                        type="button"
                        wire:click="setEventView('bracket')"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all cursor-pointer {{ $eventView === 'bracket' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-sm ring-1 ring-neutral-200 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                    >
                        <x-lucide-git-commit class="h-4 w-4" />
                        Bagan Bracket
                    </button>
                </div>
            </div>
        @endif

        <!-- Content: Bracket View or Schedule Cards -->
        @if ($activeSeason->type === 'PLAYOFF' && $eventView === 'bracket')
            <div class="w-full">
                <x-tournament-bracket
                    :matches="$activeSeason->matches"
                    :tournamentName="$tournamentName . ' - ' . $activeSeason->season"
                />
            </div>
        @else
            @if ($upcomingMatches->isEmpty())
                <div class="text-center py-12 bg-neutral-50 dark:bg-neutral-950/50 rounded-2xl border border-dashed border-neutral-300 dark:border-neutral-700">
                    @if ($activeSeason->status === 'COMPLETED')
                        <div class="flex flex-col items-center gap-3">
                            <x-lucide-trophy class="h-8 w-8 text-yellow-500 opacity-80" />
                            <p class="text-neutral-700 dark:text-neutral-300 font-semibold">
                                Pertandingan {{ $activeSeason->season }} telah selesai diselenggarakan!
                            </p>
                            <a
                                href="{{ route('results') }}"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 dark:text-brand-400 hover:underline mt-1"
                            >
                                Lihat Hasil Juara & Leaderboard di Page Results <x-lucide-arrow-right class="h-3.5 w-3.5" />
                            </a>
                        </div>
                    @else
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                            Belum ada jadwal match berikutnya untuk {{ $activeSeason->season }}.
                        </p>
                    @endif
                </div>
            @else
                <div class="flex flex-col gap-4">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Jadwal Pertandingan ({{ $activeSeason->season }})
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($upcomingMatches as $match)
                            <div class="group flex flex-col p-5 bg-neutral-50/70 dark:bg-neutral-950/60 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-xs hover:shadow-md hover:border-brand-300 dark:hover:border-brand-700 transition-all">
                                <div class="flex justify-between items-center mb-4 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">
                                        Match {{ $match->matchOrder }} • Game {{ $match->roundNumber }}
                                    </span>
                                    <div class="flex items-center gap-1.5 text-brand-600 dark:text-brand-400 font-semibold">
                                        <x-lucide-clock class="h-3.5 w-3.5" />
                                        <span>
                                            {{ $match->scheduledAt ? $match->scheduledAt->translatedFormat('d M • H:i') : 'TBA' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2.5">
                                    <!-- Team A -->
                                    <div class="flex items-center justify-between p-3 rounded-xl border {{ $match->winnerId === $match->teamAId ? 'bg-brand-50/80 dark:bg-brand-900/20 border-brand-200 dark:border-brand-800' : 'bg-white dark:bg-neutral-900 border-neutral-200/60 dark:border-neutral-800' }}">
                                        <span class="font-semibold text-sm {{ $match->winnerId === $match->teamAId ? 'text-brand-700 dark:text-brand-300 font-bold' : 'text-neutral-700 dark:text-neutral-300' }}">
                                            {{ $match->teamA?->name ?? 'TBD' }}
                                        </span>
                                        <span class="font-extrabold text-lg text-neutral-900 dark:text-white">
                                            {{ $match->scoreA !== null ? $match->scoreA : '-' }}
                                        </span>
                                    </div>

                                    <!-- Team B -->
                                    <div class="flex items-center justify-between p-3 rounded-xl border {{ $match->winnerId === $match->teamBId ? 'bg-brand-50/80 dark:bg-brand-900/20 border-brand-200 dark:border-brand-800' : 'bg-white dark:bg-neutral-900 border-neutral-200/60 dark:border-neutral-800' }}">
                                        <span class="font-semibold text-sm {{ $match->winnerId === $match->teamBId ? 'text-brand-700 dark:text-brand-300 font-bold' : 'text-neutral-700 dark:text-neutral-300' }}">
                                            {{ $match->teamB?->name ?? 'TBD' }}
                                        </span>
                                        <span class="font-extrabold text-lg text-neutral-900 dark:text-white">
                                            {{ $match->scoreB !== null ? $match->scoreB : '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-between items-center pt-3 border-t border-neutral-200/60 dark:border-neutral-800">
                                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-md {{ $match->status === 'COMPLETED' ? 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300' : ($match->status === 'ONGOING' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400') }}">
                                        {{ $match->status }}
                                    </span>

                                    @if ($match->status === 'COMPLETED' && $match->winner)
                                        <span class="text-xs font-medium text-neutral-500 flex items-center gap-1">
                                            Pemenang: <span class="font-bold text-brand-600 dark:text-brand-400">{{ $match->winner->name }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endif
