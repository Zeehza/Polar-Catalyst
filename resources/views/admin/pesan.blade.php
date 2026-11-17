@extends('layouts.admin', ['title' => 'Pesan Masuk'])

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Inbox Pesan Masuk</h1>
            <p class="text-neutral-500 text-sm mt-1">Daftar penawaran dan pesan dari form kontak.</p>
        </div>
    </div>

    <livewire:admin-messages />
</div>
@endsection
