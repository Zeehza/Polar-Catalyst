@extends('layouts.app', ['title' => 'Admin Login'])

@section('content')
<div class="min-h-screen flex items-center justify-center bg-neutral-100 dark:bg-neutral-950 px-4">
    <div class="w-full max-w-md bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 p-8">
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="h-16 w-16 bg-brand-500/10 rounded-full flex items-center justify-center mb-4">
                <x-lucide-lock class="h-8 w-8 text-brand-500" />
            </div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Admin Portal</h1>
            <p class="text-neutral-500 dark:text-neutral-400 text-sm mt-1">
                Masuk untuk mengelola turnamen dan konten web.
            </p>
        </div>

        <livewire:login-form />
    </div>
</div>
@endsection
