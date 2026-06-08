<div class="space-y-4 p-2">
    <div
        x-show="isBulkMode" x-transition class="mb-4 flex flex-wrap items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
        <label class="flex items-center space-x-3 cursor-pointer group">
            <input type="checkbox" @change="toggleAll('batal')" :checked="isAllChecked('batal')"
                class="rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-5 h-5 transition-colors">
            <span
                class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                Pilih Semua Agenda Batal
            </span>
        </label>

        <div x-show="selectedBatal.length > 0" style="display: none;" class="flex items-center gap-2 mt-3 sm:mt-0"
            x-transition>
            <span class="text-sm font-bold text-rose-600 dark:text-rose-400 mr-2">
                <span x-text="selectedBatal.length"></span> terpilih
            </span>
            <button type="button" @click="executeBulk('{{ route('surat.bulk-destroy') }}', 'batal', 'DELETE')"
                class="px-3 py-1.5 bg-rose-600 text-white text-xs font-bold rounded-lg hover:bg-rose-700 shadow-sm transition-colors cursor-pointer">
                Hapus ke Tong Sampah
            </button>
        </div>
    </div>
    @php
        // Siapkan wadah memori kosong sebelum looping dimulai
        $tanggalSebelumnya = null;
    @endphp
    @forelse($surat as $item)
        @php
            // Ambil tanggal dari item saat ini (contoh menggunakan tanggal_acara)
            $tanggalItem = \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('l, d F Y');
        @endphp

        {{-- Cek apakah ini item pertama ATAU tanggalnya beda dengan sebelumnya --}}
        @if ($loop->first || $tanggalItem !== $tanggalSebelumnya)
            <div class="col-span-full flex items-center py-2 mt-4 mb-2">
                <div class="flex-grow h-px bg-gray-200 dark:bg-gray-700/60"></div>
                <span
                    class="px-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-800/50 rounded-full py-1 mx-2 border border-gray-100 dark:border-gray-700">
                    {{ $tanggalItem }}
                </span>
                <div class="flex-grow h-px bg-gray-200 dark:bg-gray-700/60"></div>
            </div>

            @php
                // Simpan tanggal saat ini untuk dibandingkan dengan item selanjutnya
                $tanggalSebelumnya = $tanggalItem;
            @endphp
        @endif
        <div :class="selectedBatal.includes('{{ $item->id }}') ?
            'border-rose-500 bg-rose-50/40 dark:bg-rose-900/20 ring-1 ring-rose-500' :
            'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 hover:border-rose-100 dark:hover:border-rose-900/50'"
            class="group flex flex-col lg:flex-row lg:items-center justify-between p-5 rounded-2xl border shadow-sm gap-4 transition-all duration-200 cursor-pointer relative"
            @click="if(isBulkMode && $event.target.tagName !== 'BUTTON' && $event.target.tagName !== 'A' && $event.target.tagName !== 'INPUT' && $event.target.closest('form') === null) { let id = '{{ $item->id }}'; if(selectedBatal.includes(id)) selectedBatal = selectedBatal.filter(i => i !== id); else selectedBatal.push(id); }">

            <div class="flex items-start gap-4 flex-1">
                <div class="flex items-center justify-center mt-2 w-5">
                    <input type="checkbox" x-show="isBulkMode" x-transition.opacity value="{{ $item->id }}" x-model="selectedBatal"
                        class="cb-batal w-5 h-5 rounded border-gray-300 text-rose-500 focus:ring-rose-500 cursor-pointer transition-opacity duration-200"
                        :class="selectedBatal.includes({{ $item->id }}) ? 'opacity-100' :
                            'opacity-0 group-hover:opacity-100'">
                </div>

                <div
                    class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center flex-shrink-0 border border-rose-100 dark:border-rose-800/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                        </path>
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <h4 class="font-bold text-gray-900 dark:text-white text-base tracking-tight">{{ $item->nama_opd }}
                    </h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">{{ $item->perihal }}</p>
                </div>
            </div>

            <div
                class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500 dark:text-gray-400 font-medium bg-gray-50 dark:bg-gray-700/30 px-4 py-2 rounded-xl border border-gray-100/50 dark:border-gray-700/50 line-through decoration-gray-300">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d M Y') }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $item->jam_mulai }}
                        {{ $item->jam_selesai ? ' - ' . $item->jam_selesai : ' - Selesai' }}</span>
                </div>
            </div>

            <div
                class="flex items-center justify-between lg:justify-end gap-3 min-w-[200px] border-t lg:border-t-0 pt-3 lg:pt-0 border-gray-50 dark:border-gray-700">
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-100 dark:border-rose-800/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span>
                    Batal
                </span>

                <div class="flex items-center gap-1 border-l border-gray-200 dark:border-gray-700 pl-3">
                    <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                        class="p-1.5 text-gray-500 hover:text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-colors"
                        title="Lihat Arsip PDF">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>

                    <form action="{{ route('surat.destroy', $item->id) }}" method="POST"
                        onsubmit="return confirm('Pindah data batal ini ke tong sampah?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition-colors cursor-pointer"
                            title="Hapus ke Tong Sampah">
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
            <p class="text-gray-400 dark:text-gray-500 font-medium text-center text-sm">Belum ada riwayat agenda yang
                dibatalkan.</p>
        </div>
    @endforelse

    <!-- Navigasi Paginasi -->
    <div class="mt-6 px-2">
        {{ $surat->withQueryString()->links() }}
    </div>
</div>
