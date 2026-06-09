<div>
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
        <button x-show="selectedQr.length > 0" @click="executeBulk('{{ route('qr.bulk-hapus') ?? '#' }}', 'qr', 'DELETE')"
            class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-[10px] font-bold uppercase tracking-wider rounded shadow-sm transition-colors">
            Hapus Terpilih (<span x-text="selectedQr.length"></span>)
        </button>
    </div>

    <h4
        class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-3 mt-2 border-b border-slate-200 dark:border-gray-700 pb-1">
        Belum Dipakai</h4>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 p-2 mb-6">
        @forelse(collect($qrTokens)->where('status', 'ACTIVE') as $qr)
            <div
                class="bg-slate-50 dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg p-4 flex flex-col items-center justify-center shadow-sm relative group overflow-hidden">

                <input type="checkbox" value="{{ $qr->id }}" x-show="isBulkMode" x-model="selectedQr"
                    class="cb-qr absolute top-2 left-2 rounded border-slate-300 text-slate-900 focus:ring-slate-900 dark:bg-gray-700 dark:border-gray-600"
                    style="display: none;">

                <form action="{{ route('qr.hapus', $qr->id) }}" method="POST"
                    onsubmit="return confirm('Hapus QR ini?');" class="absolute top-2 right-2">
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

                <span
                    class="text-[9px] font-black uppercase tracking-widest text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 rounded mb-3">Belum
                    Dipakai</span>

                <div class="p-2 bg-white rounded shadow-sm border border-slate-100 mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('qr.scan', ['token' => $qr->token])) }}"
                        alt="QR Code" class="w-24 h-24 object-contain">
                </div>

                <span
                    class="text-[9px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mb-2 border-b border-emerald-200 dark:border-emerald-800/50 pb-1 w-full text-center truncate">
                    {{ substr($qr->token, 0, 15) }}...
                </span>

                <input type="text" readonly value="{{ route('qr.scan', ['token' => $qr->token]) }}"
                    onclick="this.select(); document.execCommand('copy'); alert('Link disalin!');"
                    class="w-full text-[10px] font-medium text-slate-600 dark:text-gray-300 bg-white dark:bg-gray-900 border border-slate-300 dark:border-gray-600 rounded text-center focus:ring-0 py-1.5 cursor-pointer shadow-sm hover:border-amber-400 transition-colors"
                    title="Klik untuk menyalin Link">
            </div>
        @empty
            <div class="col-span-full py-6 text-center text-slate-500 dark:text-gray-400 text-xs font-semibold">Tidak
                ada QR Code yang Belum Dipakai.</div>
        @endforelse
    </div>

    <h4
        class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-3 border-b border-slate-200 dark:border-gray-700 pb-1">
        Terpakai</h4>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 p-2">
        @forelse(collect($qrTokens)->where('status', 'USED') as $qr)
            <div
                class="bg-slate-50 dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg p-4 flex flex-col items-center justify-center shadow-sm relative group overflow-hidden opacity-80 hover:opacity-100 transition-opacity">

                <span
                    class="text-[9px] font-black uppercase tracking-widest text-slate-500 dark:text-gray-400 bg-slate-200 dark:bg-gray-700 px-2 py-0.5 rounded mb-3">Terpakai</span>

                <div class="p-2 bg-white rounded shadow-sm border border-slate-100 mb-3 grayscale">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('qr.scan', ['token' => $qr->token])) }}"
                        alt="QR Code" class="w-24 h-24 object-contain">
                </div>

                <span
                    class="text-[9px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mb-2 border-b border-emerald-200 dark:border-emerald-800/50 pb-1 w-full text-center truncate">
                    {{ substr($qr->token, 0, 15) }}...
                </span>

                <input type="text" readonly value="{{ route('qr.scan', ['token' => $qr->token]) }}"
                    onclick="this.select(); document.execCommand('copy'); alert('Link disalin!');"
                    class="w-full text-[10px] font-medium text-slate-600 dark:text-gray-300 bg-white dark:bg-gray-900 border border-slate-300 dark:border-gray-600 rounded text-center focus:ring-0 py-1.5 cursor-pointer shadow-sm hover:border-amber-400 transition-colors mb-2"
                    title="Klik untuk menyalin Link">

                <span
                    class="text-[9px] font-bold text-slate-500 dark:text-gray-400 w-full text-center truncate bg-slate-100 dark:bg-gray-900 rounded py-1 px-2 border border-slate-200 dark:border-gray-700"
                    title="{{ $qr->used_by_email }}">
                    {{ $qr->used_by_email }}
                </span>
            </div>
        @empty
            <div class="col-span-full py-6 text-center text-slate-500 dark:text-gray-400 text-xs font-semibold">Tidak
                ada QR Code yang Terpakai.</div>
        @endforelse
    </div>
</div>
