<div>
    {{-- Status Messages --}}
    @if ($successMessage)
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-2xl flex items-start gap-3">
            <x-lucide-check-circle-2 class="h-5 w-5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" />
            <div>
                <h3 class="text-sm font-bold text-emerald-900 dark:text-emerald-300">
                    Pesan Berhasil Terkirim
                </h3>
                <p class="text-xs text-emerald-700 dark:text-emerald-400/90 mt-1 leading-relaxed">
                    {{ $successMessage }}
                </p>
            </div>
        </div>
    @endif

    @if ($errorMessage)
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-2xl flex items-start gap-3">
            <x-lucide-alert-circle class="h-5 w-5 text-red-600 dark:text-red-400 shrink-0 mt-0.5" />
            <div>
                <h3 class="text-sm font-bold text-red-900 dark:text-red-300">
                    Terjadi Kesalahan
                </h3>
                <p class="text-xs text-red-700 dark:text-red-400/90 mt-1 leading-relaxed">
                    {{ $errorMessage }}
                </p>
            </div>
        </div>
    @endif

    @if (!$successMessage)
        <form wire:submit.prevent="submit" class="flex flex-col gap-5">
            {{-- Honeypot field --}}
            <div class="sr-only" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" id="website" wire:model="website" tabindex="-1" autocomplete="off" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Nama --}}
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        required
                        placeholder="Nama lengkap"
                        class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition-colors dark:text-white text-sm"
                    />
                    @error('name') <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span> @enderror
                </div>

                {{-- Perusahaan --}}
                <div class="flex flex-col gap-1.5">
                    <label for="company" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                        Perusahaan / Organisasi
                    </label>
                    <input
                        type="text"
                        id="company"
                        wire:model="company"
                        placeholder="Perusahaan (opsional)"
                        class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition-colors dark:text-white text-sm"
                    />
                    @error('company') <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    required
                    placeholder="Alamat email"
                    class="w-full px-4 py-2.5 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition-colors dark:text-white text-sm"
                />
                @error('email') <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span> @enderror
            </div>

            {{-- Pesan --}}
            <div class="flex flex-col gap-1.5">
                <label for="message" class="text-xs font-bold text-neutral-700 dark:text-neutral-300">
                    Pesan / Penawaran <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="message"
                    wire:model="message"
                    required
                    rows="5"
                    placeholder="Tulis pesan..."
                    class="w-full p-4 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition-colors dark:text-white text-sm resize-y"
                ></textarea>
                @error('message') <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span> @enderror
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="mt-2 flex items-center justify-center gap-2 w-full py-3 bg-brand-500 hover:bg-brand-600 disabled:bg-brand-300 disabled:cursor-not-allowed text-white rounded-xl text-sm font-bold transition-all shadow-xs hover:scale-[1.01] active:scale-[0.99] cursor-pointer"
            >
                <span wire:loading.remove class="flex items-center gap-2">
                    <span>Kirim Pesan</span>
                    <x-lucide-send class="h-4 w-4" />
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <x-lucide-loader-2 class="h-4 w-4 animate-spin" />
                    <span>Mengirim...</span>
                </span>
            </button>

            <p class="text-center text-[11px] text-neutral-400 dark:text-neutral-500 mt-1">
                Data yang dikirimkan hanya akan digunakan untuk keperluan komunikasi resmi Polar Catalyst.
            </p>
        </form>
    @endif
</div>
