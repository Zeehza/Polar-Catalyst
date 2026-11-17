@extends('layouts.public')

@section('content')
<div class="flex flex-col min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Header Section -->
    <section class="relative px-4 py-20 text-center bg-brand-950 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.05] bg-size-[32px_32px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-brand-500/20 rounded-full blur-[100px] z-0"></div>

        <div class="relative z-10 container mx-auto flex flex-col items-center">
            <div class="mb-4 rounded-full bg-brand-500/10 p-4 text-brand-400 border border-brand-500/20">
                <x-lucide-message-square class="h-8 w-8" />
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-4">
                Contact
            </h1>
            <p class="max-w-2xl text-lg text-brand-200">
                Ada pertanyaan, saran, atau ingin menjalin kerja sama dengan Polar
                Catalyst? Isi formulir di bawah ini dan tim kami akan segera
                menghubungi Anda.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="container mx-auto px-4 py-16 md:px-8 max-w-3xl">
        <div class="bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="p-8 md:p-12">
                <livewire:contact-form />
            </div>
        </div>
    </section>
</div>
@endsection
