<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - Portal Surat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans antialiased">

    <div
        class="w-full min-h-screen sm:min-h-fit sm:max-w-md bg-white sm:rounded-xl sm:shadow-[0_4px_20px_rgba(0,0,0,0.08)] sm:border sm:border-gray-200 flex flex-col overflow-hidden">

        <div class="bg-slate-900 px-6 pt-10 pb-8 sm:pt-8 sm:pb-6 border-b-4 border-amber-500 text-center flex-shrink-0">
            <img src="{{ asset('images/icon.png') }}" alt="Logo Instansi" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h1 class="text-white text-[10px] sm:text-xs font-semibold uppercase tracking-wider opacity-90">Pemerintah
                Kabupaten Katingan</h1>
            <h2 class="text-white text-base sm:text-lg font-extrabold uppercase tracking-widest mt-1">Portal Surat</h2>
        </div>

        <div class="p-8 sm:p-10 text-center flex flex-col items-center flex-1 justify-center bg-white">

            <div
                class="w-20 h-20 bg-rose-50 border-2 border-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>

            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-wider mb-3">Akses Ditolak
            </h1>

            <p class="text-sm text-slate-500 font-medium mb-8 leading-relaxed">
                Tautan QR Code ini telah dikunci karena sudah digunakan oleh instansi atau akun email lain. Demi
                keamanan dokumen, satu QR Code hanya berlaku untuk satu akun pengirim.
            </p>

            <div class="bg-slate-50 border border-slate-200 rounded-lg p-5 w-full text-left shadow-inner">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-[11px] text-slate-700 font-extrabold uppercase tracking-widest">Solusi</p>
                </div>
                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                    Silakan hubungi Admin instansi terkait untuk meminta tautan QR Code pengajuan yang baru.
                </p>
            </div>

        </div>
    </div>

</body>

</html>
