@extends('layouts.admin', ['title' => 'Buat Turnamen / Season Baru'])

@section('content')
<div class="flex flex-col gap-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-4">
        <a
            href="{{ route('admin.turnamen') }}"
            class="p-2 hover:bg-neutral-200 dark:hover:bg-neutral-800 rounded-full transition-colors"
        >
            <x-lucide-arrow-left class="h-5 w-5" />
        </a>
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">
                {{ !empty($initialName) ? "Tambah Season: {$initialName}" : "Buat Turnamen / Season Baru" }}
            </h1>
            <p class="text-neutral-500 text-sm mt-1">
                {{ !empty($initialName) ? "Buat season berikutnya untuk turnamen {$initialName}." : "Buat turnamen baru atau tambahkan season ke acara turnamen yang sudah ada." }}
            </p>
        </div>
    </div>

    <livewire:create-tournament-form
        :initialName="$initialName ?? ''"
        :initialGame="$initialGame ?? ''"
    />
</div>
@endsection
