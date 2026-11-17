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
