<div x-data="{ playoffTab: 'details' }" class="flex flex-col gap-6 w-full">
    <!-- View Switcher Tab for PLAYOFF tournaments -->
    @if ($activeSeason->type === 'PLAYOFF')
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-neutral-200/80 dark:border-neutral-800">
            <div class="inline-flex p-1 bg-neutral-100 dark:bg-neutral-800 rounded-2xl border border-neutral-200/60 dark:border-neutral-700/60 gap-1">
                <button
                    type="button"
                    x-on:click="playoffTab = 'details'"
                    class="inline-flex items-center px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                    :class="playoffTab === 'details' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs ring-1 ring-neutral-200/80 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white'"
                >
                    <span>Klasemen &amp; Match</span>
                </button>
                <button
                    type="button"
                    x-on:click="playoffTab = 'bracket'"
                    class="inline-flex items-center px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                    :class="playoffTab === 'bracket' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs ring-1 ring-neutral-200/80 dark:ring-neutral-700' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white'"
                >
                    <span>Bagan Bracket</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Playoff Bracket View -->
    @if ($activeSeason->type === 'PLAYOFF')
        <div x-show="playoffTab === 'bracket'" x-cloak class="w-full">
            <x-tournament-bracket
                :matches="$activeSeason->matches"
                :tournamentName="$tournamentName . ' - ' . $activeSeason->season"
                :championName="$leaderboard[0]['name'] ?? null"
            ></x-tournament-bracket>
        </div>
    @endif

    <!-- Standings & Match History View -->
    <div
        @if ($activeSeason->type === 'PLAYOFF')
            x-show="playoffTab === 'details'"
        @endif
        class="w-full"
    >
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 w-full">
            <!-- LEADERBOARD / KLASEMEN (Left) -->
            <div class="lg:col-span-7 flex flex-col gap-5">
                @if ($activeSeason->type === 'GROUP_STAGE')
                    @foreach ($groupLeaderboards as $groupName => $groupLb)
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                                <h3 class="text-xs font-black uppercase tracking-wider text-neutral-800 dark:text-neutral-200">
                                    {{ $groupName === 'Tidak Ada Grup' ? 'Reguler Stage' : 'Grup ' . $groupName }}
                                </h3>
                            </div>

                            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 shadow-2xs overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs">
                                        <thead class="bg-neutral-50/80 dark:bg-neutral-950/60 text-neutral-400 font-bold uppercase tracking-wider border-b border-neutral-200/80 dark:border-neutral-800 text-[10px]">
                                            <tr>
                                                <th class="px-3.5 py-2.5 text-center w-10">#</th>
                                                <th class="px-3.5 py-2.5">Tim</th>
                                                <th class="px-3 py-2.5 text-center w-14">M</th>
                                                <th class="px-3 py-2.5 text-center w-16">W - L</th>
                                                <th class="px-3.5 py-2.5 text-right w-28">Win Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800/60 text-neutral-700 dark:text-neutral-300">
                                            @forelse ($groupLb as $idx => $t)
                                                <tr class="hover:bg-neutral-50/60 dark:hover:bg-neutral-800/40 transition-colors">
                                                    <td class="px-3.5 py-2.5 text-center font-bold">
                                                        @if ($idx === 0)
                                                            <span class="font-mono text-xs text-amber-500 font-black">1</span>
                                                        @elseif ($idx === 1)
                                                            <span class="font-mono text-xs text-slate-400 font-bold">2</span>
                                                        @elseif ($idx === 2)
                                                            <span class="font-mono text-xs text-amber-700 font-bold">3</span>
                                                        @else
                                                            <span class="font-mono text-xs text-neutral-400">{{ $idx + 1 }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3.5 py-2.5">
                                                        <div class="flex items-center gap-2 min-w-0">
                                                            <div class="w-6 h-6 rounded-md bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center shrink-0 text-[10px] font-black text-brand-600 dark:text-brand-400">
                                                                @if ($t['logoUrl'])
                                                                    <img src="{{ $t['logoUrl'] }}" alt="{{ $t['name'] }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                                                                @else
                                                                    {{ strtoupper(substr($t['name'], 0, 2)) }}
                                                                @endif
                                                            </div>
                                                            <span class="font-bold truncate text-neutral-900 dark:text-white">{{ $t['name'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-2.5 text-center font-mono font-medium text-neutral-500 tabular-nums">{{ $t['played'] }}</td>
                                                    <td class="px-3 py-2.5 text-center font-mono tabular-nums">
                                                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $t['wins'] }}</span>
                                                        <span class="text-neutral-300 dark:text-neutral-600 mx-0.5">-</span>
                                                        <span class="text-rose-500 dark:text-rose-400 font-medium">{{ $t['losses'] }}</span>
                                                    </td>
                                                    <td class="px-3.5 py-2.5 text-right">
                                                        <div class="flex items-center justify-end gap-2">
                                                            <div class="w-12 h-1.5 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden shrink-0 hidden sm:block">
                                                                <div class="h-full bg-brand-500 rounded-full" :style="'width: ' + {{ (float) $t['winRate'] }} + '%'"></div>
                                                            </div>
                                                            <span class="font-mono font-bold text-xs text-brand-600 dark:text-brand-400 tabular-nums">
                                                                {{ round($t['winRate']) }}%
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-4 py-8 text-center text-neutral-400 text-xs">
                                                        Belum ada tim terdaftar di grup ini.
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
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-black uppercase tracking-wider text-neutral-700 dark:text-neutral-300">
                            Klasemen Akhir
                        </h3>
                        <span class="text-xs text-neutral-400 font-medium">
                            {{ count($leaderboard) }} Tim
                        </span>
                    </div>

                    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 shadow-2xs overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-neutral-50/80 dark:bg-neutral-950/60 text-neutral-400 font-bold uppercase tracking-wider border-b border-neutral-200/80 dark:border-neutral-800 text-[10px]">
                                    <tr>
                                        <th class="px-3.5 py-3 text-center w-10">#</th>
                                        <th class="px-3.5 py-3">Tim</th>
                                        <th class="px-3 py-3 text-center w-14">M</th>
                                        <th class="px-3 py-3 text-center w-16">W - L</th>
                                        <th class="px-3.5 py-3 text-right w-28">Win Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800/60 text-neutral-700 dark:text-neutral-300">
                                    @forelse ($leaderboard as $idx => $t)
                                        <tr class="hover:bg-neutral-50/60 dark:hover:bg-neutral-800/40 transition-colors">
                                            <td class="px-3.5 py-3 text-center font-bold">
                                                @if ($idx === 0)
                                                    <span class="font-mono text-xs text-amber-500 font-black">1</span>
                                                @elseif ($idx === 1)
                                                    <span class="font-mono text-xs text-slate-400 font-bold">2</span>
                                                @elseif ($idx === 2)
                                                    <span class="font-mono text-xs text-amber-700 font-bold">3</span>
                                                @else
                                                    <span class="font-mono text-xs text-neutral-400">{{ $idx + 1 }}</span>
                                                @endif
                                            </td>
                                            <td class="px-3.5 py-3">
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    <div class="w-6 h-6 rounded-md bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center shrink-0 text-[10px] font-black text-brand-600 dark:text-brand-400">
                                                        @if ($t['logoUrl'])
                                                            <img src="{{ $t['logoUrl'] }}" alt="{{ $t['name'] }}" loading="lazy" decoding="async" class="w-full h-full object-contain" />
                                                        @else
                                                            {{ strtoupper(substr($t['name'], 0, 2)) }}
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="font-bold truncate text-neutral-900 dark:text-white">{{ $t['name'] }}</span>
                                                        @if (!empty($t['stageTitle']))
                                                            <span class="text-[10px] font-semibold text-brand-600 dark:text-brand-400">
                                                                {{ str_replace([' (Champion)', ' (Runner-up)'], '', $t['stageTitle']) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 text-center font-mono font-medium text-neutral-500 tabular-nums">{{ $t['played'] }}</td>
                                            <td class="px-3 py-3 text-center font-mono tabular-nums">
                                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $t['wins'] }}</span>
                                                <span class="text-neutral-300 dark:text-neutral-600 mx-0.5">-</span>
                                                <span class="text-rose-500 dark:text-rose-400 font-medium">{{ $t['losses'] }}</span>
                                            </td>
                                            <td class="px-3.5 py-3 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <div class="w-12 sm:w-16 h-1.5 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden shrink-0 hidden sm:block">
                                                        <div class="h-full bg-brand-500 rounded-full" :style="'width: ' + {{ (float) $t['winRate'] }} + '%'"></div>
                                                    </div>
                                                    <span class="font-mono font-bold text-xs text-brand-600 dark:text-brand-400 tabular-nums">
                                                        {{ round($t['winRate']) }}%
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-8 text-center text-neutral-400 text-xs">
                                                Belum ada data klasemen untuk season ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- MATCH HISTORY / HASIL PERTANDINGAN (Right) -->
            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black uppercase tracking-wider text-neutral-700 dark:text-neutral-300">
                        Riwayat Laga
                    </h3>
                    <span class="text-xs text-neutral-400 font-medium">
                        {{ $activeSeason->matches->count() }} Laga
                    </span>
                </div>

                <div class="flex flex-col gap-2.5 max-h-125 overflow-y-auto pr-1">
                    @forelse ($activeSeason->matches as $match)
                        <div class="flex flex-col p-3 rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200/70 dark:border-neutral-800 shadow-2xs hover:border-brand-500/30 transition-all">
                            <div class="flex items-center justify-between text-[10px] text-neutral-400 mb-2 font-mono">
                                <span class="font-bold text-neutral-600 dark:text-neutral-400">
                                    M{{ $match->matchOrder }}-G{{ $match->roundNumber }}
                                </span>
                                @if ($match->playedAt)
                                    <span>{{ $match->playedAt->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <!-- Team A -->
                                <div class="flex items-center gap-1.5 w-5/12 min-w-0 {{ $match->winnerId === $match->teamAId ? 'font-bold text-neutral-900 dark:text-white' : 'text-neutral-500 dark:text-neutral-400 font-medium' }}">
                                    <span class="truncate text-xs" title="{{ $match->teamA?->name }}">{{ $match->teamA?->name ?? 'TBD' }}</span>
                                </div>

                                <!-- Score Chip -->
                                <div class="flex items-center justify-center px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800/80 font-mono font-black text-xs tabular-nums shrink-0">
                                    <span class="{{ $match->winnerId === $match->teamAId ? 'text-brand-600 dark:text-brand-400' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        {{ $match->scoreA !== null ? $match->scoreA : '-' }}
                                    </span>
                                    <span class="text-neutral-300 dark:text-neutral-600 mx-1">:</span>
                                    <span class="{{ $match->winnerId === $match->teamBId ? 'text-brand-600 dark:text-brand-400' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        {{ $match->scoreB !== null ? $match->scoreB : '-' }}
                                    </span>
                                </div>

                                <!-- Team B -->
                                <div class="flex items-center justify-end gap-1.5 w-5/12 min-w-0 text-right {{ $match->winnerId === $match->teamBId ? 'font-bold text-neutral-900 dark:text-white' : 'text-neutral-500 dark:text-neutral-400 font-medium' }}">
                                    <span class="truncate text-xs" title="{{ $match->teamB?->name }}">{{ $match->teamB?->name ?? 'TBD' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 bg-neutral-50/50 dark:bg-neutral-950/40 rounded-2xl border border-dashed border-neutral-200 dark:border-neutral-800">
                            <p class="text-xs text-neutral-400">
                                Belum ada riwayat laga untuk season ini.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
