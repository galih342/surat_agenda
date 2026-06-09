<div x-show="isBulkMode" x-transition
    class="mb-4 flex flex-wrap items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-md border border-slate-200 dark:border-gray-700 shadow-sm">

    <label class="flex items-center space-x-3 cursor-pointer group">
        <input type="checkbox" @change="toggleAll('diterima')" :checked="isAllChecked('diterima')"
            class="rounded-sm border-slate-300 text-slate-800 focus:ring-slate-500 cursor-pointer w-4 h-4 sm:w-5 sm:h-5 transition-colors">
        <span
            class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-gray-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">
            Pilih Semua Data di Halaman Ini
        </span>
    </label>

    <div x-show="selectedDiterima.length > 0" style="display: none;" class="flex items-center gap-2 mt-3 sm:mt-0"
        x-transition>
        <span class="text-xs font-bold text-slate-700 dark:text-slate-400 mr-2 uppercase tracking-wider">
            <span x-text="selectedDiterima.length"></span> Terpilih
        </span>
        <button type="button" @click="executeBulk('{{ route('surat.bulk-selesai') }}', 'diterima', 'PATCH')"
            class="px-4 py-2 bg-emerald-700 text-white text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-md hover:bg-emerald-800 shadow-sm transition-colors cursor-pointer">
            Tandai Selesai
        </button>
        <button type="button" @click="executeBulk('{{ route('surat.bulk-batal') }}', 'diterima', 'PATCH')"
            class="px-4 py-2 bg-white border border-slate-300 text-rose-700 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-md hover:bg-rose-50 shadow-sm transition-colors cursor-pointer">
            Batalkan Terpilih
        </button>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 p-2">
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
            <div class="col-span-full flex items-center py-2 mt-4 mb-1">
                <div class="flex-grow h-px bg-slate-200 dark:bg-gray-700/60"></div>
                <span
                    class="px-4 text-[10px] sm:text-xs font-bold text-slate-600 dark:text-gray-400 uppercase tracking-widest bg-slate-100 dark:bg-gray-800/50 rounded-md py-1.5 mx-2 border border-slate-200 dark:border-gray-700">
                    {{ $tanggalItem }}
                </span>
                <div class="flex-grow h-px bg-slate-200 dark:bg-gray-700/60"></div>
            </div>

            @php
                // Simpan tanggal saat ini untuk dibandingkan dengan item selanjutnya
                $tanggalSebelumnya = $tanggalItem;
            @endphp
        @endif

        <div :class="selectedDiterima.includes('{{ $item->id }}') ?
            'border-slate-500 bg-slate-50 dark:bg-slate-900/20 ring-1 ring-slate-500' :
            'bg-white dark:bg-gray-800 border-slate-200 dark:border-gray-700 hover:border-slate-400 dark:hover:border-slate-600'"
            class="group relative p-5 sm:p-6 rounded-md shadow-sm border hover:shadow transition-all duration-200 overflow-hidden cursor-pointer"
            @click="if(isBulkMode && $event.target.tagName !== 'BUTTON' && $event.target.tagName !== 'A' && $event.target.tagName !== 'INPUT' && $event.target.closest('form') === null) { let id = '{{ $item->id }}'; if(selectedDiterima.includes(id)) selectedDiterima = selectedDiterima.filter(i => i !== id); else selectedDiterima.push(id); }">

            <div class="absolute top-4 right-4 z-10">
                <input type="checkbox" x-show="isBulkMode" x-transition.opacity value="{{ $item->id }}"
                    x-model="selectedDiterima"
                    class="cb-diterima w-5 h-5 rounded-sm border-slate-300 text-slate-800 focus:ring-slate-500 cursor-pointer transition-opacity duration-200"
                    :class="selectedDiterima.includes('{{ $item->id }}') ? 'opacity-100' :
                        'opacity-0 group-hover:opacity-100'">
            </div>

            <!-- Pita Status Emerald -->
            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                :class="selectedDiterima.includes('{{ $item->id }}') ? 'bg-emerald-700' : 'bg-emerald-600'"></div>

            <div class="mb-5 pl-2">
                <h4
                    class="font-extrabold text-slate-900 dark:text-white text-base sm:text-lg uppercase tracking-wide leading-tight mb-1.5 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                    {{ $item->nama_opd }}</h4>
                <p class="text-xs sm:text-sm font-medium text-slate-500 dark:text-gray-400 line-clamp-2">
                    {{ $item->perihal }}
                </p>
            </div>

            <div class="space-y-3 mb-6 pl-2">
                <div class="flex items-center text-xs sm:text-sm font-bold text-slate-600 dark:text-gray-300">
                    <div
                        class="w-7 h-7 rounded-md bg-slate-100 dark:bg-gray-700/50 flex items-center justify-center mr-3 border border-slate-200 dark:border-gray-600">
                        <svg class="w-4 h-4 text-emerald-700 dark:text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span>{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex items-center text-xs sm:text-sm font-bold text-slate-600 dark:text-gray-300">
                    <div
                        class="w-7 h-7 rounded-md bg-slate-100 dark:bg-gray-700/50 flex items-center justify-center mr-3 border border-slate-200 dark:border-gray-600">
                        <svg class="w-4 h-4 text-emerald-700 dark:text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>{{ $item->jam_mulai }}
                        {{ $item->jam_selesai ? ' - ' . $item->jam_selesai : ' - Selesai' }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 pl-2 border-t border-slate-100 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <form action="{{ route('surat.selesai', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-4 py-2 bg-slate-900 text-white hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-md text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-colors shadow-sm cursor-pointer">
                            Selesai
                        </button>
                    </form>
                    <form action="{{ route('surat.batal', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-50 dark:bg-gray-800 dark:text-gray-300 rounded-md text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-colors shadow-sm cursor-pointer border border-slate-300 dark:border-gray-600">
                            Batal
                        </button>
                    </form>
                </div>
                <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                    class="text-[10px] sm:text-xs sm:ml-[7px] font-extrabold uppercase tracking-widest text-slate-600 hover:text-slate-900 dark:text-slate-400 transition-colors flex items-center group/link">
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
            class="col-span-full flex flex-col items-center justify-center p-10 sm:p-12 bg-white dark:bg-gray-800 rounded-md border border-slate-200 dark:border-gray-700 shadow-sm">
            <div
                class="w-16 h-16 mb-4 text-slate-400 dark:text-gray-600 bg-slate-50 dark:bg-gray-700/50 rounded-md border border-slate-200 flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
            <p
                class="text-slate-500 dark:text-gray-400 font-bold uppercase tracking-wider text-xs sm:text-sm text-center">
                Belum ada agenda kegiatan yang masuk daftar.</p>
        </div>
    @endforelse
</div>

<!-- Navigasi Paginasi -->
<div class="mt-6 px-2">
    {{ $surat->withQueryString()->links() }}
</div>
