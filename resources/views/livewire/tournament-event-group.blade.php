<div>
@if ($activeSeason)
<div class="flex flex-col bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm overflow-hidden transition-all">
    <!-- Tournament Header -->
    <div class="p-6 md:p-8 bg-neutral-50/70 dark:bg-neutral-950/60 border-b border-neutral-200/80 dark:border-neutral-800">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400 bg-brand-500/10 border border-brand-500/20">
                        <x-lucide-gamepad-2 class="h-3.5 w-3.5" />
                        {{ $game }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $activeSeason->status === 'ONGOING' ? 'bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20' : ($activeSeason->status === 'UPCOMING' ? 'bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20' : 'bg-neutral-200/60 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-400') }}">
                        @if ($activeSeason->status === 'ONGOING')
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                            <span>LIVE</span>
                        @elseif ($activeSeason->status === 'UPCOMING')
                            <span>UPCOMING</span>
                        @else
                            <span>SELESAI</span>
                        @endif
                    </span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-white dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 border border-neutral-200/80 dark:border-neutral-800">
                        {{ $activeSeason->type === 'GROUP_STAGE' ? 'Group Stage' : 'Playoff Bracket' }}
                    </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-black text-neutral-900 dark:text-white tracking-tight">
                    {{ $tournamentName }}
                </h2>

                @if ($activeSeason->startDate)
                    <div class="flex items-center gap-1.5 text-xs text-neutral-500 dark:text-neutral-400 font-medium">
                        <x-lucide-calendar class="h-3.5 w-3.5 text-neutral-400 shrink-0" />
                        <span>
                            {{ $activeSeason->startDate->translatedFormat('d M Y') }}
                            @if ($activeSeason->endDate)
                                &ndash; {{ $activeSeason->endDate->translatedFormat('d M Y') }}
                            @endif
                        </span>
                    </div>
                @endif
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
    </div>

    <!-- Season Body Content -->
    <div x-data="{ eventTab: 'schedule' }" class="p-6 md:p-8 flex flex-col gap-8">
        <!-- Teams Showcase (Modern Esports Tokens) -->
        @if (count($displayTeams) > 0)
            <div class="flex flex-col gap-4 pb-6 border-b border-neutral-200/80 dark:border-neutral-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-lucide-shield class="h-4 w-4 text-brand-500" />
                        <h3 class="text-xs font-black uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ $activeSeason->type === 'GROUP_STAGE' ? 'Top Qualified Teams' : 'Tim Peserta' }}
                        </h3>
                    </div>
                    <span class="text-xs font-bold text-neutral-400">
                        {{ count($displayTeams) }} Tim
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                    @foreach ($displayTeams as $team)
                        <div class="group flex flex-col items-center p-3 rounded-2xl bg-neutral-50/60 dark:bg-neutral-950/40 border border-neutral-200/60 dark:border-neutral-800/80 hover:border-brand-500/40 hover:bg-white dark:hover:bg-neutral-900 hover:shadow-xs transition-all hover:-translate-y-0.5">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center p-1.5 relative overflow-hidden bg-white dark:bg-neutral-900 border border-neutral-200/60 dark:border-neutral-800 shadow-2xs group-hover:scale-105 transition-transform">
                                @if ($team->logoUrl)
                                    <img
                                        src="{{ $team->logoUrl }}"
                                        alt="{{ $team->name }}"
                                        class="w-full h-full object-contain filter drop-shadow-xs"
                                        loading="lazy"
                                        decoding="async"
                                    />
                                @else
                                    <span class="font-black text-xs text-brand-600 dark:text-brand-400 tracking-wider">
                                        {{ strtoupper(substr($team->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                            <span class="mt-2 text-xs font-bold text-neutral-800 dark:text-neutral-200 text-center truncate w-full px-1" title="{{ $team->name }}">
                                {{ $team->name }}
                            </span>
                            @if ($team->group)
                                <span class="text-[10px] font-semibold text-neutral-400">
                                    Grup {{ $team->group }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Toggle between Schedule and Bracket if Playoff and has matches -->
        @if ($activeSeason->type === 'PLAYOFF' && $activeSeason->matches->count() > 0)
            <div class="flex items-center justify-between pb-2 border-b border-neutral-200/80 dark:border-neutral-800">
                <div class="inline-flex p-1 bg-neutral-100 dark:bg-neutral-800 rounded-2xl border border-neutral-200/60 dark:border-neutral-700/60 gap-1">
                    <button
                        type="button"
                        x-on:click="eventTab = 'schedule'"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="eventTab === 'schedule' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs ring-1 ring-neutral-200/80 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white'"
                    >
                        <x-lucide-clock class="h-3.5 w-3.5" />
                        <span>Jadwal Match</span>
                    </button>
                    <button
                        type="button"
                        x-on:click="eventTab = 'bracket'"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="eventTab === 'bracket' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs ring-1 ring-neutral-200/80 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white'"
                    >
                        <x-lucide-git-commit class="h-3.5 w-3.5" />
                        <span>Bagan Bracket</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Content: Bracket View -->
        @if ($activeSeason->type === 'PLAYOFF' && $activeSeason->matches->count() > 0)
            <div x-show="eventTab === 'bracket'" x-cloak class="w-full">
                <x-tournament-bracket
                    :matches="$activeSeason->matches"
                    :tournamentName="$tournamentName . ' - ' . $activeSeason->season"
                />
            </div>
        @endif

        <!-- Content: Schedule Cards / Concluded Banner -->
        <div x-show="eventTab === 'schedule'" class="w-full">
            @if ($upcomingMatches->isEmpty())
                @if ($activeSeason->status === 'COMPLETED')
                    <!-- Concluded Tournament Banner -->
                    <div class="p-6 md:p-8 rounded-2xl bg-linear-to-r from-amber-500/10 via-brand-500/5 to-transparent border border-amber-500/20 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-4 text-center sm:text-left">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-500 flex items-center justify-center shrink-0 border border-amber-500/30">
                                <x-lucide-trophy class="h-6 w-6" />
                            </div>
                            <div>
                                <h4 class="text-base font-black text-neutral-900 dark:text-white">
                                    {{ $tournamentName }} &bull; {{ $activeSeason->season }} Selesai
                                </h4>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Seluruh laga telah tuntas. Cek rekap podium juara dan klasemen lengkap.
                                </p>
                            </div>
                        </div>

                        <a
                            href="{{ route('results') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-neutral-950 text-xs font-bold transition-all shadow-xs hover:scale-[1.02] active:scale-[0.98] shrink-0"
                        >
                            <span>Lihat Podium &amp; Klasemen</span>
                            <x-lucide-arrow-right class="h-4 w-4" />
                        </a>
                    </div>
                @else
                    <div class="text-center py-10 px-4 bg-neutral-50/50 dark:bg-neutral-950/40 rounded-2xl border border-dashed border-neutral-200 dark:border-neutral-800">
                        <x-lucide-clock class="h-8 w-8 text-neutral-400 mx-auto mb-2 opacity-60" />
                        <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                            Jadwal match untuk {{ $activeSeason->season }} akan segera diumumkan.
                        </p>
                    </div>
                @endif
            @else
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-black uppercase tracking-wider text-neutral-500 dark:text-neutral-400 flex items-center gap-2">
                            <x-lucide-swords class="h-3.5 w-3.5 text-brand-500" />
                            <span>Jadwal Pertandingan ({{ $activeSeason->season }})</span>
                        </h4>
                        <span class="text-xs font-medium text-neutral-400">
                            {{ $upcomingMatches->count() }} Match
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($upcomingMatches as $match)
                            <div class="flex flex-col p-4 bg-neutral-50/60 dark:bg-neutral-950/50 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 shadow-2xs hover:border-brand-500/30 transition-all">
                                <div class="flex justify-between items-center mb-3 text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                    <span class="font-mono text-neutral-700 dark:text-neutral-300">
                                        M{{ $match->matchOrder }} &bull; Game {{ $match->roundNumber }}
                                    </span>
                                    <div class="flex items-center gap-1.5 text-brand-600 dark:text-brand-400 text-xs">
                                        <x-lucide-clock class="h-3.5 w-3.5" />
                                        <span>
                                            {{ $match->scheduledAt ? $match->scheduledAt->translatedFormat('d M &bull; H:i') : 'TBA' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <!-- Team A -->
                                    <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl border {{ $match->winnerId === $match->teamAId ? 'bg-brand-500/10 border-brand-500/30 font-bold text-brand-700 dark:text-brand-300' : 'bg-white dark:bg-neutral-900 border-neutral-200/60 dark:border-neutral-800/80 text-neutral-700 dark:text-neutral-300' }}">
                                        <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                            <div class="w-6 h-6 rounded-md bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center shrink-0 text-[10px] font-black text-neutral-500">
                                                @if ($match->teamA?->logoUrl)
                                                    <img src="{{ $match->teamA->logoUrl }}" alt="{{ $match->teamA->name }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                                                @else
                                                    {{ strtoupper(substr($match->teamA?->name ?? 'T', 0, 2)) }}
                                                @endif
                                            </div>
                                            <span class="truncate text-xs md:text-sm {{ $match->winnerId === $match->teamAId ? 'font-black' : 'font-semibold' }}">
                                                {{ $match->teamA?->name ?? 'TBD' }}
                                            </span>
                                        </div>
                                        <span class="font-mono font-black text-sm md:text-base tabular-nums shrink-0">
                                            {{ $match->scoreA !== null ? $match->scoreA : '-' }}
                                        </span>
                                    </div>

                                    <!-- Team B -->
                                    <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl border {{ $match->winnerId === $match->teamBId ? 'bg-brand-500/10 border-brand-500/30 font-bold text-brand-700 dark:text-brand-300' : 'bg-white dark:bg-neutral-900 border-neutral-200/60 dark:border-neutral-800/80 text-neutral-700 dark:text-neutral-300' }}">
                                        <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                            <div class="w-6 h-6 rounded-md bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center shrink-0 text-[10px] font-black text-neutral-500">
                                                @if ($match->teamB?->logoUrl)
                                                    <img src="{{ $match->teamB->logoUrl }}" alt="{{ $match->teamB->name }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                                                @else
                                                    {{ strtoupper(substr($match->teamB?->name ?? 'T', 0, 2)) }}
                                                @endif
                                            </div>
                                            <span class="truncate text-xs md:text-sm {{ $match->winnerId === $match->teamBId ? 'font-black' : 'font-semibold' }}">
                                                {{ $match->teamB?->name ?? 'TBD' }}
                                            </span>
                                        </div>
                                        <span class="font-mono font-black text-sm md:text-base tabular-nums shrink-0">
                                            {{ $match->scoreB !== null ? $match->scoreB : '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-3 pt-2.5 flex justify-between items-center border-t border-neutral-200/60 dark:border-neutral-800 text-[11px]">
                                    <span class="font-bold px-2 py-0.5 rounded-md {{ $match->status === 'COMPLETED' ? 'bg-neutral-200/60 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-400' : ($match->status === 'ONGOING' ? 'bg-red-500/10 text-red-600 dark:text-red-400 font-black' : 'bg-brand-500/10 text-brand-600 dark:text-brand-400') }}">
                                        {{ $match->status === 'ONGOING' ? 'LIVE NOW' : $match->status }}
                                    </span>

                                    @if ($match->status === 'COMPLETED' && $match->winner)
                                        <span class="text-neutral-500 flex items-center gap-1 font-medium">
                                            <x-lucide-trophy class="h-3 w-3 text-amber-500" />
                                            <span>Pemenang:</span>
                                            <span class="font-bold text-neutral-900 dark:text-white">{{ $match->winner->name }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endif
</div>
