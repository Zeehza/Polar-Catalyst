@extends('layouts.admin', ['title' => 'Buat Turnamen / Season Baru'])

@section('content')
<div class="flex flex-col gap-6 max-w-3xl mx-auto">
    <!-- Header with Breadcrumbs & Back Button -->
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
                    <span class="text-neutral-700 dark:text-neutral-200">
                        {{ !empty($initialName) ? "Tambah Season" : "Buat Turnamen Baru" }}
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                    {{ !empty($initialName) ? "Tambah Season: {$initialName}" : "Buat Turnamen / Season Baru" }}
                </h1>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs md:text-sm mt-0.5">
                    {{ !empty($initialName) ? "Daftarkan season lanjutan untuk turnamen {$initialName}." : "Inisialisasi kompetisi esports baru atau tambahkan season ke seri turnamen yang sudah berjalan." }}
                </p>
            </div>
        </div>

        <a
            href="{{ route('admin.turnamen') }}"
            class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors shadow-2xs"
        >
            <x-lucide-trophy class="h-4 w-4" />
            <span>Lihat Semua Turnamen</span>
        </a>
    </div>

    <!-- Livewire Form -->
    <livewire:create-tournament-form
        :initialName="$initialName ?? ''"
        :initialGame="$initialGame ?? ''"
    />
</div>
@endsection
