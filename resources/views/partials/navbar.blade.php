<header
  class="sticky top-0 z-50 w-full border-b border-neutral-200 bg-white/80 backdrop-blur-md dark:border-neutral-800 dark:bg-neutral-950/80"
  x-data="{ mobileMenuOpen: false }"
  x-on:click.outside="mobileMenuOpen = false"
  x-on:keydown.escape.window="mobileMenuOpen = false"
>
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
          class="text-sm font-medium transition-colors {{ request()->routeIs('events') ? 'text-brand-500 dark:text-brand-400 font-bold' : 'text-neutral-600 hover:text-brand-500 dark:text-neutral-400 dark:hover:text-brand-400' }}"
        >
          Events
        </a>
        <a
          href="{{ route('results') }}"
          class="text-sm font-medium transition-colors {{ request()->routeIs('results') ? 'text-brand-500 dark:text-brand-400 font-bold' : 'text-neutral-600 hover:text-brand-500 dark:text-neutral-400 dark:hover:text-brand-400' }}"
        >
          Results
        </a>
        <a
          href="{{ route('contact') }}"
          class="text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-brand-500 dark:text-brand-400 font-bold' : 'text-neutral-600 hover:text-brand-500 dark:text-neutral-400 dark:hover:text-brand-400' }}"
        >
          Contact
        </a>
      </nav>
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
      <!-- Dark Mode Toggle Button -->
      <button
        type="button"
        onclick="toggleTheme()"
        aria-label="Toggle theme"
        class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg border border-neutral-200 bg-white text-sm font-medium transition-colors hover:bg-brand-50 hover:text-brand-600 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-500 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-brand-950 dark:hover:text-brand-400 cursor-pointer"
      >
        <x-lucide-sun class="h-4 w-4 transition-all block dark:hidden" />
        <x-lucide-moon class="h-4 w-4 transition-all hidden dark:block" />
        <span class="sr-only">Toggle theme</span>
      </button>

      <!-- Mobile Hamburger Menu Button -->
      <button
        type="button"
        x-on:click="mobileMenuOpen = !mobileMenuOpen"
        :aria-expanded="mobileMenuOpen"
        aria-label="Buka menu navigasi"
        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-neutral-200 bg-white text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-500 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-300 dark:hover:bg-neutral-900 dark:hover:text-white md:hidden cursor-pointer"
      >
        <x-lucide-menu x-show="!mobileMenuOpen" class="h-4 w-4" />
        <x-lucide-x x-show="mobileMenuOpen" x-cloak class="h-4 w-4" />
        <span class="sr-only">Toggle navigation menu</span>
      </button>
    </div>
  </div>

  <!-- Mobile Navigation Dropdown Menu -->
  <div
    x-show="mobileMenuOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="border-b border-neutral-200/80 bg-white/95 backdrop-blur-md px-4 py-3 dark:border-neutral-800 dark:bg-neutral-950/95 md:hidden"
  >
    <nav class="flex flex-col gap-1.5">
      <a
        href="{{ route('home') }}"
        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'bg-brand-500/10 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400' : 'text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-900' }}"
      >
        <x-lucide-home class="h-4 w-4" />
        <span>Home</span>
      </a>
      <a
        href="{{ route('events') }}"
        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('events') ? 'bg-brand-500/10 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400' : 'text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-900' }}"
      >
        <x-lucide-calendar class="h-4 w-4" />
        <span>Events</span>
      </a>
      <a
        href="{{ route('results') }}"
        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('results') ? 'bg-brand-500/10 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400' : 'text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-900' }}"
      >
        <x-lucide-trophy class="h-4 w-4" />
        <span>Results</span>
      </a>
      <a
        href="{{ route('contact') }}"
        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('contact') ? 'bg-brand-500/10 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400' : 'text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-900' }}"
      >
        <x-lucide-mail class="h-4 w-4" />
        <span>Contact</span>
      </a>
    </nav>
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
