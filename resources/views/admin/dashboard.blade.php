@extends('layouts.admin', ['title' => 'Dashboard Overview'])

@section('content')
<div class="flex flex-col gap-8">
    <div>
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">
            Dashboard Overview
        </h1>
        <p class="text-neutral-500 dark:text-neutral-400 mt-1">
            Selamat datang di dashboard admin Polar Catalyst.
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 flex items-center justify-center">
                <x-lucide-trophy class="h-6 w-6" />
            </div>
            <div>
                <p class="text-sm text-neutral-500 font-medium">Total Turnamen</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $totalTournaments }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400 flex items-center justify-center">
                <x-lucide-check-circle-2 class="h-6 w-6" />
            </div>
            <div>
                <p class="text-sm text-neutral-500 font-medium">Turnamen Aktif</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $activeTournaments }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 flex items-center justify-center">
                <x-lucide-mail class="h-6 w-6" />
            </div>
            <div>
                <p class="text-sm text-neutral-500 font-medium">Pesan Masuk (Unread)</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $unreadMessagesCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 flex items-center justify-center">
                <x-lucide-users class="h-6 w-6" />
            </div>
            <div>
                <p class="text-sm text-neutral-500 font-medium">Total Fandom Participants</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $totalTeams }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-4">
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">Aksi Cepat</h2>
            <div class="flex flex-col gap-3">
                <a
                    href="{{ route('admin.turnamen') }}"
                    class="flex items-center justify-between p-4 rounded-xl border border-neutral-100 hover:border-brand-500 dark:border-neutral-800 dark:hover:border-brand-500 transition-colors group"
                >
                    <span class="font-medium dark:text-neutral-200">Kelola Turnamen</span>
                    <span class="text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                </a>
                <a
                    href="{{ route('admin.pesan') }}"
                    class="flex items-center justify-between p-4 rounded-xl border border-neutral-100 hover:border-brand-500 dark:border-neutral-800 dark:hover:border-brand-500 transition-colors group"
                >
                    <span class="font-medium dark:text-neutral-200">Lihat Pesan Masuk</span>
                    <span class="text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                </a>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-6 flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold dark:text-white">Pesan Terbaru</h2>
                <a
                    href="{{ route('admin.pesan') }}"
                    class="text-sm text-brand-500 hover:text-brand-600 flex items-center gap-1"
                >
                    Lihat Semua <x-lucide-arrow-right class="h-3 w-3" />
                </a>
            </div>
            <div class="flex flex-col gap-4 flex-1">
                @forelse ($recentMessages as $msg)
                    <div class="p-4 rounded-xl border {{ $msg->isRead ? 'border-neutral-100 dark:border-neutral-800' : 'border-brand-100 bg-brand-50/50 dark:border-brand-900/30 dark:bg-brand-900/10' }} flex flex-col gap-1">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-sm dark:text-neutral-200">{{ $msg->name }}</p>
                            <span class="text-[10px] text-neutral-400">
                                {{ $msg->createdAt ? $msg->createdAt->translatedFormat('d M') : '' }}
                            </span>
                        </div>
                        <p class="text-xs text-neutral-500 line-clamp-2">
                            {{ $msg->message }}
                        </p>
                    </div>
                @empty
                    <div class="flex-1 flex items-center justify-center text-sm text-neutral-500 py-8">
                        Belum ada pesan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
