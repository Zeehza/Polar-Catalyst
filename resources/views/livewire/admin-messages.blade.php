<div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-neutral-50 dark:bg-neutral-950/50 text-neutral-500 font-semibold border-b border-neutral-200 dark:border-neutral-800">
                <tr>
                    <th class="px-6 py-4">Pengirim</th>
                    <th class="px-6 py-4">Perusahaan</th>
                    <th class="px-6 py-4 w-1/2">Pesan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800/50">
                @forelse ($messages as $msg)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-lucide-user class="h-4 w-4 text-neutral-400" />
                                <div>
                                    <p class="font-semibold text-neutral-900 dark:text-white">{{ $msg->name }}</p>
                                    <p class="text-xs text-brand-600 dark:text-brand-400">{{ $msg->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                                <x-lucide-building-2 class="h-4 w-4 text-neutral-400" />
                                {{ $msg->company ?: '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-neutral-600 dark:text-neutral-300 line-clamp-2" title="{{ $msg->message }}">
                                {{ $msg->message }}
                            </p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-neutral-500">
                            {{ $msg->createdAt ? $msg->createdAt->translatedFormat('d M Y, H:i') : '' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium {{ $msg->isRead ? 'bg-neutral-100 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-400' : 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' }}">
                                {{ $msg->isRead ? 'Read' : 'New' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if (!$msg->isRead)
                                    <button
                                        type="button"
                                        wire:click="markAsRead('{{ $msg->id }}')"
                                        class="p-1.5 text-neutral-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-900/20 rounded-md transition-colors cursor-pointer"
                                        title="Tandai sudah dibaca"
                                    >
                                        <x-lucide-check class="h-4 w-4" />
                                    </button>
                                @endif
                                <button
                                    type="button"
                                    wire:click="deleteMessage('{{ $msg->id }}')"
                                    wire:confirm="Yakin ingin menghapus pesan ini?"
                                    class="p-1.5 text-neutral-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors cursor-pointer"
                                    title="Hapus pesan"
                                >
                                    <x-lucide-trash-2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                            <x-lucide-mail class="h-8 w-8 mx-auto mb-2 opacity-50" />
                            Belum ada pesan masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
