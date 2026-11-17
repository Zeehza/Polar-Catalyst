<form wire:submit.prevent="login" class="flex flex-col gap-5">
    <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
            Username
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400">
                <x-lucide-user class="h-5 w-5" />
            </div>
            <input
                type="text"
                wire:model="username"
                required
                class="w-full pl-11 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                placeholder="Masukkan username"
            />
        </div>
        @error('username') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
            Password
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400">
                <x-lucide-key-round class="h-5 w-5" />
            </div>
            <input
                type="password"
                wire:model="password"
                required
                class="w-full pl-11 pr-4 py-3 bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                placeholder="Masukkan password"
            />
        </div>
        @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
    </div>

    @if ($errorMessage)
        <div class="flex items-center gap-2 p-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm rounded-xl border border-red-100 dark:border-red-900">
            <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
            <p>{{ $errorMessage }}</p>
        </div>
    @endif

    <button
        type="submit"
        wire:loading.attr="disabled"
        class="w-full py-3.5 mt-2 bg-brand-500 hover:bg-brand-600 disabled:bg-brand-400 text-white font-bold rounded-xl shadow-lg shadow-brand-500/25 transition-all flex items-center justify-center cursor-pointer"
    >
        <span wire:loading.remove>Sign In</span>
        <span wire:loading class="animate-pulse">Authenticating...</span>
    </button>
</form>
