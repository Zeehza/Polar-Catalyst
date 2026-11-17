@if ($activeSeason)
<div class="flex flex-col gap-8 bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm p-6 md:p-8 transition-all">
    <!-- Tournament Header with Season Switcher -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-neutral-200 dark:border-neutral-800">
        <div>
            <div class="flex items-center gap-2.5 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400 bg-brand-500/10 px-3 py-0.5 rounded-full border border-brand-500/20 flex items-center gap-1.5">
                    <x-lucide-gamepad-2 class="h-3 w-3" />
                    {{ $game }}
                </span>
                <span class="px-3 py-0.5 text-xs font-semibold rounded-full {{ $activeSeason->status === 'ONGOING' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' }}">
                    {{ $activeSeason->status === 'ONGOING' ? 'Live' : 'Selesai' }}
                </span>
            </div>
            <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                {{ $tournamentName }}
            </h2>
        </div>

        <!-- Season Selector Tabs -->
        <div class="flex flex-col sm:items-end gap-1.5 shrink-0">
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
                        @else
                            <span class="text-[10px] font-semibold text-neutral-400 dark:text-neutral-500">
                                (Selesai)
                            </span>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Season Detail Template (Leaderboard & Matches) -->
    @php
        $detailBlock = function() use ($activeSeason, $leaderboard, $groupLeaderboards, $tournamentName) {
    @endphp
        <div class="flex flex-col gap-6 w-full">
            <!-- Switcher Tab View for PLAYOFF tournaments -->
            @if ($activeSeason->type === 'PLAYOFF')
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-neutral-200 dark:border-neutral-800">
                    <div class="inline-flex p-1 bg-neutral-100 dark:bg-neutral-800/80 rounded-2xl border border-neutral-200/60 dark:border-neutral-700/60 gap-1 shadow-inner">
                        <button
                            type="button"
                            wire:click="setPlayoffView('bracket')"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all cursor-pointer {{ $playoffView === 'bracket' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-sm ring-1 ring-neutral-200 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                        >
                            <x-lucide-git-commit class="h-4 w-4" />
                            Bagan Bracket
                        </button>
                        <button
                            type="button"
                            wire:click="setPlayoffView('details')"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all cursor-pointer {{ $playoffView === 'details' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-sm ring-1 ring-neutral-200 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                        >
                            <x-lucide-list-ordered class="h-4 w-4" />
                            Klasemen & Pertandingan
                        </button>
                    </div>
                </div>
            @endif

            @if ($activeSeason->type === 'PLAYOFF' && $playoffView === 'bracket')
                <div class="w-full">
                    <x-tournament-bracket
                        :matches="$activeSeason->matches"
                        :tournamentName="$tournamentName . ' - ' . $activeSeason->season"
                        :championName="$leaderboard[0]['name'] ?? null"
                    />
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 w-full">
                    <!-- LEADERBOARD (Kiri) -->
                    <div class="lg:col-span-7 flex flex-col gap-6">
                        @if ($activeSeason->type === 'GROUP_STAGE')
                            @foreach ($groupLeaderboards as $groupName => $groupLb)
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="h-5 w-1.5 bg-brand-500 rounded-full"></div>
                                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                                            {{ $groupName === 'Tidak Ada Grup' ? 'Belum Masuk Grup' : 'Grup ' . $groupName }}
                                        </h3>
                                    </div>

                                    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm overflow-hidden">
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-sm">
                                                <thead class="bg-neutral-50 dark:bg-neutral-950/50 text-neutral-500 dark:text-neutral-400 font-semibold border-b border-neutral-200 dark:border-neutral-800 text-xs">
                                                    <tr>
                                                        <th class="px-5 py-3">Pos</th>
                                                        <th class="px-5 py-3">Nama Tim</th>
                                                        <th class="px-5 py-3 text-center">P</th>
                                                        <th class="px-5 py-3 text-center">W</th>
                                                        <th class="px-5 py-3 text-center">L</th>
                                                        <th class="px-5 py-3 text-right text-brand-600 dark:text-brand-400">WR</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800/50 text-neutral-700 dark:text-neutral-300">
                                                    @forelse ($groupLb as $idx => $t)
                                                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                                                            <td class="px-5 py-3 font-bold text-neutral-900 dark:text-white">
                                                                @if ($idx === 0)
                                                                    <x-lucide-medal class="h-5 w-5 text-yellow-500" />
                                                                @elseif ($idx === 1)
                                                                    <x-lucide-medal class="h-5 w-5 text-neutral-400" />
                                                                @elseif ($idx === 2)
                                                                    <x-lucide-medal class="h-5 w-5 text-amber-600" />
                                                                @else
                                                                    {{ $idx + 1 }}
                                                                @endif
                                                            </td>
                                                            <td class="px-5 py-3 font-medium">{{ $t['name'] }}</td>
                                                            <td class="px-5 py-3 text-center">{{ $t['played'] }}</td>
                                                            <td class="px-5 py-3 text-center text-green-600 dark:text-green-400 font-medium">{{ $t['wins'] }}</td>
                                                            <td class="px-5 py-3 text-center text-red-600 dark:text-red-400 font-medium">{{ $t['losses'] }}</td>
                                                            <td class="px-5 py-3 text-right font-bold text-base text-brand-600 dark:text-brand-400" title="{{ $t['points'] }} Pts">
                                                                {{ round($t['winRate'], 1) }}%
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="px-5 py-6 text-center text-neutral-500 text-xs">
                                                                Belum ada tim di grup ini.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- PLAYOFF Final Standings --}}
                            <div class="flex items-center gap-2 mb-2 text-xl font-bold text-neutral-900 dark:text-white">
                                <x-lucide-medal class="h-5 w-5 text-brand-500" />
                                <h3>Peringkat Akhir (Final Standings)</h3>
                            </div>

                            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm">
                                        <thead class="bg-neutral-50 dark:bg-neutral-950/50 text-neutral-500 dark:text-neutral-400 font-semibold border-b border-neutral-200 dark:border-neutral-800 text-xs">
                                            <tr>
                                                <th class="px-6 py-4">Pos</th>
                                                <th class="px-6 py-4">Nama Tim</th>
                                                <th class="px-6 py-4 text-center">P</th>
                                                <th class="px-6 py-4 text-center">W</th>
                                                <th class="px-6 py-4 text-center">L</th>
                                                <th class="px-6 py-4 text-right text-brand-600 dark:text-brand-400">WR</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800/50 text-neutral-700 dark:text-neutral-300">
                                            @forelse ($leaderboard as $idx => $t)
                                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                                                    <td class="px-6 py-4 font-bold text-neutral-900 dark:text-white">
                                                        @if ($idx === 0)
                                                            <x-lucide-medal class="h-5 w-5 text-yellow-500" />
                                                        @elseif ($idx === 1)
                                                            <x-lucide-medal class="h-5 w-5 text-neutral-400" />
                                                        @elseif ($idx === 2)
                                                            <x-lucide-medal class="h-5 w-5 text-amber-600" />
                                                        @else
                                                            {{ $idx + 1 }}
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex flex-col">
                                                            <span class="font-semibold text-neutral-900 dark:text-white">
                                                                {{ $t['name'] }}
                                                            </span>
                                                            @if (!empty($t['stageTitle']))
                                                                <span class="text-[11px] font-medium text-brand-600 dark:text-brand-400">
                                                                    {{ $t['stageTitle'] }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">{{ $t['played'] }}</td>
                                                    <td class="px-6 py-4 text-center text-green-600 dark:text-green-400 font-medium">{{ $t['wins'] }}</td>
                                                    <td class="px-6 py-4 text-center text-red-600 dark:text-red-400 font-medium">{{ $t['losses'] }}</td>
                                                    <td class="px-6 py-4 text-right font-bold text-base text-brand-600 dark:text-brand-400" title="{{ $t['points'] }} Pts">
                                                        {{ round($t['winRate'], 1) }}%
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-8 text-center text-neutral-500 text-xs">
                                                        Belum ada tim terdaftar.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- MATCH HISTORY (Kanan) -->
                    <div class="lg:col-span-5 flex flex-col gap-4">
                        <div class="flex items-center gap-2 mb-2 text-xl font-bold text-neutral-900 dark:text-white">
                            <x-lucide-swords class="h-5 w-5 text-brand-500" />
                            <h3>Hasil Pertandingan</h3>
                        </div>

                        <div class="flex flex-col gap-3">
                            @forelse ($activeSeason->matches as $match)
                                <div class="flex flex-col p-4 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 shadow-xs hover:border-brand-300 dark:hover:border-brand-700 transition-colors">
                                    <div class="text-xs text-neutral-400 mb-3 flex justify-between items-center">
                                        <span class="font-semibold text-neutral-700 dark:text-neutral-300">
                                            M{{ $match->matchOrder }}-G{{ $match->roundNumber }}
                                        </span>
                                        @if ($match->playedAt)
                                            <span>{{ $match->playedAt->translatedFormat('d M Y') }}</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <!-- Team A -->
                                        <div class="flex flex-col w-1/3 {{ $match->winnerId === $match->teamAId ? 'font-bold text-brand-600 dark:text-brand-400' : 'text-neutral-600 dark:text-neutral-400' }}">
                                            <span class="text-sm truncate" title="{{ $match->teamA?->name }}">{{ $match->teamA?->name ?? 'TBD' }}</span>
                                        </div>

                                        <!-- Score -->
                                        <div class="flex items-center gap-3 px-3 py-1 bg-neutral-100 dark:bg-neutral-800 rounded-lg font-bold">
                                            <span class="{{ $match->winnerId === $match->teamAId ? 'text-brand-600 dark:text-brand-400' : 'text-neutral-900 dark:text-white' }}">
                                                {{ $match->scoreA !== null ? $match->scoreA : '-' }}
                                            </span>
                                            <span class="text-neutral-400 text-xs">vs</span>
                                            <span class="{{ $match->winnerId === $match->teamBId ? 'text-brand-600 dark:text-brand-400' : 'text-neutral-900 dark:text-white' }}">
                                                {{ $match->scoreB !== null ? $match->scoreB : '-' }}
                                            </span>
                                        </div>

                                        <!-- Team B -->
                                        <div class="flex flex-col w-1/3 text-right {{ $match->winnerId === $match->teamBId ? 'font-bold text-brand-600 dark:text-brand-400' : 'text-neutral-600 dark:text-neutral-400' }}">
                                            <span class="text-sm truncate" title="{{ $match->teamB?->name }}">{{ $match->teamB?->name ?? 'TBD' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 bg-white/50 dark:bg-neutral-900/50 rounded-2xl border border-dashed border-neutral-300 dark:border-neutral-700">
                                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                                        Belum ada hasil pertandingan yang selesai untuk season ini.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @php
        };
    @endphp

    @if ($activeSeason->status === 'COMPLETED')
        <div class="flex flex-col items-center py-4 w-full">
            <!-- Podium for Completed Tournament -->
            <div class="flex justify-center items-end gap-2 md:gap-6 pt-12 md:pt-16 w-full max-w-3xl border-b-2 border-neutral-200 dark:border-neutral-800 pb-0">
                <!-- 2nd Place -->
                @if (isset($leaderboard[1]))
                    <div class="flex flex-col items-center w-1/4 max-w-30 pb-0">
                        @if ($leaderboard[1]['logoUrl'])
                            <img src="{{ $leaderboard[1]['logoUrl'] }}" alt="{{ $leaderboard[1]['name'] }}" class="w-16 h-16 md:w-20 md:h-20 object-contain mb-3 drop-shadow-md" />
                        @else
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-neutral-200 dark:bg-neutral-800 rounded flex items-center justify-center mb-3 text-lg font-bold">?</div>
                        @endif
                        <div class="text-center font-bold text-sm md:text-base text-neutral-800 dark:text-neutral-200 truncate w-full">
                            {{ $leaderboard[1]['name'] }}
                        </div>
                        <span class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 mb-2">
                            {{ round($leaderboard[1]['winRate'], 1) }}% WR ({{ $leaderboard[1]['wins'] }}W - {{ $leaderboard[1]['losses'] }}L)
                        </span>
                        <div class="w-full h-16 md:h-24 bg-neutral-300 dark:bg-neutral-700/80 mt-auto flex justify-center items-start pt-2 rounded-t-xl border border-b-0 border-neutral-400 dark:border-neutral-600">
                            <div class="flex flex-col items-center gap-1">
                                <x-lucide-medal class="h-8 w-8 text-neutral-500 dark:text-neutral-400 drop-shadow-sm" />
                                <span class="font-black text-2xl text-neutral-500/50">2</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 1st Place -->
                @if (isset($leaderboard[0]))
                    <div class="flex flex-col items-center w-1/3 max-w-40 z-10 pb-0">
                        <div class="relative">
                            <x-lucide-trophy class="absolute -top-10 left-1/2 -translate-x-1/2 h-8 w-8 text-yellow-500" />
                            @if ($leaderboard[0]['logoUrl'])
                                <img src="{{ $leaderboard[0]['logoUrl'] }}" alt="{{ $leaderboard[0]['name'] }}" class="w-24 h-24 md:w-32 md:h-32 object-contain mb-3 filter drop-shadow-xl" />
                            @else
                                <div class="w-24 h-24 md:w-32 md:h-32 bg-neutral-200 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-3 text-2xl font-bold">?</div>
                            @endif
                        </div>
                        <div class="text-center font-black text-lg md:text-xl text-brand-600 dark:text-brand-400 truncate w-full">
                            {{ $leaderboard[0]['name'] }}
                        </div>
                        <span class="text-[11px] md:text-xs font-bold text-brand-700 dark:text-brand-300 mb-2 px-2 py-0.5 bg-brand-50 dark:bg-brand-950/60 rounded-full border border-brand-200 dark:border-brand-800">
                            {{ round($leaderboard[0]['winRate'], 1) }}% WR ({{ $leaderboard[0]['wins'] }}W - {{ $leaderboard[0]['losses'] }}L)
                        </span>
                        <div class="w-full h-24 md:h-32 bg-linear-to-t from-brand-600 to-brand-400 mt-auto flex justify-center items-start pt-2 rounded-t-xl shadow-2xl border-t border-brand-300">
                            <div class="flex flex-col items-center gap-1">
                                <x-lucide-medal class="h-10 w-10 text-yellow-300 drop-shadow-md" />
                                <span class="font-black text-3xl text-white/50">1</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 3rd Place -->
                @if (isset($leaderboard[2]))
                    <div class="flex flex-col items-center w-1/4 max-w-30 pb-0">
                        @if ($leaderboard[2]['logoUrl'])
                            <img src="{{ $leaderboard[2]['logoUrl'] }}" alt="{{ $leaderboard[2]['name'] }}" class="w-16 h-16 md:w-20 md:h-20 object-contain mb-3 drop-shadow-md" />
                        @else
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-neutral-200 dark:bg-neutral-800 rounded flex items-center justify-center mb-3 text-lg font-bold">?</div>
                        @endif
                        <div class="text-center font-bold text-sm md:text-base text-neutral-800 dark:text-neutral-200 truncate w-full">
                            {{ $leaderboard[2]['name'] }}
                        </div>
                        <span class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 mb-2">
                            {{ round($leaderboard[2]['winRate'], 1) }}% WR ({{ $leaderboard[2]['wins'] }}W - {{ $leaderboard[2]['losses'] }}L)
                        </span>
                        <div class="w-full h-16 md:h-20 bg-amber-700/60 dark:bg-amber-900/60 mt-auto flex justify-center items-start pt-2 rounded-t-xl border border-b-0 border-amber-600/50 dark:border-amber-700/50">
                            <div class="flex flex-col items-center gap-1">
                                <x-lucide-medal class="h-8 w-8 text-amber-500 drop-shadow-sm" />
                                <span class="font-black text-2xl text-amber-900/30 dark:text-amber-950/50">3</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Toggle details: Leaderboard & Match History using Alpine.js -->
            <div x-data="{ isOpen: false }" class="flex flex-col items-center w-full mt-6">
                <button
                    type="button"
                    @click="isOpen = !isOpen"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-full border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 hover:border-brand-300 dark:hover:border-brand-700 transition-all shadow-sm cursor-pointer"
                >
                    <x-lucide-list-ordered class="h-4 w-4 text-brand-500" />
                    <span x-text="isOpen ? 'Sembunyikan Detail' : 'Lihat Detail'"></span>
                    <x-lucide-chevron-up class="h-4 w-4" x-show="isOpen" />
                    <x-lucide-chevron-down class="h-4 w-4" x-show="!isOpen" />
                </button>

                <div x-show="isOpen" x-cloak class="w-full mt-12 text-left">
                    {!! $detailBlock() !!}
                </div>
            </div>
        </div>
    @else
        {!! $detailBlock() !!}
    @endif
</div>
@endif
