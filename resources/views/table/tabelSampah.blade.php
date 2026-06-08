<div class="space-y-4 p-2">
    <div
        x-show="isBulkMode" x-transition class="mb-4 flex flex-wrap items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
        <label class="flex items-center space-x-3 cursor-pointer group">
            <input type="checkbox" @change="toggleAll('{{ $tipe }}')"
                :checked="isAllChecked('{{ $tipe }}')"
                class="rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-5 h-5 transition-colors">
            <span
                class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                Pilih Semua Item
            </span>
        </label>

        <div x-show="selected{{ ucfirst($tipe) }}.length > 0" style="display: none;"
            class="flex items-center gap-2 mt-3 sm:mt-0" x-transition>
            <span class="text-sm font-bold text-rose-600 dark:text-rose-400 mr-2">
                <span x-text="selected{{ ucfirst($tipe) }}.length"></span> terpilih
            </span>
            <button type="button"
                @click="executeBulk('{{ route('surat.bulk-restore') }}', '{{ $tipe }}', 'PATCH')"
                class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 shadow-sm transition-colors cursor-pointer">
                Pulihkan Terpilih
            </button>
            <button type="button"
                @click="executeBulk('{{ route('surat.bulk-force') }}', '{{ $tipe }}', 'DELETE')"
                class="px-3 py-1.5 bg-rose-600 text-white text-xs font-bold rounded-lg hover:bg-rose-700 shadow-sm transition-colors cursor-pointer">
                Hapus Permanen
            </button>
        </div>
    </div>

    @forelse($surat as $item)
        <div :class="selected{{ ucfirst($tipe) }}.includes('{{ $item->id }}') ?
            'border-rose-500 bg-rose-50/30 dark:bg-rose-900/10 ring-1 ring-rose-500 opacity-100' :
            'bg-gray-50/50 dark:bg-gray-800/40 border-gray-200 dark:border-gray-700/80 hover:border-rose-200 dark:hover:border-rose-800/50 opacity-90 hover:opacity-100'"
            class="group flex flex-col lg:flex-row lg:items-center justify-between p-5 rounded-2xl border shadow-sm gap-4 transition-all duration-200 cursor-pointer relative"
            @click="if(isBulkMode && $event.target.tagName !== 'BUTTON' && $event.target.tagName !== 'A' && $event.target.tagName !== 'INPUT' && $event.target.closest('form') === null) { let id = '{{ $item->id }}'; if(selected{{ ucfirst($tipe) }}.includes(id)) selected{{ ucfirst($tipe) }} = selected{{ ucfirst($tipe) }}.filter(i => i !== id); else selected{{ ucfirst($tipe) }}.push(id); }">

            <div class="flex items-start gap-4 flex-1">
                <div class="flex items-center justify-center mt-2 w-5">
                    <input type="checkbox" x-show="isBulkMode" x-transition.opacity value="{{ $item->id }}" x-model="selected{{ ucfirst($tipe) }}"
                        class="cb-{{ $tipe }} w-5 h-5 rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer transition-opacity duration-200"
                        :class="selected{{ ucfirst($tipe) }}.includes({{ $item->id }}) ? 'opacity-100' :
                            'opacity-0 group-hover:opacity-100'">
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center flex-shrink-0 border border-gray-300 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <h4 class="font-bold text-gray-700 dark:text-gray-300 text-base tracking-tight line-through">
                        {{ $item->nama_opd }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-500 line-clamp-1">{{ $item->perihal }}</p>
                </div>
            </div>

            <!-- Kolom Kanan: Info Hapus & Link (Tanpa Tombol Aksi Untuk Sekarang) -->
            <div
                class="flex flex-wrap items-center justify-between lg:justify-end gap-4 min-w-[280px] border-t lg:border-t-0 pt-3 lg:pt-0 border-gray-200 dark:border-gray-700">

                <div class="text-left lg:text-right">
                    <span class="block text-[10px] font-bold text-rose-500 uppercase tracking-wider mb-0.5">Dihapus
                        Pada:</span>
                    <span
                        class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($item->deleted_at)->translatedFormat('d M Y, H:i') }}</span>
                </div>

                <div
                    class="flex items-center gap-1.5 bg-white dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                        class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-colors"
                        title="Lihat PDF">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </a>

                    <form action="{{ route('surat.restore', $item->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="p-2 text-emerald-500 hover:text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg transition-colors cursor-pointer"
                            title="Pulihkan Data">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3">
                                </path>
                            </svg>
                        </button>
                    </form>

                    <form action="{{ route('surat.forceDelete', $item->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('PENTING! Data dan file surat akan dihapus secara permanen dari sistem. Anda yakin?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition-colors cursor-pointer"
                            title="Hapus Permanen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @empty
        <div
            class="flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div
                class="w-16 h-16 mb-4 text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </div>
            <p class="text-gray-400 dark:text-gray-500 font-medium text-center text-sm">Tong sampah untuk kategori ini
                kosong.</p>
        </div>
    @endforelse

</div>
<!-- Navigasi Paginasi -->
<div class="mt-6 px-2">
    {{ $surat->withQueryString()->links() }}
</div>
