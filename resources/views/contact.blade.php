@extends('layouts.public', ['title' => 'Contact'])

@section('content')
<div class="flex flex-col min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Header Section -->
    <section class="relative px-4 py-14 md:py-18 text-center bg-brand-950 border-b border-brand-900/60 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-grid-white/[0.04] bg-size-[32px_32px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-brand-500/15 rounded-full blur-[100px] pointer-events-none animate-pulse-glow"></div>

        <div class="relative z-10 container mx-auto max-w-4xl flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-3.5 rounded-full bg-brand-500/10 text-brand-400 border border-brand-500/20 text-xs font-bold uppercase tracking-widest animate-fade-in-down">
                <span class="h-2 w-2 rounded-full bg-brand-400 animate-pulse"></span>
                <span>Get in Touch</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-3 animate-fade-in-up">
                Contact &amp; Partnership
            </h1>
            <p class="text-sm md:text-base text-brand-200/90 max-w-xl text-pretty animate-fade-in-up delay-150">
                Ada pertanyaan, saran, atau peluang kolaborasi bersama Polar Catalyst? Hubungi kami langsung atau tinggalkan pesan di bawah.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="container mx-auto px-4 py-10 md:py-14 md:px-6 lg:px-8 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            <!-- Info & Channels Column -->
            <div class="lg:col-span-5 flex flex-col gap-6 reveal-on-scroll">
                <!-- Discord Community Card -->
                <div class="bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 p-6 md:p-8 shadow-xs group hover:-translate-y-1.5 transition-all duration-300 hover:border-brand-500/40">
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-[#5865F2]/10 text-[#5865F2] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.0777.0777 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-neutral-900 dark:text-white">Discord Comunity</h2>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Pusat koordinasi &amp; obrolan resmi</p>
                        </div>
                    </div>
                    <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed mb-5">
                        Dapatkan informasi turnamen, diskusi langsung dengan tim, dan berinteraksi bersama seluruh komunitas Polar Catalyst di server Discord kami.
                    </p>
                    <a
                        href="https://discord.gg/Wb4eMan7rg"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 w-full px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold transition-all shadow-xs hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Gabung Server Discord</span>
                        <x-lucide-arrow-up-right class="h-4 w-4" />
                    </a>
                </div>
            </div>

            <!-- Contact Form Card Column -->
            <div class="lg:col-span-7 bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200/80 dark:border-neutral-800 shadow-sm p-6 sm:p-8 md:p-10 reveal-on-scroll delay-150">
                <div class="mb-6 pb-6 border-b border-neutral-100 dark:border-neutral-800">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-1">
                        Kirim Pesan
                    </h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Isi data diri dan pesan Anda di bawah. Kami akan segera menghubungi balik.
                    </p>
                </div>

                <livewire:contact-form />
            </div>
        </div>
    </section>
</div>
@endsection