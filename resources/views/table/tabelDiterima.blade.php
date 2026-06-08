<div x-show="isBulkMode" x-transition
    class="mb-4 flex flex-wrap items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">

    <label class="flex items-center space-x-3 cursor-pointer group">
        <input type="checkbox" @change="toggleAll('diterima')" :checked="isAllChecked('diterima')"
            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer w-5 h-5 transition-colors">
        <span
            class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
            Pilih Semua Data di Halaman Ini
        </span>
    </label>

    <div x-show="selectedDiterima.length > 0" style="display: none;" class="flex items-center gap-2 mt-3 sm:mt-0"
        x-transition>
        <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400 mr-2">
            <span x-text="selectedDiterima.length"></span> terpilih
        </span>
        <button type="button" @click="executeBulk('{{ route('surat.bulk-selesai') }}', 'diterima', 'PATCH')"
            class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 shadow-sm transition-colors cursor-pointer">
            Tandai Selesai
        </button>
        <button type="button" @click="executeBulk('{{ route('surat.bulk-batal') }}', 'diterima', 'PATCH')"
            class="px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-lg hover:bg-amber-600 shadow-sm transition-colors cursor-pointer">
            Batalkan Terpilih
        </button>
    </div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-2">
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
        <div :class="selectedDiterima.includes('{{ $item->id }}') ?
            'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 ring-1 ring-emerald-500' :
            'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 hover:border-emerald-200 dark:hover:border-emerald-800/50'"
            class="group relative p-6 rounded-2xl shadow-sm border hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer"
            @click="if(isBulkMode && $event.target.tagName !== 'BUTTON' && $event.target.tagName !== 'A' && $event.target.tagName !== 'INPUT' && $event.target.closest('form') === null) { let id = '{{ $item->id }}'; if(selectedDiterima.includes(id)) selectedDiterima = selectedDiterima.filter(i => i !== id); else selectedDiterima.push(id); }">

            <div class="absolute top-4 right-4 z-10">
                <input type="checkbox" x-show="isBulkMode" x-transition.opacity value="{{ $item->id }}"
                    x-model="selectedDiterima"
                    class="cb-diterima w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer transition-opacity duration-200"
                    :class="selectedDiterima.includes('{{ $item->id }}') ? 'opacity-100' :
                        'opacity-0 group-hover:opacity-100'">
            </div>

            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                :class="selectedDiterima.includes('{{ $item->id }}') ? 'bg-emerald-600' : 'bg-emerald-500'"></div>

            <div class="mb-5 pl-2">
                <h4
                    class="font-bold text-gray-900 dark:text-white text-lg leading-tight mb-1.5 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                    {{ $item->nama_opd }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                    {{ $item->perihal }}
                </p>
            </div>

            <div class="space-y-3 mb-6 pl-2">
                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300">
                    <div
                        class="w-7 h-7 rounded-lg bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center mr-3 border border-gray-100 dark:border-gray-600">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span>{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300">
                    <div
                        class="w-7 h-7 rounded-lg bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center mr-3 border border-gray-100 dark:border-gray-600">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>{{ $item->jam_mulai }}
                        {{ $item->jam_selesai ? ' - ' . $item->jam_selesai : ' - Selesai' }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 pl-2 border-t border-gray-50 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <form action="{{ route('surat.selesai', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg text-xs font-bold transition-colors shadow-sm cursor-pointer">
                            Selesai
                        </button>
                    </form>
                    <form action="{{ route('surat.batal', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-3 py-1.5 bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold transition-colors shadow-sm cursor-pointer border border-gray-200 dark:border-gray-600">
                            Batal
                        </button>
                    </form>
                </div>
                <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 transition-colors flex items-center group/link">
                    Lihat PDF
                    <svg class="w-3.5 h-3.5 ml-1 transform group-hover/link:translate-x-0.5 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    @empty
        <div
            class="col-span-full flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div
                class="w-16 h-16 mb-4 text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-semibold text-center">Belum ada agenda kegiatan yang masuk
                daftar.</p>
        </div>
    @endforelse
</div>
<!-- Navigasi Paginasi -->
<div class="mt-6 px-2">
    {{ $surat->withQueryString()->links() }}
</div>
