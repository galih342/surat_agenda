<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan - MPP Kab. Katingan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-white sm:bg-gray-100 text-gray-800 font-sans antialiased flex items-center justify-center min-h-screen sm:p-4">

    <!-- Container Utama: Fullscreen di Mobile, Card melayang di Desktop -->
    <div
        class="w-full min-h-screen sm:min-h-fit sm:max-w-lg bg-white sm:rounded-xl sm:shadow-[0_4px_20px_rgba(0,0,0,0.08)] sm:border sm:border-gray-200 flex flex-col overflow-hidden">

        <!-- Header / Kop Instansi Resmi -->
        <div class="bg-slate-900 px-6 pt-10 pb-8 sm:pt-8 sm:pb-6 border-b-4 border-amber-500 text-center flex-shrink-0">
            <img src="{{ asset('images/icon.png') }}" alt="Logo Instansi" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h1 class="text-white text-xs sm:text-sm font-semibold uppercase tracking-wider opacity-90">Pemerintah
                Kabupaten Katingan</h1>
            <h2 class="text-white text-lg sm:text-xl font-extrabold uppercase tracking-widest mt-1">OPD DUMMY
            </h2>
        </div>

        <!-- Area Konten Status -->
        <!-- Ditambahkan flex-1 dan justify-center agar di HP konten memusat vertikal dengan rapi -->
        <div class="p-6 sm:p-10 text-center flex-1 flex flex-col justify-center">

            {{-- 1. MENUNGGU PERSETUJUAN ADMIN --}}
            <div id="state-pending" class="block">

                <!-- Label Status Formal -->
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-widest mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Dokumen Terkirim
                </div>

                <!-- Ikon Menunggu Antrean (Statis & Formal) -->
                <div
                    class="mx-auto flex items-center justify-center w-20 h-20 bg-slate-50 text-slate-600 rounded-full mb-5 border-2 border-slate-200">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h3 class="text-xl sm:text-2xl font-bold text-slate-800 mb-3">Menunggu Verifikasi</h3>

                <!-- Kotak Informasi Formal -->
                <div class="bg-gray-50 border-l-4 border-slate-500 p-4 text-left mt-4 rounded-r-lg">
                    <p class="text-gray-600 text-sm leading-relaxed font-medium">
                        Pengajuan surat Anda telah masuk ke dalam antrean sistem administrasi. Mohon untuk <strong>tidak
                            menutup halaman ini</strong> selagi petugas kami melakukan proses verifikasi dokumen.
                    </p>
                </div>
            </div>

            {{-- 2. SURAT DITERIMA --}}
            <div id="state-diterima" class="hidden">
                <div
                    class="mx-auto flex items-center justify-center w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full mb-5 border-2 border-emerald-200">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>

                <h3 class="text-xl sm:text-2xl font-bold text-emerald-700 mb-3">Pengajuan Disetujui</h3>

                <div class="bg-emerald-50/50 border border-emerald-100 p-4 text-center mt-4 rounded-lg">
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        Pengajuan surat Anda telah memenuhi syarat administratif dan berhasil dijadwalkan ke dalam
                        sistem kami.
                    </p>
                </div>

                <a href="/"
                    class="mt-8 block w-full bg-slate-900 text-white px-6 py-3.5 rounded-lg font-bold text-sm tracking-wider uppercase hover:bg-slate-800 transition-colors shadow-sm">
                    Tutup Halaman
                </a>
            </div>

            {{-- 3. SURAT DITOLAK --}}
            <div id="state-ditolak" class="hidden">
                <div
                    class="mx-auto flex items-center justify-center w-20 h-20 bg-rose-50 text-rose-600 rounded-full mb-5 border-2 border-rose-200">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                <h3 class="text-xl sm:text-2xl font-bold text-rose-700 mb-3">Pengajuan Ditolak</h3>

                <div class="bg-rose-50/50 border border-rose-100 p-4 text-center mt-4 rounded-lg">
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        Mohon maaf, pengajuan surat Anda tidak dapat diproses saat ini. Silakan periksa kembali
                        kelengkapan lampiran dan informasi yang diberikan.
                    </p>
                </div>

                <a href="/"
                    class="mt-8 flex items-center justify-center gap-2 w-full bg-slate-100 text-slate-700 border border-slate-300 px-6 py-3.5 rounded-lg font-bold text-sm tracking-wider uppercase hover:bg-slate-200 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali Ke Form
                </a>
            </div>

        </div>
    </div>

    <!-- SCRIPT AJAX: SAMA SEKALI TIDAK DIUBAH -->
    <script>
        const suratId = "{{ $surat->id }}";

        function checkStatus() {
            fetch(`/pengajuan/status/${suratId}/check`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'diterima') {
                        // Sembunyikan loading, munculkan sukses
                        document.getElementById('state-pending').classList.replace('block', 'hidden');
                        document.getElementById('state-diterima').classList.replace('hidden', 'block');
                        clearInterval(pollingInterval); // Matikan pengecekan agar tidak berat
                    } else if (data.status === 'ditolak') {
                        // Sembunyikan loading, munculkan gagal
                        document.getElementById('state-pending').classList.replace('block', 'hidden');
                        document.getElementById('state-ditolak').classList.replace('hidden', 'block');
                        clearInterval(pollingInterval); // Matikan pengecekan
                    }
                })
                .catch(error => console.error("Gagal mengecek status:", error));
        }

        // Jalankan fungsi checkStatus setiap 3 detik secara background
        let pollingInterval = setInterval(checkStatus, 3000);
    </script>
</body>

</html>
