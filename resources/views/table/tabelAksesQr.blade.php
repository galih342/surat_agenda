<div class="overflow-x-auto w-full pb-4">
    <table class="w-full text-left border-collapse whitespace-nowrap">
        <thead>
            <tr class="bg-slate-50 dark:bg-gray-800/50 border-y border-slate-200 dark:border-gray-700">
                <th
                    class="py-3 px-4 text-[10px] sm:text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">
                    Token QR</th>
                <th
                    class="py-3 px-4 text-[10px] sm:text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">
                    Email Terkunci</th>
                <th
                    class="py-3 px-4 text-[10px] sm:text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">
                    Instansi Terkait</th>
                <th
                    class="py-3 px-4 text-[10px] sm:text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest text-right">
                    Aksi</th>
            </tr>
        </thead>
        
        <tbody class="divide-y divide-slate-100 dark:divide-gray-800/60 bg-white dark:bg-gray-800">
            @forelse(collect($qrTokens)->where('status', 'USED') as $qr)
                @php
                    $opd = $qr->used_by_email
                        ? \App\Models\PengajuanSurat::where('email_pengirim', $qr->used_by_email)->value('nama_opd') ??
                            'Belum ada pengajuan'
                        : 'Belum ada pengajuan';

                    // Cek apakah email ini ada di daftar blokir
                    $isBlocked = $qr->used_by_email
                        ? \App\Models\BlockedEmail::where('email', $qr->used_by_email)->exists()
                        : false;
                @endphp
                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-700/20 transition-colors">
                    <td class="py-3 px-4 text-xs font-bold text-slate-900 dark:text-gray-200">{{ $qr->token }}</td>

                    <td class="py-3 px-4 text-xs font-medium text-slate-600 dark:text-gray-400">
                        {{ $qr->used_by_email ?? '-' }}
                        @if ($isBlocked)
                            <span
                                class="ml-2 inline-flex px-1.5 py-0.5 text-[9px] font-black uppercase tracking-widest text-rose-700 bg-rose-100 border border-rose-200 rounded shadow-sm dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800">Diblokir</span>
                        @endif
                    </td>

                    <td class="py-3 px-4 text-xs font-bold text-slate-800 dark:text-gray-300 truncate max-w-[200px]">
                        {{ $opd }}</td>

                    <td class="py-3 px-4 flex justify-end gap-2">
                        @if ($isBlocked)
                            <form action="{{ route('qr.unblock', $qr->id) }}" method="POST"
                                onsubmit="return confirm('Buka blokir akses untuk email ini?');">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider border border-emerald-200 rounded transition-colors dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800">Buka
                                    Blokir</button>
                            </form>
                        @else
                            <form action="{{ route('qr.blokir', $qr->id) }}" method="POST"
                                onsubmit="return confirm('Blokir permanen akses untuk email ini?');">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-bold uppercase tracking-wider rounded transition-colors shadow-sm dark:bg-gray-700 dark:hover:bg-gray-600">Blokir</button>
                            </form>
                        @endif

                        <form action="{{ route('qr.hapus', $qr->id) }}" method="POST"
                            onsubmit="return confirm('Hapus permanen QR ini? Data yang terkait tidak akan bisa diakses via QR ini lagi.');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[10px] font-bold uppercase tracking-wider border border-rose-200 rounded transition-colors dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"
                        class="py-10 text-center text-slate-500 dark:text-gray-400 text-sm font-semibold">Tidak ada data
                        QR Code yang sudah dipakai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
