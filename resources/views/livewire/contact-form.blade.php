<div>
    {{-- Status Messages --}}
    @if ($successMessage)
        <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl flex items-start gap-4">
            <x-lucide-check-circle-2 class="h-6 w-6 text-green-600 dark:text-green-500 shrink-0 mt-0.5" />
            <div>
                <h3 class="font-bold text-green-900 dark:text-green-400">
                    Terkirim!
                </h3>
                <p class="text-green-700 dark:text-green-500/80 text-sm mt-1">
                    {{ $successMessage }}
                </p>
            </div>
        </div>
    @endif

    @if ($errorMessage)
        <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl flex items-start gap-4">
            <x-lucide-alert-circle class="h-6 w-6 text-red-600 dark:text-red-500 shrink-0 mt-0.5" />
            <div>
                <h3 class="font-bold text-red-900 dark:text-red-400">
                    Terjadi Kesalahan
                </h3>
                <p class="text-red-700 dark:text-red-500/80 text-sm mt-1">
                    {{ $errorMessage }}
                </p>
            </div>
        </div>
    @endif

    @if (!$successMessage)
        <form wire:submit.prevent="submit" class="flex flex-col gap-6">
            {{-- Honeypot field --}}
            <div class="sr-only" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" id="website" wire:model="website" tabindex="-1" autocomplete="off" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Nama Lengkap *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400">
                            <x-lucide-user class="h-5 w-5" />
                        </div>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            required
                            placeholder="Nama lengkap"
                            class="w-full pl-11 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all dark:text-white"
                        />
                    </div>
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Perusahaan --}}
                <div class="flex flex-col gap-2">
                    <label for="company" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Perusahaan / Organisasi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400">
                            <x-lucide-building-2 class="h-5 w-5" />
                        </div>
                        <input
                            type="text"
                            id="company"
                            wire:model="company"
                            placeholder="Perusahaan (opsional)"
                            class="w-full pl-11 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all dark:text-white"
                        />
                    </div>
                    @error('company') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Alamat Email *
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400">
                        <x-lucide-mail class="h-5 w-5" />
                    </div>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        required
                        placeholder="Alamat email"
                        class="w-full pl-11 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all dark:text-white"
                    />
                </div>
                @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Pesan --}}
            <div class="flex flex-col gap-2">
                <label for="message" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    Pesan / Penawaran *
                </label>
                <textarea
                    id="message"
                    wire:model="message"
                    required
                    rows="5"
                    placeholder="Tulis pesan..."
                    class="w-full p-4 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all dark:text-white resize-y"
                ></textarea>
                @error('message') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="mt-4 flex items-center justify-center gap-2 w-full py-4 bg-brand-500 hover:bg-brand-600 disabled:bg-brand-300 disabled:cursor-not-allowed text-white rounded-xl font-bold transition-all hover:shadow-lg active:scale-[0.98] cursor-pointer"
            >
                <span wire:loading.remove class="flex items-center gap-2">
                    Kirim Pesan
                    <x-lucide-send class="h-4 w-4" />
                </span>
                <span wire:loading class="animate-pulse">
                    Mengirim...
                </span>
            </button>

            <p class="text-center text-xs text-neutral-500 dark:text-neutral-500 mt-2">
                Dengan mengirimkan form ini, Anda menyetujui bahwa data Anda
                akan disimpan untuk keperluan komunikasi.
            </p>
        </form>
    @endif
</div>
