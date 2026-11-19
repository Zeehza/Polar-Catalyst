<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    {{-- Main Form Column --}}
    <div class="lg:col-span-7 xl:col-span-8 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-xs">
        @if ($errorMessage)
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/50 rounded-2xl flex items-start gap-3">
                <x-lucide-alert-circle class="h-5 w-5 text-red-600 dark:text-red-400 shrink-0 mt-0.5" />
                <div>
                    <h4 class="text-sm font-bold text-red-900 dark:text-red-200">Gagal Menyimpan Turnamen</h4>
                    <p class="text-xs text-red-700 dark:text-red-400 mt-0.5 font-medium">{{ $errorMessage }}</p>
                </div>
            </div>
        @endif

        {{-- Mode Selector (Tabs) if existing tournaments exist --}}
        @if (count($existingTournaments) > 0)
            <div class="mb-8">
                <label class="block text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-2.5">
                    Mode Pembuatan Turnamen
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-1.5 bg-neutral-100 dark:bg-neutral-950/80 border border-neutral-200/80 dark:border-neutral-800 rounded-2xl">
                    <button
                        type="button"
                        wire:click="setMode('new')"
                        class="flex items-center gap-3 py-3 px-4 rounded-xl text-left transition-all cursor-pointer {{ $mode === 'new' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs border border-neutral-200/70 dark:border-neutral-700/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white border border-transparent' }}"
                    >
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $mode === 'new' ? 'bg-brand-500/10 text-brand-500' : 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-500' }}">
                            <x-lucide-sparkles class="h-4 w-4" />
                        </div>
                        <div>
                            <span class="block text-xs sm:text-sm font-bold">Buat Turnamen Baru</span>
                            <span class="block text-[11px] opacity-75">Seri kompetisi baru mulai Season 1</span>
                        </div>
                    </button>

                    <button
                        type="button"
                        wire:click="setMode('existing')"
                        class="flex items-center gap-3 py-3 px-4 rounded-xl text-left transition-all cursor-pointer {{ $mode === 'existing' ? 'bg-white dark:bg-neutral-900 text-brand-600 dark:text-brand-400 shadow-xs border border-neutral-200/70 dark:border-neutral-700/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white border border-transparent' }}"
                    >
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $mode === 'existing' ? 'bg-brand-500/10 text-brand-500' : 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-500' }}">
                            <x-lucide-layers class="h-4 w-4" />
                        </div>
                        <div>
                            <span class="block text-xs sm:text-sm font-bold">Tambah Season</span>
                            <span class="block text-[11px] opacity-75">Lanjutkan turnamen yang sudah ada</span>
                        </div>
                    </button>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="submit" class="flex flex-col gap-7">
            {{-- Section 1: Identitas Turnamen --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-2 pb-2 border-b border-neutral-100 dark:border-neutral-800/80">
                    <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-bold">1</span>
                    <h3 class="text-xs font-bold text-neutral-900 dark:text-white uppercase tracking-wider">Identitas Turnamen</h3>
                </div>

                @if ($mode === 'existing')
                    <div class="flex flex-col gap-2">
                        <label for="selectTournament" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                            Pilih Seri Turnamen Induk <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select
                                id="selectTournament"
                                wire:model.live="selectedTournamentName"
                                class="w-full pl-10 pr-10 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none transition-all dark:text-white text-sm font-semibold appearance-none"
                            >
                                @foreach ($existingTournaments as $t)
                                    <option value="{{ $t['name'] }}">
                                        {{ $t['name'] }} ({{ $t['game'] }}) — {{ count($t['seasons']) }} Season
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                <x-lucide-trophy class="h-4 w-4" />
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-neutral-400">
                                <x-lucide-arrow-right class="h-4 w-4 rotate-90" />
                            </div>
                        </div>

                        {{-- Existing Tournament Summary Card --}}
                        @php
                            $selectedObj = collect($existingTournaments)->firstWhere('name', $selectedTournamentName);
                        @endphp
                        @if ($selectedObj)
                            <div class="mt-2 p-4 rounded-2xl bg-neutral-50 dark:bg-neutral-950/60 border border-neutral-200/80 dark:border-neutral-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0">
                                        <x-lucide-gamepad-2 class="h-4 w-4" />
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-neutral-900 dark:text-white">
                                            Game: <span class="text-brand-600 dark:text-brand-400">{{ $selectedObj['game'] }}</span>
                                        </div>
                                        <div class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">
                                            Season terdaftar saat ini:
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @foreach ($selectedObj['seasons'] as $sName)
                                        <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-white dark:bg-neutral-900 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-800">
                                            {{ $sName }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Turnamen --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="name" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                                Nama Turnamen <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="name"
                                    wire:model.live.debounce.250ms="name"
                                    required
                                    placeholder="Contoh: Fandom Clash Arena"
                                    class="w-full pl-10 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none transition-all dark:text-white text-sm"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                    <x-lucide-trophy class="h-4 w-4" />
                                </div>
                            </div>
                            <span class="text-[11px] text-neutral-400 dark:text-neutral-500">
                                Nama seri tetap turnamen esports
                            </span>
                            @error('name') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        {{-- Game --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="game" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                                Game / Cabang Esports <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="game"
                                    wire:model.live.debounce.250ms="game"
                                    required
                                    placeholder="Contoh: Mobile Legends"
                                    class="w-full pl-10 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none transition-all dark:text-white text-sm"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                    <x-lucide-gamepad-2 class="h-4 w-4" />
                                </div>
                            </div>
                            {{-- Quick Game Presets --}}
                            <div class="flex items-center gap-1.5 flex-wrap pt-0.5">
                                <span class="text-[10px] text-neutral-400 font-medium mr-0.5">Pilihan cepat:</span>
                                @foreach (['Mobile Legends', 'Valorant', 'Honor of Kings', 'Apex Legends', 'Tekken 8'] as $gPreset)
                                    <button
                                        type="button"
                                        wire:click="setGame('{{ $gPreset }}')"
                                        class="px-2 py-0.5 rounded-md text-[10px] font-semibold transition-colors cursor-pointer {{ $game === $gPreset ? 'bg-brand-500 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}"
                                    >
                                        {{ $gPreset }}
                                    </button>
                                @endforeach
                            </div>
                            @error('game') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>

            {{-- Section 2: Konfigurasi Season & Format --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-2 pb-2 border-b border-neutral-100 dark:border-neutral-800/80">
                    <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-bold">2</span>
                    <h3 class="text-xs font-bold text-neutral-900 dark:text-white uppercase tracking-wider">Format &amp; Jadwal Season</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Label Season --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="season" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                            Label Season <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="season"
                                wire:model.live.debounce.250ms="season"
                                required
                                placeholder="Contoh: Season 1"
                                class="w-full pl-10 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border rounded-xl focus:ring-2 focus:ring-brand-500/30 outline-none transition-all dark:text-white text-sm font-semibold {{ $isDuplicateSeason ? 'border-amber-500 focus:border-amber-500' : 'border-neutral-200 dark:border-neutral-800 focus:border-brand-500' }}"
                            />
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                <x-lucide-tag class="h-4 w-4" />
                            </div>
                        </div>

                        {{-- Duplicate Season Warning --}}
                        @if ($isDuplicateSeason)
                            <div class="p-3 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-900/60 rounded-xl text-amber-800 dark:text-amber-300 text-xs flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <x-lucide-alert-circle class="h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400" />
                                    <span><strong>{{ $season }}</strong> sudah ada di turnamen ini.</span>
                                </div>
                                <button
                                    type="button"
                                    wire:click="useSuggestedSeason('{{ $suggestedNextSeason }}')"
                                    class="self-start px-2.5 py-1 bg-amber-200/80 dark:bg-amber-800/80 hover:bg-amber-300 text-amber-900 dark:text-amber-100 font-bold rounded-lg transition-colors cursor-pointer text-[11px]"
                                >
                                    Gunakan {{ $suggestedNextSeason }}
                                </button>
                            </div>
                        @endif
                        @error('season') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="startDate" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="date"
                                id="startDate"
                                wire:model.live="startDate"
                                required
                                class="w-full pl-10 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 outline-none transition-all dark:text-white text-sm"
                            />
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                <x-lucide-calendar class="h-4 w-4" />
                            </div>
                        </div>
                        <span class="text-[11px] text-neutral-400 dark:text-neutral-500">
                            Tanggal kick-off atau pembukaan pertandingan
                        </span>
                        @error('startDate') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Format Turnamen Selection Cards --}}
                <div class="flex flex-col gap-2 mt-2">
                    <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                        Format Pertandingan <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- Playoff Option --}}
                        <div
                            wire:click="setType('PLAYOFF')"
                            class="relative p-4 rounded-2xl border transition-all cursor-pointer flex items-start gap-3.5 {{ $type === 'PLAYOFF' ? 'border-brand-500 bg-brand-50/50 dark:bg-brand-950/20 shadow-xs' : 'border-neutral-200 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 bg-neutral-50/40 dark:bg-neutral-950/40' }}"
                        >
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $type === 'PLAYOFF' ? 'bg-brand-500 text-white' : 'bg-neutral-200 dark:bg-neutral-800 text-neutral-500' }}">
                                <x-lucide-git-branch class="h-4 w-4" />
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs sm:text-sm font-bold text-neutral-900 dark:text-white">Playoff (Sistem Gugur)</span>
                                    @if ($type === 'PLAYOFF')
                                        <x-lucide-check-circle-2 class="h-4 w-4 text-brand-500 shrink-0" />
                                    @endif
                                </div>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5 leading-relaxed">
                                    Bagan bracket eliminasi langsung (Single/Double Elimination). Cocok untuk turnamen knockout.
                                </p>
                            </div>
                        </div>

                        {{-- Group Stage Option --}}
                        <div
                            wire:click="setType('GROUP_STAGE')"
                            class="relative p-4 rounded-2xl border transition-all cursor-pointer flex items-start gap-3.5 {{ $type === 'GROUP_STAGE' ? 'border-brand-500 bg-brand-50/50 dark:bg-brand-950/20 shadow-xs' : 'border-neutral-200 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 bg-neutral-50/40 dark:bg-neutral-950/40' }}"
                        >
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $type === 'GROUP_STAGE' ? 'bg-brand-500 text-white' : 'bg-neutral-200 dark:bg-neutral-800 text-neutral-500' }}">
                                <x-lucide-layers class="h-4 w-4" />
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs sm:text-sm font-bold text-neutral-900 dark:text-white">Group Stage + Playoff</span>
                                    @if ($type === 'GROUP_STAGE')
                                        <x-lucide-check-circle-2 class="h-4 w-4 text-brand-500 shrink-0" />
                                    @endif
                                </div>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5 leading-relaxed">
                                    Fase grup klasemen poin kemudian berlanjut ke sistem gugur. Cocok untuk kompetisi berskala besar.
                                </p>
                            </div>
                        </div>
                    </div>
                    @error('type') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Form Footer Actions --}}
            <div class="pt-6 border-t border-neutral-100 dark:border-neutral-800/80 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4">
                <a
                    href="{{ route('admin.turnamen') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                >
                    <x-lucide-arrow-left class="h-4 w-4" />
                    <span>Batal</span>
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    @if ($isDuplicateSeason) disabled @endif
                    class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-xl bg-brand-500 hover:bg-brand-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow-md cursor-pointer"
                >
                    <span wire:loading.remove class="flex items-center gap-2">
                        @if ($isDuplicateSeason)
                            <x-lucide-alert-circle class="h-4 w-4" />
                            <span>Season Sudah Terdaftar</span>
                        @else
                            <x-lucide-save class="h-4 w-4" />
                            <span>Simpan Turnamen &amp; Lanjut ke Bracket</span>
                            <x-lucide-arrow-right class="h-3.5 w-3.5 opacity-80" />
                        @endif
                    </span>
                    <span wire:loading class="flex items-center gap-2">
                        <x-lucide-loader-2 class="h-4 w-4 animate-spin" />
                        <span>Menyimpan &amp; Menyiapkan Bagan...</span>
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- Sidebar Column: Live Preview & Step Guides --}}
    <div class="lg:col-span-5 xl:col-span-4 sticky top-6 flex flex-col gap-6">
        {{-- Live Preview Card --}}
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-neutral-100 dark:border-neutral-800">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <h3 class="text-xs font-bold text-neutral-900 dark:text-white uppercase tracking-wider">
                        Pratinjau Kartu
                    </h3>
                </div>
                <span class="text-[10px] font-semibold text-neutral-400">Live Preview</span>
            </div>

            {{-- Mock Tournament Card --}}
            <div class="rounded-2xl bg-neutral-950 text-white p-5 border border-neutral-800 flex flex-col gap-4 relative overflow-hidden shadow-inner">
                {{-- Decorative gradient glow --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand-500/15 rounded-full blur-2xl pointer-events-none"></div>

                {{-- Badges row --}}
                <div class="flex items-center justify-between gap-2 relative z-10">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-neutral-800/90 text-neutral-200 border border-neutral-700">
                        <x-lucide-gamepad-2 class="h-3 w-3 text-brand-400" />
                        <span>{{ !empty(trim($game)) ? $game : 'Game Belum Diisi' }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>DRAFT</span>
                    </span>
                </div>

                {{-- Title & Season --}}
                <div class="flex flex-col gap-1 relative z-10">
                    <h4 class="text-base sm:text-lg font-black tracking-tight text-white leading-snug line-clamp-2">
                        {{ !empty(trim($name)) ? $name : 'Nama Turnamen Esports' }}
                    </h4>
                    <div class="flex items-center gap-2">
                        <span class="inline-block px-2 py-0.5 rounded-md bg-brand-500/20 text-brand-300 border border-brand-500/30 text-xs font-bold">
                            {{ !empty(trim($season)) ? $season : 'Season 1' }}
                        </span>
                        <span class="text-[11px] text-neutral-400 font-mono truncate">
                            {{ \Illuminate\Support\Str::slug(($name ?: 'turnamen') . ' ' . ($season ?: 'season-1')) }}
                        </span>
                    </div>
                </div>

                {{-- Details metadata --}}
                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-neutral-800/80 text-[11px] relative z-10">
                    <div>
                        <span class="text-neutral-500 block">Format:</span>
                        <span class="font-semibold text-neutral-200">
                            {{ $type === 'PLAYOFF' ? 'Playoff (Bracket)' : 'Group Stage + Playoff' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-neutral-500 block">Mulai:</span>
                        <span class="font-semibold text-neutral-200">
                            {{ !empty($startDate) ? date('d M Y', strtotime($startDate)) : 'Belum ditentukan' }}
                        </span>
                    </div>
                </div>
            </div>

            <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-3 text-center leading-relaxed">
                Kartu ini merupakan representasi tampilan season baru di halaman manajemen turnamen.
            </p>
        </div>

        {{-- Next Steps / Workflow Guide --}}
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 shadow-xs">
            <h3 class="text-xs font-bold text-neutral-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                <x-lucide-info class="h-4 w-4 text-brand-500" />
                <span>Alur Kerja Turnamen</span>
            </h3>

            <div class="flex flex-col gap-3.5">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs font-black shrink-0 mt-0.5">
                        1
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-neutral-900 dark:text-white">Buat Seri / Season</h5>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 leading-relaxed mt-0.5">
                            Menentukan nama, cabang game, season, dan tipe bagan (Tahap saat ini).
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 opacity-60">
                    <div class="w-6 h-6 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                        2
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-neutral-900 dark:text-white">Daftarkan Tim Peserta</h5>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 leading-relaxed mt-0.5">
                            Upload logo tim, tentukan short name (abbrev), dan tetapkan slot grup/seed.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 opacity-60">
                    <div class="w-6 h-6 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                        3
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-neutral-900 dark:text-white">Susun Bagan &amp; Skor</h5>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 leading-relaxed mt-0.5">
                            Atur jadwal match, catat skor berkala, dan tetapkan tim pemenang ke babak berikutnya.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-5 p-3 rounded-xl bg-brand-50/60 dark:bg-brand-950/30 border border-brand-200/60 dark:border-brand-900/40 text-[11px] text-brand-800 dark:text-brand-300 leading-relaxed">
                <span class="font-bold">Tips Admin:</span> Status awal turnamen adalah <strong>DRAFT</strong> sehingga aman dari pandangan publik selama Anda mempersiapkan tim dan jadwal.
            </div>
        </div>
    </div>
</div>