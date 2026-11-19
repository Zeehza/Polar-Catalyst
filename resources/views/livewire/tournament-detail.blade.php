<div class="flex flex-col gap-8 w-full" x-data="{
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
    @php
        $statusBadgeClass = match($tournament->status) {
            'ONGOING' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border-emerald-500/30',
            'COMPLETED' => 'bg-blue-500/15 text-blue-600 dark:text-blue-400 border-blue-500/30',
            'UPCOMING' => 'bg-purple-500/15 text-purple-600 dark:text-purple-400 border-purple-500/30',
            'CANCELLED' => 'bg-red-500/15 text-red-600 dark:text-red-400 border-red-500/30',
            default => 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border-amber-500/30',
        };
    @endphp

    <!-- Header Section -->
    <div class="flex flex-col gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <a
                    href="{{ route('admin.turnamen') }}"
                    class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-300 hover:text-brand-600 dark:hover:text-brand-400 hover:border-brand-300 dark:hover:border-brand-700 hover:bg-brand-50/50 dark:hover:bg-brand-950/30 transition-all shadow-xs shrink-0"
                    title="Kembali ke Daftar Turnamen"
                >
                    <x-lucide-arrow-left class="h-5 w-5" />
                </a>
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1">
                        <a href="{{ route('admin.turnamen') }}" class="hover:text-brand-500 transition-colors">Turnamen</a>
                        <span>/</span>
                        <span class="text-neutral-700 dark:text-neutral-200 truncate">{{ $tournament->name }}</span>
                    </div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                            {{ $tournament->name }}
                        </h1>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-500/15 text-brand-600 dark:text-brand-300 border border-brand-500/30">
                            {{ $tournament->season }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold border {{ $statusBadgeClass }}">
                            {{ $tournament->status }}
                        </span>
                    </div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-xs md:text-sm mt-1 flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1 font-semibold text-neutral-700 dark:text-neutral-300">
                            <x-lucide-gamepad-2 class="h-3.5 w-3.5 text-brand-500" />
                            {{ $tournament->game }}
                        </span>
                        <span>•</span>
                        <span class="font-mono text-xs text-neutral-400">{{ $tournament->slug }}</span>
                    </p>
                </div>
            </div>

            <button
                type="button"
                wire:click="deleteTournament"
                wire:confirm="Yakin ingin menghapus seluruh season turnamen ini? Semua tim dan pertandingan di dalamnya akan ikut terhapus."
                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-600 hover:text-white hover:bg-red-600 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white border border-red-200 dark:border-red-900/60 rounded-xl transition-all shadow-2xs self-start sm:self-auto cursor-pointer"
            >
                <x-lucide-trash-2 class="h-4 w-4" />
                <span>Hapus Season</span>
            </button>
        </div>

        <!-- Sibling Seasons Navigation Bar -->
        <div class="flex items-center gap-2.5 p-3.5 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl shadow-xs overflow-x-auto">
            <div class="flex items-center gap-1.5 text-xs font-bold text-neutral-500 dark:text-neutral-400 shrink-0 mr-1">
                <x-lucide-layers class="h-4 w-4 text-brand-500" />
                <span>Daftar Season:</span>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @foreach ($siblingSeasons as $s)
                    <a
                        href="{{ route('admin.turnamen.detail', $s->id) }}"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $s->id === $tournamentId ? 'bg-brand-500 text-white shadow-xs' : 'bg-neutral-50 dark:bg-neutral-950 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 border border-neutral-200/80 dark:border-neutral-800' }}"
                    >
                        <span>{{ $s->season }}</span>
                        @if ($s->status === 'ONGOING')
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        @endif
                        @if ($s->id === $tournamentId)
                            <span class="text-[10px] opacity-80 font-normal">(Aktif)</span>
                        @endif
                    </a>
                @endforeach
                <a
                    href="{{ route('admin.turnamen.baru', ['name' => $tournament->name, 'game' => $tournament->game]) }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-neutral-50 dark:bg-neutral-950 border border-dashed border-brand-400/80 text-brand-600 dark:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-950 transition-colors"
                >
                    <x-lucide-plus class="h-3.5 w-3.5" />
                    <span>Tambah Season Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Top Section: General Info & Teams -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8 items-stretch">
        <!-- Info Turnamen Card -->
        <div class="lg:col-span-5 relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 sm:p-7 shadow-xs flex flex-col justify-between">
            <!-- Toast notification for Info -->
            <div
                x-show="infoToastOpen"
                x-cloak
                class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg flex items-center gap-1.5 z-50 transition-all"
            >
                <x-lucide-check class="h-3.5 w-3.5" />
                <span>{{ $infoToast ?? 'Info turnamen terupdate!' }}</span>
            </div>

            <div>
                <div class="flex items-center gap-2 pb-3 mb-5 border-b border-neutral-100 dark:border-neutral-800/80">
                    <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                        <x-lucide-settings-2 class="h-4 w-4" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-neutral-900 dark:text-white uppercase tracking-wider">
                            Info Turnamen &amp; Season
                        </h2>
                    </div>
                </div>

                <form wire:submit.prevent="updateInfo" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                            Nama Turnamen <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                wire:model="name"
                                required
                                class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-sm dark:text-white transition-all font-semibold"
                            />
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                <x-lucide-trophy class="h-4 w-4" />
                            </div>
                        </div>
                        @error('name') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                            Label Season <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                wire:model="season"
                                required
                                class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-sm dark:text-white font-semibold transition-all"
                            />
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                <x-lucide-tag class="h-4 w-4" />
                            </div>
                        </div>
                        @error('season') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Status</label>
                            <div class="relative">
                                <select
                                    wire:model="status"
                                    class="w-full pl-3 pr-8 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm font-semibold dark:text-white transition-all appearance-none"
                                >
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="UPCOMING">UPCOMING</option>
                                    <option value="ONGOING">ONGOING</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                    <option value="CANCELLED">CANCELLED</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-neutral-400">
                                    <x-lucide-arrow-right class="h-3.5 w-3.5 rotate-90" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Tipe / Format</label>
                            <div class="relative">
                                <select
                                    wire:model="type"
                                    class="w-full pl-3 pr-8 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm font-semibold dark:text-white transition-all appearance-none"
                                >
                                    <option value="PLAYOFF">Playoff</option>
                                    <option value="GROUP_STAGE">Group Stage</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-neutral-400">
                                    <x-lucide-arrow-right class="h-3.5 w-3.5 rotate-90" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="w-full bg-brand-500 hover:bg-brand-600 disabled:opacity-50 text-white py-2.5 px-4 rounded-xl font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition-all shadow-xs cursor-pointer"
                        >
                            <x-lucide-save class="h-4 w-4" />
                            <span wire:loading.remove wire:target="updateInfo">Update Info Turnamen</span>
                            <span wire:loading wire:target="updateInfo">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Manage Teams Card -->
        <div class="lg:col-span-7 relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 sm:p-7 shadow-xs flex flex-col justify-between">
            <!-- Toast notification for Team -->
            <div
                x-show="teamToastOpen"
                x-cloak
                class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg flex items-center gap-1.5 z-50 transition-all"
            >
                <x-lucide-check class="h-3.5 w-3.5" />
                <span>{{ $teamToast ?? 'Logo tim berhasil diperbarui!' }}</span>
            </div>

            <div>
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-neutral-100 dark:border-neutral-800/80">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                            <x-lucide-users class="h-4 w-4" />
                        </div>
                        <h2 class="text-sm font-bold text-neutral-900 dark:text-white uppercase tracking-wider">
                            Tim Peserta
                        </h2>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
                        {{ $tournament->teams->count() }} Tim
                    </span>
                </div>

                <!-- Add Team Form -->
                <form wire:submit.prevent="addTeam" class="flex flex-col gap-2.5 mb-4 p-3.5 bg-neutral-50/70 dark:bg-neutral-950/60 border border-neutral-200/80 dark:border-neutral-800/80 rounded-2xl">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <div class="sm:col-span-2">
                            <input
                                type="text"
                                wire:model="newTeamName"
                                placeholder="Nama tim *"
                                required
                                class="w-full px-3.5 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm dark:text-white font-medium"
                            />
                            @error('newTeamName') <span class="text-[11px] text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input
                                type="text"
                                wire:model="newTeamShortName"
                                placeholder="Singkatan (opsional)"
                                maxlength="10"
                                class="w-full px-3.5 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm dark:text-white font-mono uppercase font-bold"
                            />
                            @error('newTeamShortName') <span class="text-[11px] text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <input
                            type="url"
                            wire:model="newTeamLogoUrl"
                            placeholder="URL link logo tim (opsional)"
                            class="flex-1 px-3.5 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm dark:text-white"
                        />
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 hover:bg-neutral-800 dark:hover:bg-neutral-100 px-4 py-2 rounded-xl transition-all flex items-center justify-center gap-1.5 text-xs font-bold shrink-0 cursor-pointer shadow-2xs"
                        >
                            <x-lucide-plus class="h-4 w-4" />
                            <span>Tambah Tim</span>
                        </button>
                    </div>
                </form>

                <!-- Teams List (Clean Scrollable) -->
                <div class="overflow-y-auto max-h-[300px] pr-1 space-y-2">
                    @if ($tournament->teams->isEmpty())
                        <div class="text-center py-8 px-4 rounded-2xl border border-dashed border-neutral-200 dark:border-neutral-800 text-neutral-400">
                            <x-lucide-users class="h-8 w-8 mx-auto mb-2 opacity-40" />
                            <p class="text-xs font-medium">Belum ada tim yang didaftarkan pada turnamen ini.</p>
                        </div>
                    @else
                        @foreach ($tournament->teams as $team)
                            <div class="p-3 bg-neutral-50/80 dark:bg-neutral-950/60 border border-neutral-200/60 dark:border-neutral-800/60 hover:border-brand-500/40 rounded-2xl flex items-center justify-between gap-3 group transition-colors">
                                <div
                                    class="flex items-center gap-3 min-w-0 flex-1 cursor-pointer hover:opacity-85 transition-opacity"
                                    wire:click="openEditLogoModal('{{ $team->id }}')"
                                    title="Klik untuk ubah logo &amp; singkatan tim"
                                >
                                    @if ($team->logoUrl)
                                        <img
                                            src="{{ $team->logoUrl }}"
                                            alt="{{ $team->name }}"
                                            loading="lazy"
                                            decoding="async"
                                            class="w-9 h-9 object-contain rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 shrink-0 p-1 shadow-2xs"
                                        />
                                    @else
                                        <div class="w-9 h-9 bg-neutral-200/80 dark:bg-neutral-800 rounded-xl flex items-center justify-center text-xs font-black text-neutral-600 dark:text-neutral-300 shrink-0">
                                            {{ $team->short_code }}
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="truncate text-xs sm:text-sm font-bold text-neutral-900 dark:text-white">
                                            {{ $team->name }}
                                        </span>
                                        <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black font-mono bg-neutral-200/70 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 shrink-0">
                                            {{ $team->short_code }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <button
                                        type="button"
                                        wire:click="openEditLogoModal('{{ $team->id }}')"
                                        class="text-xs px-2.5 py-1.5 rounded-xl text-neutral-600 dark:text-neutral-400 hover:text-brand-600 dark:hover:text-brand-400 bg-white dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                                        title="Upload atau ubah logo tim"
                                    >
                                        <x-lucide-image class="h-3.5 w-3.5" />
                                        <span class="text-[11px] font-semibold hidden sm:inline">{{ $team->logoUrl ? 'Ubah Logo' : 'Upload Logo' }}</span>
                                    </button>

                                    @if ($tournament->type === 'GROUP_STAGE')
                                        <select
                                            wire:change="updateTeamGroup('{{ $team->id }}', $event.target.value)"
                                            class="text-xs px-2.5 py-1.5 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none font-bold text-neutral-700 dark:text-neutral-300 cursor-pointer shadow-2xs"
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
                                        class="text-neutral-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 p-1.5 rounded-xl transition-colors cursor-pointer"
                                        title="Hapus tim"
                                    >
                                        <x-lucide-trash-2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Manage Matches -->
    <div class="flex flex-col gap-6 w-full">
        <div class="relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-xs">
            <!-- Toast notification for match update -->
            <div
                x-show="matchToastOpen"
                x-cloak
                class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg flex items-center gap-1.5 z-50 transition-all"
            >
                <x-lucide-check class="h-3.5 w-3.5" />
                <span>{{ $matchToast ?? 'Match diperbarui!' }}</span>
            </div>

            <!-- Matches Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 mb-6 border-b border-neutral-100 dark:border-neutral-800/80">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                        <x-lucide-swords class="h-4 w-4" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-neutral-900 dark:text-white uppercase tracking-wider">
                            Jadwal Match &amp; Hasil Game
                        </h2>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">
                            Format M (Match) dan G (Game). Contoh: M1-G1, M1-G2, M2-G1.
                        </p>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700 self-start sm:self-auto">
                    {{ $tournament->matches->count() }} Match
                </span>
            </div>

            <!-- Add Match Form -->
            <form wire:submit.prevent="addMatch" class="p-4 sm:p-5 bg-neutral-50/70 dark:bg-neutral-950/60 rounded-2xl mb-6 border border-neutral-200/80 dark:border-neutral-800/80">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 items-end">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Match (M)</label>
                        <input
                            type="number"
                            wire:model="newMatchOrder"
                            required
                            min="1"
                            class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm font-bold dark:text-white"
                        />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Game (G)</label>
                        <input
                            type="number"
                            wire:model="newRoundNumber"
                            required
                            min="1"
                            class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm font-bold dark:text-white"
                        />
                    </div>
                    <div class="col-span-2 sm:col-span-1 flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Team A</label>
                        <select
                            wire:model="newTeamAId"
                            class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm font-semibold dark:text-white"
                        >
                            <option value="">TBD</option>
                            @foreach ($tournament->teams as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1 flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Team B</label>
                        <select
                            wire:model="newTeamBId"
                            class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs sm:text-sm font-semibold dark:text-white"
                        >
                            <option value="">TBD</option>
                            @foreach ($tournament->teams as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-2 lg:col-span-1 flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">Waktu (Opsional)</label>
                        <input
                            type="datetime-local"
                            wire:model="newScheduledAt"
                            class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none text-xs dark:text-white"
                        />
                    </div>
                    <div class="col-span-2 sm:col-span-1 lg:col-span-1">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="w-full bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 hover:bg-neutral-800 dark:hover:bg-neutral-100 px-4 py-2 rounded-xl font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-all shadow-2xs cursor-pointer"
                        >
                            <x-lucide-plus class="h-4 w-4" />
                            <span>Tambah</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Matches List -->
            <div class="flex flex-col gap-3.5">
                @if ($tournament->matches->isEmpty())
                    <div class="text-center py-10 px-4 rounded-2xl border border-dashed border-neutral-200 dark:border-neutral-800 text-neutral-400">
                        <x-lucide-swords class="h-8 w-8 mx-auto mb-2 opacity-40" />
                        <p class="text-xs font-medium">Belum ada pertandingan pada season ini.</p>
                    </div>
                @else
                    @foreach ($tournament->matches as $match)
                        @php $mId = (string) $match->id; @endphp
                        <div class="p-4 sm:p-5 border border-neutral-200/70 dark:border-neutral-800/80 rounded-2xl bg-neutral-50/50 dark:bg-neutral-950/40 hover:border-brand-500/40 transition-all flex flex-col gap-4 shadow-2xs">
                            <!-- Row 1: Match Order & Teams Matchup -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-800 dark:text-neutral-200 rounded-xl px-3 py-1.5 font-mono text-xs font-black shrink-0 flex items-center gap-1 shadow-2xs">
                                        <span class="text-brand-600 dark:text-brand-400">M{{ $match->matchOrder }}</span>
                                        <span class="text-neutral-400">-</span>
                                        <span>G{{ $match->roundNumber }}</span>
                                    </div>
                                    @if ($match->scheduledAt)
                                        <span class="text-[11px] text-neutral-400 font-medium flex items-center gap-1">
                                            <x-lucide-calendar class="h-3 w-3" />
                                            {{ $match->scheduledAt->format('d M, H:i') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Matchup Scores -->
                                <div class="flex-1 flex items-center justify-center gap-2.5 min-w-0 max-w-xl mx-auto w-full">
                                    <span
                                        class="text-xs sm:text-sm font-bold flex-1 text-right truncate flex items-center justify-end gap-1.5 {{ $match->winnerId === $match->teamAId ? 'text-brand-600 dark:text-brand-400 font-extrabold' : 'text-neutral-900 dark:text-white' }}"
                                        title="{{ $match->teamA?->name ?? 'TBD' }}"
                                    >
                                        @if ($match->winnerId === $match->teamAId)
                                            <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500 shrink-0" />
                                        @endif
                                        <span class="truncate">{{ $match->teamA?->name ?? 'TBD' }}</span>
                                    </span>

                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <input
                                            type="number"
                                            wire:model="matchScores.{{ $mId }}.scoreA"
                                            placeholder="0"
                                            class="w-12 h-9 text-center text-xs sm:text-sm font-black rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 dark:text-white outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 transition-all"
                                        />
                                        <span class="text-neutral-400 font-black text-xs px-1">VS</span>
                                        <input
                                            type="number"
                                            wire:model="matchScores.{{ $mId }}.scoreB"
                                            placeholder="0"
                                            class="w-12 h-9 text-center text-xs sm:text-sm font-black rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 dark:text-white outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 transition-all"
                                        />
                                    </div>

                                    <span
                                        class="text-xs sm:text-sm font-bold flex-1 truncate flex items-center gap-1.5 {{ $match->winnerId === $match->teamBId ? 'text-brand-600 dark:text-brand-400 font-extrabold' : 'text-neutral-900 dark:text-white' }}"
                                        title="{{ $match->teamB?->name ?? 'TBD' }}"
                                    >
                                        <span class="truncate">{{ $match->teamB?->name ?? 'TBD' }}</span>
                                        @if ($match->winnerId === $match->teamBId)
                                            <x-lucide-trophy class="h-3.5 w-3.5 text-amber-500 shrink-0" />
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Row 2: Match Controls Bar -->
                            <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-neutral-200/60 dark:border-neutral-800/60">
                                <div class="flex flex-wrap items-center gap-2">
                                    <!-- Winner Selector -->
                                    <div class="flex items-center gap-1.5">
                                        <label class="text-[11px] font-bold text-neutral-500 hidden sm:inline">Pemenang:</label>
                                        <select
                                            wire:model="matchWinners.{{ $mId }}"
                                            class="px-2.5 py-1.5 text-xs rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 dark:text-white outline-none font-semibold cursor-pointer shadow-2xs"
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

                                    <!-- Schedule Input -->
                                    <input
                                        type="datetime-local"
                                        wire:model="matchSchedules.{{ $mId }}"
                                        title="Jadwal Waktu Match"
                                        class="px-2.5 py-1.5 text-xs rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 dark:text-white outline-none font-medium shadow-2xs"
                                    />

                                    <!-- Status Selector -->
                                    <select
                                        wire:model="matchStatuses.{{ $mId }}"
                                        class="px-2.5 py-1.5 text-xs rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 dark:text-white outline-none font-bold cursor-pointer shadow-2xs"
                                    >
                                        <option value="SCHEDULED">SCHEDULED</option>
                                        <option value="ONGOING">ONGOING</option>
                                        <option value="COMPLETED">COMPLETED</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="updateMatch('{{ $mId }}')"
                                        class="bg-brand-500 hover:bg-brand-600 text-white px-3.5 py-1.5 rounded-xl transition-all flex items-center gap-1.5 text-xs font-bold shadow-2xs cursor-pointer"
                                        title="Simpan Perubahan Match"
                                    >
                                        <x-lucide-check class="h-3.5 w-3.5" />
                                        <span>Simpan</span>
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="deleteMatch('{{ $mId }}')"
                                        wire:confirm="Hapus match M{{ $match->matchOrder }}-G{{ $match->roundNumber }}?"
                                        class="p-1.5 text-neutral-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-xl transition-colors cursor-pointer"
                                        title="Hapus Match"
                                    >
                                        <x-lucide-trash-2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
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
            <div class="relative bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 sm:p-7 max-w-md w-full shadow-2xl z-10 flex flex-col gap-5">
                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-neutral-100 dark:border-neutral-800">
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
                        class="p-1.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-colors cursor-pointer"
                    >
                        <x-lucide-x class="h-5 w-5" />
                    </button>
                </div>

                <!-- Preview Area -->
                <div class="flex items-center gap-4 p-3.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200/80 dark:border-neutral-800 rounded-2xl">
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
                                {{ !empty($editingTeamShortName) ? strtoupper($editingTeamShortName) : strtoupper(substr($editingTeamName, 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    <div class="flex flex-col text-xs">
                        <span class="font-bold text-neutral-900 dark:text-white">Pratinjau Logo</span>
                        <span class="text-neutral-500 dark:text-neutral-400 mt-0.5">
                            @if ($previewUrl)
                                Logo siap disimpan ke sistem.
                            @else
                                Belum ada logo yang ditentukan.
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Form Fields -->
                <form wire:submit.prevent="saveTeamLogo" class="flex flex-col gap-4">
                    <!-- Short Name Input -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <x-lucide-tag class="h-3.5 w-3.5 text-neutral-400" />
                                <span>Nama Singkatan Tim</span>
                            </span>
                            <span class="text-[10px] text-neutral-400 font-normal">Kosong = otomatis</span>
                        </label>
                        <input
                            type="text"
                            wire:model="editingTeamShortName"
                            placeholder="Singkatan tim (opsional)"
                            maxlength="10"
                            class="w-full px-3.5 py-2 text-xs md:text-sm bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none focus:border-brand-500 dark:text-white uppercase font-mono font-semibold transition-colors"
                        />
                        <p class="text-[11px] text-neutral-400">
                            Nama singkatan ini muncul pada banner tim. Jika kosong, sistem otomatis membuat singkatan.
                        </p>
                        @error('editingTeamShortName')
                            <span class="text-xs text-red-500 font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- URL Input -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300 flex items-center gap-1.5">
                            <x-lucide-link class="h-3.5 w-3.5 text-neutral-400" />
                            <span>Link URL Logo</span>
                        </label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="editingTeamLogoUrl"
                            placeholder="https://..."
                            class="w-full px-3.5 py-2 text-xs md:text-sm bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl outline-none focus:border-brand-500 dark:text-white transition-colors"
                        />
                        <p class="text-[11px] text-neutral-400">
                            Tempel link gambar langsung dari Discord, Imgur, dsb.
                        </p>
                        @error('editingTeamLogoUrl')
                            <span class="text-xs text-red-500 font-medium">{{ $message }}</span>
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
                            <span class="text-xs text-red-500 font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-between pt-3 border-t border-neutral-100 dark:border-neutral-800 gap-2 mt-1">
                        <div>
                            @if (!empty($editingTeamLogoUrl) || $tournament->teams->find($editingTeamId)?->logoUrl)
                                <button
                                    type="button"
                                    wire:click="removeTeamLogo('{{ $editingTeamId }}')"
                                    wire:confirm="Hapus logo tim ini?"
                                    class="text-xs text-red-500 hover:text-red-700 font-bold px-2 py-1.5 rounded-xl hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors cursor-pointer"
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
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 rounded-xl transition-colors shadow-xs cursor-pointer disabled:opacity-50"
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