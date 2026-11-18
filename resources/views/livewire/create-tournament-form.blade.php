<div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden shadow-sm p-6 md:p-8">
    @if ($errorMessage)
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl flex items-start gap-3">
            <x-lucide-alert-circle class="h-5 w-5 text-red-600 dark:text-red-500 shrink-0 mt-0.5" />
            <p class="text-red-700 dark:text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
        </div>
    @endif

    {{-- Mode selection tabs if there are existing tournaments --}}
    @if (count($existingTournaments) > 0)
        <div class="flex gap-2 p-1.5 bg-neutral-100 dark:bg-neutral-800 rounded-xl mb-6">
            <button
                type="button"
                wire:click="setMode('existing')"
                class="flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-sm font-semibold transition-all cursor-pointer {{ $mode === 'existing' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
            >
                <x-lucide-layers class="h-4 w-4" />
                Tambah Season Turnamen yang Ada
            </button>
            <button
                type="button"
                wire:click="setMode('new')"
                class="flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-sm font-semibold transition-all cursor-pointer {{ $mode === 'new' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
            >
                <x-lucide-sparkles class="h-4 w-4" />
                Buat Turnamen Baru
            </button>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="flex flex-col gap-5">
        @if ($mode === 'existing')
            <div class="flex flex-col gap-2">
                <label for="selectTournament" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Pilih Acara Turnamen *
                </label>
                <select
                    id="selectTournament"
                    wire:model.live="selectedTournamentName"
                    class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                >
                    @foreach ($existingTournaments as $t)
                        <option value="{{ $t['name'] }}">
                            {{ $t['name'] }} ({{ $t['game'] }}) — {{ count($t['seasons']) }} Season ({{ implode(', ', $t['seasons']) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Game
                </label>
                <input
                    type="text"
                    wire:model="game"
                    readonly
                    class="w-full px-4 py-3 bg-neutral-100 dark:bg-neutral-800/60 border border-neutral-200 dark:border-neutral-800 rounded-xl text-neutral-600 dark:text-neutral-400 outline-none cursor-not-allowed font-medium"
                />
            </div>
        @else
            <div class="flex flex-col gap-2">
                <label for="name" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Nama Turnamen *
                </label>
                <input
                    type="text"
                    id="name"
                    wire:model.live="name"
                    required
                    placeholder="Nama turnamen"
                    class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                />
                <p class="text-xs text-neutral-500">
                    Nama tetap acara turnamen esports (nama ini dapat memiliki banyak season di dalamnya).
                </p>
                @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="game" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Game *
                </label>
                <input
                    type="text"
                    id="game"
                    wire:model="game"
                    required
                    placeholder="Nama game"
                    class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                />
                @error('game') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        @endif

        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <label for="season" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Label Season *
                </label>
            </div>
            <input
                type="text"
                id="season"
                wire:model.live="season"
                required
                placeholder="Label season"
                class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-950 border rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white font-medium {{ $isDuplicateSeason ? 'border-amber-500 focus:border-amber-500' : 'border-neutral-200 dark:border-neutral-800' }}"
            />
            @if ($isDuplicateSeason)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl text-amber-700 dark:text-amber-400 text-xs">
                    <div class="flex items-center gap-2 font-medium">
                        <x-lucide-alert-circle class="h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400" />
                        <span>
                            <strong>{{ $season }}</strong> sudah pernah dibuat untuk turnamen ini.
                        </span>
                    </div>
                    <button
                        type="button"
                        wire:click="useSuggestedSeason('{{ $suggestedNextSeason }}')"
                        class="self-start sm:self-auto px-2.5 py-1 bg-amber-200 dark:bg-amber-800/60 hover:bg-amber-300 dark:hover:bg-amber-800 text-amber-900 dark:text-amber-200 font-semibold rounded-lg transition-colors cursor-pointer text-xs"
                    >
                        Gunakan {{ $suggestedNextSeason }}
                    </button>
                </div>
            @endif
            @error('season') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="type" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                Tipe Turnamen
            </label>
            <select
                id="type"
                wire:model="type"
                class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
            >
                <option value="PLAYOFF">Playoff</option>
                <option value="GROUP_STAGE">Group Stage</option>
            </select>
            @error('type') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="startDate" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                Tanggal Mulai *
            </label>
            <input
                type="date"
                id="startDate"
                wire:model="startDate"
                required
                class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
            />
            @error('startDate') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex justify-end">
            <button
                type="submit"
                wire:loading.attr="disabled"
                @if ($isDuplicateSeason) disabled @endif
                class="flex items-center gap-2 bg-brand-500 hover:bg-brand-600 disabled:bg-neutral-300 dark:disabled:bg-neutral-800 disabled:text-neutral-500 disabled:cursor-not-allowed text-white px-6 py-3 rounded-xl font-bold transition-all shadow-md cursor-pointer"
            >
                <span wire:loading.remove>
                    @if ($isDuplicateSeason)
                        Season Sudah Terdaftar
                    @else
                        <span class="flex items-center gap-2">
                            <x-lucide-save class="h-4 w-4" /> Simpan Turnamen
                        </span>
                    @endif
                </span>
                <span wire:loading class="animate-pulse">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
