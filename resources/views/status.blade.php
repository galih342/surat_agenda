<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-white sm:bg-gray-100 text-gray-800 font-sans antialiased flex items-center justify-center min-h-screen sm:p-4">

    <!-- Container Utama: Fullscreen di Mobile, Card melayang di Desktop -->
    <div
        class="w-full min-h-screen sm:min-h-fit sm:max-w-3xl bg-white sm:rounded-xl sm:shadow-[0_4px_20px_rgba(0,0,0,0.08)] sm:border sm:border-slate-200 flex flex-col overflow-hidden">

        <div class="bg-slate-900 px-6 pt-10 pb-8 sm:pt-8 sm:pb-6 border-b-4 border-amber-500 text-center flex-shrink-0">
            <img src="{{ asset('images/icon.png') }}" alt="Logo Instansi" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h1 class="text-white text-xs sm:text-sm font-semibold uppercase tracking-wider opacity-90">Pemerintah
                Kabupaten Katingan</h1>
            <h2 class="text-white text-lg sm:text-xl font-extrabold uppercase tracking-widest mt-1">
                {{ $surats->first()->nama_opd ?? 'SISTEM PENGAJUAN AGENDA' }}
            </h2>
            <p class="text-slate-400 text-[10px] mt-2 font-bold tracking-widest uppercase">{{ $email }}</p>
        </div>

        <div class="p-5 sm:p-8 flex-1 flex flex-col bg-slate-50/50">

            <div class="flex items-center justify-between mb-6 border-b border-slate-200 pb-4">
                <h3 class="text-base sm:text-lg font-bold text-slate-800 uppercase tracking-wide">Status Dokumen Anda
                </h3>
                <span
                    class="px-3 py-1 bg-slate-200 text-slate-700 text-[10px] font-extrabold rounded-md tracking-widest uppercase shadow-sm">
                    {{ $surats->count() }} Surat
                </span>
            </div>

            <div class="space-y-4 overflow-y-auto max-h-[60vh] pr-2 custom-scrollbar">
                @forelse($surats as $item)
                    <div
                        class="p-4 sm:p-5 bg-white border border-slate-200 shadow-sm rounded-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:border-slate-300 hover:shadow">
                        <div class="flex-1">
                            <h4
                                class="font-extrabold text-slate-900 text-sm sm:text-base uppercase tracking-wider mb-1">
                                {{ $item->perihal }}</h4>
                            <div class="flex items-center gap-4 text-xs font-semibold text-slate-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>

                        <div id="badge-{{ $item->id }}" class="flex-shrink-0 flex sm:justify-end">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-extrabold uppercase tracking-widest animate-pulse">
                                <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Memuat...
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Belum ada dokumen yang
                            diajukan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- SCRIPT AJAX: SAMA SEKALI TIDAK DIUBAH -->
    <script>
        const emailPengirim = "{{ urlencode($email) }}";

        // Fungsi pembantu untuk membuat badge sesuai status
        function getBadgeHTML(status) {
            if (status === 'menunggu') {
                return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Menunggu Verifikasi
                        </span>`;
            } else if (status === 'diterima') {
                return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Disetujui
                        </span>`;
            } else if (status === 'ditolak') {
                return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-rose-50 border border-rose-200 text-rose-700 text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Ditolak
                        </span>`;
            } else {
                return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-100 border border-slate-300 text-slate-700 text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Selesai
                        </span>`;
            }
        }

        function checkStatus() {
            fetch(`/pengajuan/status/check?email=${emailPengirim}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let masihAdaAntrean = false;

                    // Loop data surat dari database dan perbarui badge di HTML
                    data.surats.forEach(surat => {
                        const badgeContainer = document.getElementById('badge-' + surat.id);
                        if (badgeContainer) {
                            badgeContainer.innerHTML = getBadgeHTML(surat.status);
                        }

                        // Cek apakah masih ada surat yang 'menunggu'
                        if (surat.status === 'menunggu') {
                            masihAdaAntrean = true;
                        }
                    });

                    // Jika SEMUA surat sudah diproses (tidak ada yang 'menunggu'), matikan interval agar server tidak berat
                    if (!masihAdaAntrean) {
                        clearInterval(pollingInterval);
                    }
                })
                .catch(error => console.error("Gagal mengecek status:", error));
        }

        // Panggil pertama kali langsung tanpa nunggu 3 detik
        checkStatus();

        // Jalankan fungsi checkStatus setiap 3 detik secara background
        let pollingInterval = setInterval(checkStatus, 3000);
    </script>
</body>

</html>
