<div class="flex flex-col gap-8" x-data="{
    infoToastOpen: false,
    matchToastOpen: false,
    teamToastOpen: false,
    init() {
        Livewire.on('hide-toast', (data) => {
            if (data.target === 'info') {
                this.infoToastOpen = true;
                setTimeout(() => this.infoToastOpen = false, 2500);
            } else if (data.target === 'match') {
                this.matchToastOpen = true;
                setTimeout(() => this.matchToastOpen = false, 2500);
            } else if (data.target === 'team') {
                this.teamToastOpen = true;
                setTimeout(() => this.teamToastOpen = false, 2500);
            }
        });
    }
}">
    <!-- Header -->
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a
                    href="{{ route('admin.turnamen') }}"
                    class="p-2 hover:bg-neutral-200 dark:hover:bg-neutral-800 rounded-full transition-colors"
                >
                    <x-lucide-arrow-left class="h-5 w-5" />
                </a>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">
                            {{ $tournament->name }}
                        </h1>
                        <span class="bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-300 font-bold px-2.5 py-0.5 rounded-full text-xs">
                            {{ $tournament->season }}
                        </span>
                    </div>
                    <p class="text-neutral-500 text-sm mt-1">
                        {{ $tournament->game }} • {{ $tournament->slug }}
                    </p>
                </div>
            </div>

            <button
                type="button"
                wire:click="deleteTournament"
                wire:confirm="Yakin ingin menghapus seluruh season turnamen ini? Semua tim dan pertandingan di dalamnya akan ikut terhapus."
                class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors font-medium cursor-pointer"
            >
                <x-lucide-trash-2 class="h-4 w-4" /> Hapus Season
            </button>
        </div>

        <!-- Sibling Seasons Navigation Bar -->
        <div class="flex items-center gap-2 p-3 bg-neutral-100/80 dark:bg-neutral-900/80 border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-x-auto">
            <span class="text-xs font-semibold text-neutral-500 shrink-0">
                Daftar Season Turnamen Ini:
            </span>
            <div class="flex items-center gap-2 shrink-0">
                @foreach ($siblingSeasons as $s)
                    <a
                        href="{{ route('admin.turnamen.detail', $s->id) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $s->id === $tournamentId ? 'bg-brand-500 text-white shadow-xs' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700 border border-neutral-200 dark:border-neutral-700' }}"
                    >
                        <span>{{ $s->season }}</span>
                        @if ($s->status === 'ONGOING')
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        @endif
                        @if ($s->id === $tournamentId)
                            <span class="text-[10px] opacity-75 font-normal">(Aktif)</span>
                        @endif
                    </a>
                @endforeach
                <a
                    href="{{ route('admin.turnamen.baru', ['name' => $tournament->name, 'game' => $tournament->game]) }}"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold bg-white dark:bg-neutral-800 border border-dashed border-brand-400 text-brand-600 dark:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-950 transition-colors"
                >
                    <x-lucide-plus class="h-3 w-3" /> Tambah Season Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Top Section: General Info & Teams -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Info Turnamen -->
        <div class="relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <!-- Toast notification -->
            <div
                x-show="infoToastOpen"
                x-cloak
                class="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg shadow-lg flex items-center gap-1.5 z-50 transition-all"
            >
                <x-lucide-check class="h-4 w-4" />
                <span>{{ $infoToast ?? 'Info turnamen terupdate!' }}</span>
            </div>

            <div>
                <h2 class="text-lg font-bold mb-4 dark:text-white">
                    Info Turnamen & Season
                </h2>
                <form wire:submit.prevent="updateInfo" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Nama Turnamen
                        </label>
                        <input
                            type="text"
                            wire:model="name"
                            required
                            class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none dark:text-white"
                        />
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Label Season
                        </label>
                        <input
                            type="text"
                            wire:model="season"
                            required
                            class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none dark:text-white font-medium"
                        />
                        @error('season') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Status</label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none dark:text-white"
                        >
                            <option value="DRAFT">DRAFT</option>
                            <option value="UPCOMING">UPCOMING</option>
                            <option value="ONGOING">ONGOING</option>
                            <option value="COMPLETED">COMPLETED</option>
                            <option value="CANCELLED">CANCELLED</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Tipe</label>
                        <select
                            wire:model="type"
                            class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none dark:text-white"
                        >
                            <option value="PLAYOFF">Playoff</option>
                            <option value="GROUP_STAGE">Group Stage</option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-brand-500 hover:bg-brand-600 text-white py-2.5 rounded-xl font-medium flex items-center justify-center gap-2 mt-4 cursor-pointer"
                    >
                        <x-lucide-save class="h-4 w-4" /> Update Info
                    </button>
                </form>
            </div>
        </div>

        <!-- Manage Teams -->
        <div class="relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl p-6 shadow-sm flex flex-col h-full">
            <!-- Toast notification for team -->
            <div
                x-show="teamToastOpen"
                x-cloak
                class="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg shadow-lg flex items-center gap-1.5 z-50 transition-all"
            >
                <x-lucide-check class="h-4 w-4" />
                <span>{{ $teamToast ?? 'Logo tim berhasil diperbarui!' }}</span>
            </div>

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold dark:text-white flex items-center gap-2">
                    <x-lucide-users class="h-5 w-5 text-brand-500" /> Tim Peserta
                </h2>
                <span class="bg-neutral-100 dark:bg-neutral-800 px-2 py-1 rounded-md text-xs font-bold">
                    {{ $tournament->teams->count() }}
                </span>
            </div>

            <!-- Add team form -->
            <form wire:submit.prevent="addTeam" class="flex gap-2 mb-4">
                <div class="flex flex-col gap-2 flex-1">
                    <input
                        type="text"
                        wire:model="newTeamName"
                        placeholder="Masukkan nama tim"
                        required
                        class="px-3 py-2 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-lg outline-none text-sm dark:text-white"
                    />
                    <input
                        type="url"
                        wire:model="newTeamLogoUrl"
                        placeholder="URL logo tim (opsional)"
                        class="px-3 py-2 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-lg outline-none text-sm dark:text-white"
                    />
                </div>
                <button
                    type="submit"
                    class="bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 px-3 py-2 rounded-lg hover:opacity-80 transition-opacity flex items-center justify-center self-end h-21.5 cursor-pointer"
                >
                    <x-lucide-plus class="h-4 w-4" />
                </button>
            </form>

            <!-- Teams list -->
            <div class="flex-1 overflow-y-auto max-h-75 border border-neutral-100 dark:border-neutral-800 rounded-xl p-2">
                @if ($tournament->teams->isEmpty())
                    <p class="text-center text-neutral-400 text-sm py-4">Belum ada tim.</p>
                @else
                    <ul class="flex flex-col gap-1">
                        @foreach ($tournament->teams as $team)
                            <li class="px-3 py-2 text-sm bg-neutral-50 dark:bg-neutral-950 rounded-lg dark:text-neutral-300 font-medium flex items-center justify-between group">
                                <div
                                    class="flex items-center gap-2.5 min-w-0 flex-1 pr-2 cursor-pointer hover:opacity-80 transition-opacity"
                                    wire:click="openEditLogoModal('{{ $team->id }}')"
                                    title="Klik untuk upload/ubah logo tim"
                                >
                                    @if ($team->logoUrl)
                                        <img src="{{ $team->logoUrl }}" alt="{{ $team->name }}" loading="lazy" decoding="async" class="w-8 h-8 object-contain rounded-lg bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 shrink-0 p-0.5" />
                                    @else
                                        <div class="w-8 h-8 bg-neutral-200 dark:bg-neutral-800 rounded-lg flex items-center justify-center text-xs font-black text-neutral-500 shrink-0">
                                            {{ strtoupper(substr($team->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <span class="truncate">{{ $team->name }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button
                                        type="button"
                                        wire:click="openEditLogoModal('{{ $team->id }}')"
                                        class="text-xs px-2 py-1 rounded-md text-neutral-500 hover:text-brand-600 hover:bg-neutral-200/60 dark:hover:bg-neutral-800 transition-colors flex items-center gap-1 cursor-pointer"
                                        title="Upload atau ubah link logo"
                                    >
                                        <x-lucide-image class="h-3.5 w-3.5" />
                                        <span class="text-[11px] font-medium hidden sm:inline">{{ $team->logoUrl ? 'Ubah Logo' : 'Upload Logo' }}</span>
                                    </button>

                                    @if ($tournament->type === 'GROUP_STAGE')
                                        <select
                                            wire:change="updateTeamGroup('{{ $team->id }}', $event.target.value)"
                                            class="text-xs px-2 py-1 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-md outline-none"
                                        >
                                            <option value="" {{ !$team->group ? 'selected' : '' }}>No Group</option>
                                            <option value="A" {{ $team->group === 'A' ? 'selected' : '' }}>Grup A</option>
                                            <option value="B" {{ $team->group === 'B' ? 'selected' : '' }}>Grup B</option>
                                            <option value="C" {{ $team->group === 'C' ? 'selected' : '' }}>Grup C</option>
                                            <option value="D" {{ $team->group === 'D' ? 'selected' : '' }}>Grup D</option>
                                        </select>
                                    @endif
                                    <button
                                        type="button"
                                        wire:click="deleteTeam('{{ $team->id }}')"
                                        wire:confirm="Hapus tim {{ $team->name }}?"
                                        class="text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1 hover:bg-red-50 dark:hover:bg-red-900/20 rounded cursor-pointer"
                                        title="Hapus tim"
                                    >
                                        <x-lucide-trash-2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Section: Manage Matches -->
    <div class="flex flex-col gap-6">
        <div class="relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl p-6 shadow-sm">
            <!-- Toast notification for match update -->
            <div
                x-show="matchToastOpen"
                x-cloak
                class="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg shadow-lg flex items-center gap-1.5 z-50 transition-all"
            >
                <x-lucide-check class="h-4 w-4" />
                <span>{{ $matchToast ?? 'Match diperbarui!' }}</span>
            </div>

            <div class="flex flex-col gap-1 mb-6">
                <h2 class="text-xl font-bold dark:text-white flex items-center gap-2">
                    <x-lucide-swords class="h-6 w-6 text-brand-500" /> Match & Game
                </h2>
                <p class="text-xs text-neutral-500">
                    Kelola seri Match dan Game. Diurutkan berdasarkan Match lalu Game (contoh: M1-G1, M1-G2, M2-G1, M2-G2).
                </p>
            </div>

            <!-- Add Match Form -->
            <form wire:submit.prevent="addMatch" class="flex flex-wrap items-end gap-3 p-4 bg-neutral-50 dark:bg-neutral-950 rounded-xl mb-6 border border-neutral-200 dark:border-neutral-800">
                <div class="flex flex-col gap-1 flex-1 min-w-25">
                    <label class="text-xs font-semibold text-neutral-500">Match (M)</label>
                    <input
                        type="number"
                        wire:model="newMatchOrder"
                        required
                        min="1"
                        class="px-3 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 outline-none text-sm dark:text-white"
                    />
                </div>
                <div class="flex flex-col gap-1 flex-1 min-w-25">
                    <label class="text-xs font-semibold text-neutral-500">Game (G)</label>
                    <input
                        type="number"
                        wire:model="newRoundNumber"
                        required
                        min="1"
                        class="px-3 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 outline-none text-sm dark:text-white"
                    />
                </div>
                <div class="flex flex-col gap-1 flex-1 min-w-37.5">
                    <label class="text-xs font-semibold text-neutral-500">Team A</label>
                    <select
                        wire:model="newTeamAId"
                        class="px-3 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 outline-none text-sm dark:text-white"
                    >
                        <option value="">TBD</option>
                        @foreach ($tournament->teams as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1 flex-1 min-w-37.5">
                    <label class="text-xs font-semibold text-neutral-500">Team B</label>
                    <select
                        wire:model="newTeamBId"
                        class="px-3 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 outline-none text-sm dark:text-white"
                    >
                        <option value="">TBD</option>
                        @foreach ($tournament->teams as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1 flex-1 min-w-37.5">
                    <label class="text-xs font-semibold text-neutral-500">Waktu (Opsional)</label>
                    <input
                        type="datetime-local"
                        wire:model="newScheduledAt"
                        class="px-3 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 outline-none text-sm dark:text-white"
                    />
                </div>
                <button
                    type="submit"
                    class="bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 px-4 py-2 rounded-lg hover:opacity-80 transition-opacity font-medium text-sm flex items-center gap-2 cursor-pointer"
                >
                    <x-lucide-plus class="h-4 w-4" /> Add
                </button>
            </form>

            <!-- Matches List -->
            <div class="flex flex-col gap-4">
                @if ($tournament->matches->isEmpty())
                    <p class="text-center text-neutral-400 text-sm py-8">Belum ada jadwal pertandingan.</p>
                @else
                    @foreach ($tournament->matches as $match)
                        @php $mId = (string) $match->id; @endphp
                        <div class="flex items-start gap-2">
                            <div class="w-full p-4 border border-neutral-100 dark:border-neutral-800 rounded-xl bg-white dark:bg-neutral-900 hover:border-brand-300 dark:hover:border-brand-700 transition-colors flex flex-col gap-3 flex-1 min-w-0">
                                <!-- Row 1: Match info + Teams + Scores -->
                                <div class="flex items-center gap-3">
                                    <div class="bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 rounded-lg px-2.5 py-1.5 font-mono text-xs font-bold shrink-0 flex items-center gap-1">
                                        <span class="text-brand-600 dark:text-brand-400">M{{ $match->matchOrder }}</span>
                                        <span class="text-neutral-400">-</span>
                                        <span>G{{ $match->roundNumber }}</span>
                                    </div>

                                    <div class="flex-1 flex items-center gap-2 min-w-0">
                                        <span
                                            class="text-sm font-semibold flex-1 text-right truncate flex items-center justify-end gap-1.5 {{ $match->winnerId === $match->teamAId ? 'text-brand-600 dark:text-brand-400 font-bold' : 'dark:text-white' }}"
                                            title="{{ $match->teamA?->name ?? 'TBD' }}"
                                        >
                                            @if ($match->winnerId === $match->teamAId)
                                                <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500 shrink-0" />
                                            @endif
                                            <span>{{ $match->teamA?->name ?? 'TBD' }}</span>
                                        </span>
                                        <input
                                            type="number"
                                            wire:model="matchScores.{{ $mId }}.scoreA"
                                            placeholder="0"
                                            class="w-11 px-1 py-1 text-center text-sm rounded border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 dark:text-white outline-none shrink-0"
                                        />
                                        <span class="text-neutral-400 font-bold text-xs shrink-0">vs</span>
                                        <input
                                            type="number"
                                            wire:model="matchScores.{{ $mId }}.scoreB"
                                            placeholder="0"
                                            class="w-11 px-1 py-1 text-center text-sm rounded border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 dark:text-white outline-none shrink-0"
                                        />
                                        <span
                                            class="text-sm font-semibold flex-1 truncate flex items-center gap-1.5 {{ $match->winnerId === $match->teamBId ? 'text-brand-600 dark:text-brand-400 font-bold' : 'dark:text-white' }}"
                                            title="{{ $match->teamB?->name ?? 'TBD' }}"
                                        >
                                            <span>{{ $match->teamB?->name ?? 'TBD' }}</span>
                                            @if ($match->winnerId === $match->teamBId)
                                                <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500 shrink-0" />
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <!-- Row 2: Controls (Winner, Schedule, Status, Save) -->
                                <div class="flex flex-wrap items-center justify-between gap-2 pt-3 border-t border-neutral-100 dark:border-neutral-800">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <!-- Winner Selector -->
                                        <div class="flex items-center gap-1.5">
                                            <label class="text-xs text-neutral-500 font-medium hidden sm:inline">Pemenang:</label>
                                            <select
                                                wire:model="matchWinners.{{ $mId }}"
                                                class="px-2.5 py-1.5 text-xs rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 dark:text-white outline-none font-medium cursor-pointer"
                                            >
                                                <option value="AUTO">Otomatis (Berdasarkan Skor)</option>
                                                @if ($match->teamA)
                                                    <option value="{{ $match->teamA->id }}">Pemenang: {{ $match->teamA->name }}</option>
                                                @endif
                                                @if ($match->teamB)
                                                    <option value="{{ $match->teamB->id }}">Pemenang: {{ $match->teamB->name }}</option>
                                                @endif
                                                <option value="NONE">Tanpa Pemenang / Seri</option>
                                            </select>
                                        </div>

                                        <!-- Schedule -->
                                        <input
                                            type="datetime-local"
                                            wire:model="matchSchedules.{{ $mId }}"
                                            title="Waktu (Kosong = TBA)"
                                            class="px-2.5 py-1.5 text-xs rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 dark:text-white outline-none"
                                        />

                                        <!-- Status -->
                                        <select
                                            wire:model="matchStatuses.{{ $mId }}"
                                            class="px-2.5 py-1.5 text-xs rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 dark:text-white outline-none font-medium"
                                        >
                                            <option value="SCHEDULED">SCHEDULED</option>
                                            <option value="ONGOING">ONGOING</option>
                                            <option value="COMPLETED">COMPLETED</option>
                                        </select>
                                    </div>

                                    <button
                                        type="button"
                                        wire:click="updateMatch('{{ $mId }}')"
                                        class="bg-brand-500 hover:bg-brand-600 text-white px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5 text-xs font-semibold shadow-xs cursor-pointer"
                                        title="Simpan Perubahan"
                                    >
                                        <x-lucide-check class="h-3.5 w-3.5" /> Simpan
                                    </button>
                                </div>
                            </div>

                            <button
                                type="button"
                                wire:click="deleteMatch('{{ $mId }}')"
                                wire:confirm="Hapus match M{{ $match->matchOrder }}-G{{ $match->roundNumber }}?"
                                class="pt-4 p-2 text-neutral-400 hover:text-red-500 transition-colors cursor-pointer"
                                title="Hapus Match"
                            >
                                <x-lucide-trash-2 class="h-4 w-4" />
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Team Logo Modal -->
    @if ($editingTeamId)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
            x-data
            x-on:keydown.escape.window="$wire.closeEditLogoModal()"
        >
            <!-- Backdrop -->
            <div class="fixed inset-0" wire:click="closeEditLogoModal"></div>

            <!-- Modal Content -->
            <div class="relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 max-w-md w-full shadow-2xl z-10 flex flex-col gap-5">
                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-neutral-200/80 dark:border-neutral-800">
                    <div class="flex items-center gap-2.5">
                        <div class="p-2 bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl">
                            <x-lucide-image class="h-5 w-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                                Atur Logo Tim
                            </h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Tim: <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $editingTeamName }}</span>
                            </p>
                        </div>
                    </div>
                    <button
                        type="button"
                        wire:click="closeEditLogoModal"
                        class="p-1.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors cursor-pointer"
                    >
                        <x-lucide-x class="h-5 w-5" />
                    </button>
                </div>

                <!-- Preview Area -->
                <div class="flex items-center gap-4 p-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200/80 dark:border-neutral-800 rounded-2xl">
                    <div class="relative w-14 h-14 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                        @php
                            $previewUrl = null;
                            if ($editingTeamLogoFile && method_exists($editingTeamLogoFile, 'temporaryUrl')) {
                                try {
                                    $previewUrl = $editingTeamLogoFile->temporaryUrl();
                                } catch (\Throwable $e) {
                                    $previewUrl = null;
                                }
                            } elseif (!empty($editingTeamLogoUrl)) {
                                $previewUrl = $editingTeamLogoUrl;
                            }
                        @endphp

                        @if ($previewUrl)
                            <img src="{{ $previewUrl }}" alt="Preview" class="w-full h-full object-contain p-1" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                            <div style="display: none;" class="w-full h-full items-center justify-center text-xs text-neutral-400 font-bold">
                                ?
                            </div>
                        @else
                            <span class="text-sm font-black text-neutral-400">
                                {{ strtoupper(substr($editingTeamName, 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    <div class="flex flex-col text-xs">
                        <span class="font-bold text-neutral-900 dark:text-white">Pratinjau Logo</span>
                        <span class="text-neutral-500 dark:text-neutral-400">
                            @if ($previewUrl)
                                Logo siap disimpan.
                            @else
                                Belum ada logo yang ditentukan.
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Form Fields -->
                <form wire:submit.prevent="saveTeamLogo" class="flex flex-col gap-4">
                    <!-- URL Input -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300 flex items-center gap-1.5">
                            <x-lucide-link class="h-3.5 w-3.5 text-neutral-400" />
                            <span>Link URL Logo</span>
                        </label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="editingTeamLogoUrl"
                            placeholder="https://contoh.com/logo-tim.png"
                            class="w-full px-3.5 py-2 text-xs md:text-sm bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none focus:border-brand-500 dark:text-white transition-colors"
                        />
                        <p class="text-[11px] text-neutral-400">
                            Tempel link gambar langsung dari Discord, Imgur, Cloudinary, dsb.
                        </p>
                        @error('editingTeamLogoUrl')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Divider -->
                    <div class="relative flex items-center justify-center my-0.5">
                        <div class="border-t border-neutral-200 dark:border-neutral-800 w-full"></div>
                        <span class="bg-white dark:bg-neutral-900 px-3 text-[10px] font-bold text-neutral-400 uppercase tracking-wider absolute">
                            atau upload file
                        </span>
                    </div>

                    <!-- File Upload Input -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300 flex items-center gap-1.5">
                            <x-lucide-upload class="h-3.5 w-3.5 text-neutral-400" />
                            <span>Unggah File Gambar</span>
                        </label>
                        <input
                            type="file"
                            wire:model="editingTeamLogoFile"
                            accept="image/png,image/jpeg,image/webp,image/svg+xml"
                            class="w-full text-xs text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-500/10 file:text-brand-600 dark:file:text-brand-400 hover:file:bg-brand-500/20 cursor-pointer"
                        />
                        <div wire:loading wire:target="editingTeamLogoFile" class="text-xs text-brand-600 dark:text-brand-400 font-medium flex items-center gap-1.5">
                            <x-lucide-loader-2 class="h-3 w-3 animate-spin" />
                            <span>Mengunggah file...</span>
                        </div>
                        @error('editingTeamLogoFile')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-between pt-3 border-t border-neutral-200/80 dark:border-neutral-800 gap-2 mt-1">
                        <div>
                            @if (!empty($editingTeamLogoUrl) || $tournament->teams->find($editingTeamId)?->logoUrl)
                                <button
                                    type="button"
                                    wire:click="removeTeamLogo('{{ $editingTeamId }}')"
                                    wire:confirm="Hapus logo tim ini?"
                                    class="text-xs text-red-500 hover:text-red-700 font-semibold px-2 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors cursor-pointer"
                                >
                                    Hapus Logo
                                </button>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                wire:click="closeEditLogoModal"
                                class="px-3.5 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-colors cursor-pointer"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-brand-600 hover:bg-brand-500 rounded-xl transition-colors shadow-xs cursor-pointer disabled:opacity-50"
                            >
                                <x-lucide-save class="h-3.5 w-3.5" />
                                <span>Simpan Logo</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
