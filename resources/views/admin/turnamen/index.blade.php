@extends('layouts.admin', ['title' => 'Kelola Turnamen & Season'])

@section('content')
<div class="flex flex-col gap-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white">
                Kelola Turnamen & Season
            </h1>
            <p class="text-neutral-500 text-sm mt-1">
                Daftar acara turnamen Polar Catalyst beserta season di dalamnya.
            </p>
        </div>
        <a
            href="{{ route('admin.turnamen.baru') }}"
            class="inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm self-start sm:self-auto"
        >
            <x-lucide-plus class="h-4 w-4" /> Buat Turnamen Baru
        </a>
    </div>

    @if (empty($groupedTournaments) || count($groupedTournaments) === 0)
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl p-12 text-center shadow-sm">
            <x-lucide-trophy class="h-12 w-12 mx-auto mb-3 text-neutral-400 dark:text-neutral-600" />
            <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">
                Belum Ada Turnamen
            </h3>
            <p class="text-sm text-neutral-500 max-w-md mx-auto mt-1 mb-6">
                Mulai dengan membuat turnamen esports pertama dan definisikan season perdananya.
            </p>
            <a
                href="{{ route('admin.turnamen.baru') }}"
                class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors shadow-sm"
            >
                <x-lucide-plus class="h-4 w-4" /> Buat Turnamen
            </a>
        </div>
    @else
        <div class="flex flex-col gap-8">
            @foreach ($groupedTournaments as $group)
                <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden shadow-sm">
                    <!-- Tournament Group Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 md:p-6 bg-neutral-50/70 dark:bg-neutral-950/40 border-b border-neutral-200 dark:border-neutral-800">
                        <div class="flex items-start md:items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0 border border-brand-500/20">
                                <x-lucide-trophy class="h-5 w-5" />
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white">
                                        {{ $group['name'] }}
                                    </h2>
                                    <span class="inline-flex items-center gap-1 bg-neutral-200/80 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                                        <x-lucide-gamepad-2 class="h-3 w-3" />
                                        {{ $group['game'] }}
                                    </span>
                                    <span class="text-xs text-neutral-500 bg-white dark:bg-neutral-900 px-2 py-0.5 rounded-md border border-neutral-200 dark:border-neutral-800">
                                        {{ count($group['seasons']) }} Season
                                    </span>
                                </div>
                                <p class="text-xs text-neutral-500 mt-1">
                                    Acara tetap turnamen esports
                                </p>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.turnamen.baru', ['name' => $group['name'], 'game' => $group['game']]) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold bg-white dark:bg-neutral-900 border border-brand-300 dark:border-brand-700 hover:bg-brand-50 dark:hover:bg-brand-950 text-brand-600 dark:text-brand-400 rounded-xl transition-all shadow-2xs self-start md:self-auto"
                        >
                            <x-lucide-plus class="h-3.5 w-3.5" /> Tambah Season Baru
                        </a>
                    </div>

                    <!-- Seasons Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-neutral-50 dark:bg-neutral-950/30 text-neutral-500 font-semibold border-b border-neutral-100 dark:border-neutral-800 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3.5">Season</th>
                                    <th class="px-6 py-3.5">Tanggal</th>
                                    <th class="px-6 py-3.5">Status</th>
                                    <th class="px-6 py-3.5">Tipe</th>
                                    <th class="px-6 py-3.5 text-center">Tim</th>
                                    <th class="px-6 py-3.5 text-center">Match</th>
                                    <th class="px-6 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800/50">
                                @foreach ($group['seasons'] as $season)
                                    <tr class="hover:bg-neutral-50/70 dark:hover:bg-neutral-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-neutral-900 dark:text-white">
                                                    {{ $season->season }}
                                                </span>
                                                <span class="text-xs text-neutral-400 font-mono">
                                                    ({{ $season->slug }})
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-neutral-600 dark:text-neutral-400 text-xs">
                                            <span class="flex items-center gap-1.5">
                                                <x-lucide-calendar class="h-3.5 w-3.5 text-neutral-400" />
                                                {{ $season->startDate ? $season->startDate->translatedFormat('d M Y') : '' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 text-xs rounded-full font-semibold {{ $season->status === 'ONGOING' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($season->status === 'COMPLETED' ? 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' : ($season->status === 'UPCOMING' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300')) }}">
                                                {{ $season->status === 'ONGOING' ? 'Live' : $season->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-2 py-1 rounded-md text-xs font-medium">
                                                {{ $season->type === 'GROUP_STAGE' ? 'Group Stage' : 'Playoff' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-semibold text-neutral-800 dark:text-neutral-200">
                                            <span class="inline-flex items-center gap-1">
                                                <x-lucide-users class="h-3.5 w-3.5 text-neutral-400" />
                                                {{ $season->teams_count ?? $season->teams->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-semibold text-neutral-800 dark:text-neutral-200">
                                            <span class="inline-flex items-center gap-1">
                                                <x-lucide-swords class="h-3.5 w-3.5 text-neutral-400" />
                                                {{ $season->matches_count ?? $season->matches->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a
                                                href="{{ route('admin.turnamen.detail', $season->id) }}"
                                                class="inline-flex items-center gap-1 text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 font-semibold text-sm hover:underline"
                                            >
                                                Kelola Season <x-lucide-external-link class="h-3.5 w-3.5" />
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
