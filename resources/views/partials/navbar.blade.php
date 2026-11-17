<header class="sticky top-0 z-50 w-full border-b border-neutral-200 bg-white/80 backdrop-blur-md dark:border-neutral-800 dark:bg-neutral-950/80">
  <div class="container mx-auto flex h-16 items-center justify-between px-4 md:px-8">
    <div class="flex items-center gap-6">
      <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img
          src="/polar-catalyst.svg"
          alt="Polar Catalyst"
          width="36"
          height="36"
          class="rounded-full bg-transparent dark:invert"
        />
        <span class="text-xl font-bold tracking-tight text-neutral-900 dark:text-white">
          Polar Catalyst
        </span>
      </a>
      <nav class="hidden gap-6 md:flex">
        <a
          href="{{ route('events') }}"
          class="text-sm font-medium transition-colors {{ request()->routeIs('events') ? 'text-brand-500 dark:text-brand-400' : 'text-neutral-600 hover:text-brand-500 dark:text-neutral-400 dark:hover:text-brand-400' }}"
        >
          Events
        </a>
        <a
          href="{{ route('results') }}"
          class="text-sm font-medium transition-colors {{ request()->routeIs('results') ? 'text-brand-500 dark:text-brand-400' : 'text-neutral-600 hover:text-brand-500 dark:text-neutral-400 dark:hover:text-brand-400' }}"
        >
          Results
        </a>
        <a
          href="{{ route('contact') }}"
          class="text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-brand-500 dark:text-brand-400' : 'text-neutral-600 hover:text-brand-500 dark:text-neutral-400 dark:hover:text-brand-400' }}"
        >
          Contact
        </a>
      </nav>
    </div>
    <div class="flex items-center gap-4">
      <button
        type="button"
        onclick="toggleTheme()"
        aria-label="Toggle theme"
        class="relative inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-white text-sm font-medium transition-colors hover:bg-brand-50 hover:text-brand-600 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-brand-950 dark:hover:text-brand-400 cursor-pointer"
      >
        <x-lucide-sun class="h-4 w-4 transition-all block dark:hidden" />
        <x-lucide-moon class="h-4 w-4 transition-all hidden dark:block" />
        <span class="sr-only">Toggle theme</span>
      </button>
    </div>
  </div>
</header>

<script>
function toggleTheme() {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
}
</script>
