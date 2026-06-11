<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

<div x-data="{ 
    modalPoster: false, 
    p_link: '', 
    p_token: '', 
    p_email: '', 
    p_status: '', 
    
    bukaPoster(link, token, email, status) {
        this.p_link = link;
        this.p_token = token;
        this.p_email = email;
        this.p_status = status;
        this.modalPoster = true;
    }
}">

    <div x-show="isBulkMode"
        class="mb-4 flex justify-between items-center bg-slate-100 dark:bg-gray-800 p-3 rounded-lg border border-slate-200 dark:border-gray-700"
        style="display: none;">
        <div class="flex items-center gap-2">
            <input type="checkbox" @change="toggleAll('qr')" :checked="isAllChecked('qr')"
                class="rounded border-slate-300 text-slate-900 focus:ring-slate-900 dark:bg-gray-700 dark:border-gray-600">
            <span
                class="text-[10px] sm:text-xs font-bold text-slate-700 dark:text-gray-300 uppercase tracking-wider">Pilih
                Semua QR</span>
        </div>
        <button x-show="selectedQr.length > 0"
            @click="executeBulk('{{ route('qr.bulk-hapus') ?? '#' }}', 'qr', 'DELETE')"
            class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-[10px] font-bold uppercase tracking-wider rounded shadow-sm transition-colors">
            Hapus Terpilih (<span x-text="selectedQr.length"></span>)
        </button>
    </div>

    <h4
        class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-3 mt-2 border-b border-slate-200 dark:border-gray-700 pb-1">
        Belum Dipakai</h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-2 mb-6">
        @forelse(collect($qrTokens)->where('status', 'ACTIVE') as $qr)
            <div class="flex flex-col">
                <div id="print-qr-{{ $qr->id }}"
                    class="bg-white text-slate-900 border-2 border-slate-300 rounded-t-lg p-4 flex flex-col items-center justify-center relative overflow-hidden shadow-sm">

                    <input type="checkbox" value="{{ $qr->id }}" x-show="isBulkMode" x-model="selectedQr"
                        class="cb-qr absolute top-2 left-2 rounded border-slate-300 text-slate-900 focus:ring-slate-900"
                        style="display: none;">

                    <form action="{{ route('qr.hapus', $qr->id) }}" method="POST"
                        onsubmit="return confirm('Hapus QR ini?');" class="absolute top-2 right-2" x-show="!isBulkMode">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors p-1"
                            title="Hapus QR">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </form>

                    <div class="w-full flex items-center justify-center gap-2 mb-3 pb-1.5 border-b border-slate-400">
                        <img src="{{ asset('images/icon.png') }}" class="w-5 h-5 object-contain">
                        <div class="text-left leading-none">
                            <p class="text-[7px] font-bold uppercase text-slate-700 tracking-wider">Pemerintah Kab.
                                Katingan</p>
                            <p class="text-[9px] font-black uppercase text-slate-900">Diskominfostandi</p>
                        </div>
                    </div>

                    <span
                        class="text-[8px] font-black uppercase tracking-widest text-amber-700 bg-amber-50 px-1.5 py-0.5 border border-amber-200 rounded mb-2.5">Belum
                        Dipakai</span>

                    <div class="p-1.5 bg-white rounded border border-slate-200 mb-2.5 shadow-inner">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('qr.scan', ['token' => $qr->token])) }}"
                            alt="QR Code" class="w-24 h-24 object-contain">
                    </div>

                    <p class="text-[7px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Tautan
                        Verifikasi:</p>
                    <span
                        class="w-full text-[9px] font-mono text-slate-600 bg-slate-50 border border-slate-200 rounded p-1 text-center truncate">
                        {{ route('qr.scan', ['token' => $qr->token]) }}
                    </span>
                </div>
                <button type="button"
                    @click="p_link = '{{ route('qr.scan', ['token' => $qr->token]) }}'; p_token = '{{ substr($qr->token, 4, 8) }}'; p_email = ''; p_status = 'ACTIVE'; modalPoster = true;"
                    class="w-full py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold uppercase tracking-wider border-x border-b border-slate-300 rounded-b-lg transition-colors flex items-center justify-center gap-1 cursor-pointer shadow-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Lihat Poster
                </button>
            </div>
        @empty
            <div class="col-span-full py-6 text-center text-slate-500 dark:text-gray-400 text-xs font-semibold">Tidak
                ada QR Code yang Belum Dipakai.</div>
        @endforelse
    </div>

    <h4
        class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-3 border-b border-slate-200 dark:border-gray-700 pb-1">
        Terpakai</h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-2">
        @forelse(collect($qrTokens)->where('status', 'USED') as $qr)
            <div class="flex flex-col">
                <div id="print-qr-{{ $qr->id }}"
                    class="bg-white text-slate-900 border-2 border-slate-300 rounded-t-lg p-4 flex flex-col items-center justify-center relative overflow-hidden shadow-sm">

                    <div class="w-full flex items-center justify-center gap-2 mb-3 pb-1.5 border-b border-slate-400">
                        <img src="{{ asset('images/icon.png') }}" class="w-5 h-5 object-contain">
                        <div class="text-left leading-none">
                            <p class="text-[7px] font-bold uppercase text-slate-700 tracking-wider">Pemerintah Kab.
                                Katingan</p>
                            <p class="text-[9px] font-black uppercase text-slate-900">Diskominfostandi</p>
                        </div>
                    </div>

                    <span
                        class="text-[8px] font-black uppercase tracking-widest text-slate-600 bg-slate-100 px-1.5 py-0.5 border border-slate-300 rounded mb-2.5">Terpakai</span>

                    <div class="p-1.5 bg-white rounded border border-slate-200 mb-2.5 shadow-inner grayscale">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('qr.scan', ['token' => $qr->token])) }}"
                            alt="QR Code" class="w-24 h-24 object-contain">
                    </div>

                    <p class="text-[7px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Pengguna
                        Terkunci:</p>
                    <span
                        class="w-full text-[9px] font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded p-1 text-center truncate mb-1"
                        title="{{ $qr->used_by_email }}">
                        {{ $qr->used_by_email }}
                    </span>
                </div>
                <button type="button"
                    @click="p_link = '{{ route('qr.scan', ['token' => $qr->token]) }}'; p_token = '{{ substr($qr->token, 4, 8) }}'; p_email = '{{ $qr->used_by_email }}'; p_status = 'USED'; modalPoster = true;"
                    class="w-full py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold uppercase tracking-wider border-x border-b border-slate-300 rounded-b-lg transition-colors flex items-center justify-center gap-1 cursor-pointer shadow-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Lihat Poster
                </button>
            </div>
        @empty
            <div class="col-span-full py-6 text-center text-slate-500 dark:text-gray-400 text-xs font-semibold">Tidak
                ada QR Code yang Terpakai.</div>
        @endforelse
    </div>

    <div x-show="modalPoster" style="display: none;"
        class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/80">
        <div x-show="modalPoster" x-transition.scale @click.away="modalPoster = false"
            class="relative w-full max-w-sm flex flex-col items-center">

            <button @click="modalPoster = false"
                class="absolute -top-10 right-0 text-white hover:text-rose-400 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div id="poster-qr-target"
                class="w-full bg-white p-6 rounded-2xl shadow-2xl border-4 border-slate-100 flex flex-col items-center text-center relative overflow-hidden">
                <img src="{{ asset('images/icon.png') }}" class="w-12 h-12 object-contain mb-2">
                <h2 class="text-[10px] font-bold uppercase text-slate-700 tracking-widest">Pemerintah Kab. Katingan
                </h2>
                <h1 class="text-base font-black uppercase text-slate-900 mb-4">Diskominfostandi</h1>

                <span
                    :class="p_status === 'ACTIVE' ? 'text-emerald-700 bg-emerald-50 border-emerald-200' :
                        'text-slate-600 bg-slate-100 border-slate-300'"
                    class="text-[10px] font-black uppercase tracking-widest px-2 py-1 border rounded mb-4"
                    x-text="p_status === 'ACTIVE' ? 'Sesi Akses Baru' : 'Akses Terkunci'"></span>

                <div class="p-2 bg-white rounded-xl border-2 border-slate-200 mb-4 shadow-sm flex items-center justify-center" :class="p_status === 'USED' ? 'grayscale opacity-75' : ''">
                    <img x-show="p_link" :src="p_link ? 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' + encodeURIComponent(p_link) : ''" crossorigin="anonymous" alt="QR Code" class="w-44 h-44 object-contain" style="display: none;">
                </div>

                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Tautan
                    Verifikasi Akses:</p>
                <div class="w-full text-[10px] font-mono font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded p-2 break-all"
                    x-text="p_link"></div>

                <div x-show="p_email" class="mt-4 w-full border-t border-slate-100 pt-4" style="display: none;">
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Terkunci
                        Untuk Pengguna:</p>
                    <p class="text-[10px] font-bold text-slate-800" x-text="p_email"></p>
                </div>
            </div>

            <button type="button" @click="downloadQRCard('poster-qr-target', 'QR_Akses_' + p_token, $event)"
                class="mt-6 w-full py-3 bg-slate-900 hover:bg-slate-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-colors flex items-center justify-center gap-2 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span class="btn-text">Unduh Poster (JPG)</span>
            </button>
        </div>
    </div>
</div>
