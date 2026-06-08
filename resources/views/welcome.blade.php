<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Surat - DUMMY NAME</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Kontras FilePond Disesuaikan ke Tema Formal */
        .filepond--panel-root {
            background-color: #f8fafc !important;
            /* bg-slate-50 */
            border: 2px dashed #cbd5e1 !important;
            /* Garis putus-putus formal */
            border-radius: 0.5rem !important;
            /* Diubah jadi rounded-lg (lebih kotak) */
        }

        .filepond--drop-label {
            color: #475569 !important;
            font-weight: 600;
        }

        .filepond--drop-label label {
            cursor: pointer;
        }

        .filepond--root {
            font-family: 'figtree', sans-serif;
            margin-bottom: 0;
        }
    </style>
</head>

<body
    class="bg-white sm:bg-gray-100 text-slate-800 font-sans antialiased flex items-center justify-center min-h-screen sm:p-4 relative">

    {{-- Tombol Login Pengelola (Melayang) --}}
    @if (Route::has('login'))
        @guest
            <a href="{{ route('login') }}"
                class="fixed bottom-4 right-4 z-50 w-10 h-10 bg-white sm:bg-transparent rounded-full flex items-center justify-center text-slate-400 border border-gray-200 sm:border-none shadow-sm sm:shadow-none hover:bg-slate-200 hover:text-slate-600 transition-all duration-300 sm:opacity-50 sm:hover:opacity-100"
                title="Portal Pengelola">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </a>
        @endguest
    @endif

    <!-- Container Utama: Fullscreen di Mobile, Card melayang di Desktop -->
    <div
        class="w-full min-h-screen sm:min-h-fit sm:max-w-2xl bg-white sm:rounded-xl sm:shadow-[0_4px_20px_rgba(0,0,0,0.08)] sm:border sm:border-gray-200 flex flex-col overflow-hidden relative z-0">

        <!-- Header / Kop Instansi Resmi -->
        <div class="bg-slate-900 px-6 pt-10 pb-8 sm:pt-8 sm:pb-6 border-b-4 border-amber-500 text-center flex-shrink-0">
            <img src="{{ asset('images/icon.png') }}" alt="Logo Instansi" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h1 class="text-white text-xs sm:text-sm font-semibold uppercase tracking-wider opacity-90">Pemerintah
                Kabupaten Katingan</h1>
            <h2 class="text-white text-lg sm:text-xl font-extrabold uppercase tracking-widest mt-1">DUMMY NAME</h2>
        </div>

        <!-- Area Konten Form -->
        <div class="p-6 sm:p-8 flex-1 flex flex-col justify-center">

            <div class="mb-6 sm:mb-8 border-b border-gray-100 pb-4">
                <h3 class="text-lg sm:text-xl font-bold text-slate-800 uppercase tracking-wide">Formulir Pengajuan
                    Agenda</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-1 font-medium">Silakan lengkapi data dan unggah dokumen
                    surat pengantar antar-OPD di bawah ini.</p>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ url('/simpan-surat') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5 sm:space-y-6">
                @csrf

                <!-- Input Nama Instansi -->
                <div>
                    <label for="nama_opd"
                        class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2">Nama Instansi / OPD
                        Pengirim</label>
                    <input type="text" name="nama_opd" id="nama_opd" required
                        class="block w-full px-4 py-3 rounded-lg border-slate-300 bg-white shadow-sm hover:border-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm font-semibold text-slate-900 placeholder-slate-400"
                        placeholder="Contoh: Dinas Kesehatan">
                </div>

                <!-- Input Perihal -->
                <div>
                    <label for="perihal"
                        class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2">Perihal
                        Surat</label>
                    <input type="text" name="perihal" id="perihal" required
                        class="block w-full px-4 py-3 rounded-lg border-slate-300 bg-white shadow-sm hover:border-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm font-semibold text-slate-900 placeholder-slate-400"
                        placeholder="Contoh: Undangan Sosialisasi Program">
                </div>

                <!-- Area Tanggal dan Waktu -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:bg-slate-50 border border-transparent sm:border-slate-200 sm:p-5 sm:rounded-lg">

                    <!-- Tanggal Acara -->
                    <div>
                        <label for="tanggal_acara"
                            class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2">Tanggal
                            Acara</label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" required
                            class="block w-full px-4 py-3 rounded-lg border-slate-300 bg-white shadow-sm hover:border-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm font-semibold text-slate-900 cursor-pointer">

                        <span id="warning_tanggal"
                            class="hidden text-[11px] font-bold text-rose-500 mt-2 items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-3.5 h-3.5">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tanggal sudah lewat!
                        </span>
                    </div>

                    <!-- Waktu Pelaksanaan -->
                    <div>
                        <label class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2">Waktu
                            Pelaksanaan</label>
                        <div class="flex items-center gap-3">
                            <div class="w-full">
                                <input type="time" name="jam_mulai" id="jam_mulai" required
                                    class="block w-full px-3 py-3 rounded-lg border-slate-300 bg-white shadow-sm hover:border-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm font-semibold text-slate-900 cursor-pointer">
                                <span
                                    class="text-[10px] font-bold text-slate-500 mt-1 block text-center uppercase tracking-wider">Mulai</span>
                            </div>

                            <span class="text-slate-400 font-bold mb-5">-</span>

                            <div class="w-full">
                                <input type="time" name="jam_selesai" id="jam_selesai" required
                                    class="block w-full px-3 py-3 rounded-lg border-slate-300 bg-white shadow-sm hover:border-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm font-semibold text-slate-900 disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 disabled:cursor-not-allowed cursor-pointer">
                                <span
                                    class="text-[10px] font-bold text-slate-500 mt-1 block text-center uppercase tracking-wider">Selesai</span>
                            </div>
                        </div>

                        <!-- Checkbox Sampai Selesai -->
                        <div class="mt-2 flex justify-start sm:justify-end">
                            <label for="cek_sampai_selesai"
                                class="flex items-center cursor-pointer group py-1 hover:bg-transparent transition-colors">
                                <input type="checkbox" name="sampai_selesai" id="cek_sampai_selesai"
                                    class="rounded border-slate-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 w-4 h-4 cursor-pointer transition-all">
                                <span
                                    class="ml-2 text-xs text-slate-600 font-bold group-hover:text-slate-900 transition-colors">Sampai
                                    selesai</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="pt-2">
                    <label
                        class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Lampiran Dokumen PDF (Maks 2MB)
                    </label>
                    <input type="file" class="filepond shadow-sm" name="surat" id="surat"
                        accept="application/pdf" required>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-4 sm:pt-6">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-900 rounded-lg font-bold text-sm tracking-widest uppercase text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-500/30 transition-colors shadow-sm">
                        <span>Kirim Dokumen</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                    <p class="text-center text-[11px] font-medium text-slate-500 mt-4">
                        Pastikan seluruh data dan dokumen telah diverifikasi sebelum melakukan pengiriman.
                    </p>
                </div>
            </form>

        </div>
    </div>

    <!-- SCRIPT AJAX & LOGIKA JAVASCRIPT: SAMA SEKALI TIDAK DIUBAH -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize
            );

            const inputElement = document.querySelector('input[id="surat"]');

            FilePond.create(inputElement, {
                storeAsFile: true,
                labelIdle: '<span class="font-bold text-sm text-slate-600">Tap untuk memilih PDF <br><span class="text-xs text-slate-500 font-medium">atau seret file ke area ini</span></span>',
                credits: false,
                acceptedFileTypes: ['application/pdf'],
                labelFileTypeNotAllowed: 'Tipe file tidak valid',
                fileValidateTypeLabelExpectedTypes: 'Hanya menerima dokumen PDF',
                maxFileSize: '2MB',
                labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                labelMaxFileSize: 'Maksimum {filesize}'
            });
        });

        // --- Validasi Real-time Tanggal Acara ---
        const tanggalInput = document.getElementById('tanggal_acara');
        const warningTanggal = document.getElementById('warning_tanggal');

        const dateObj = new Date();
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
        const day = String(dateObj.getDate()).padStart(2, '0');
        const today = `${year}-${month}-${day}`;

        tanggalInput.setAttribute('min', today);

        tanggalInput.addEventListener('input', function() {
            if (this.value && this.value < today) {
                this.classList.add('text-rose-600', 'border-rose-400', 'focus:border-rose-500',
                    'focus:ring-rose-500/20');
                this.classList.remove('text-slate-900', 'border-slate-300', 'focus:border-indigo-500',
                    'focus:ring-indigo-500/20');
                warningTanggal.classList.remove('hidden');
                warningTanggal.classList.add('flex');
            } else {
                this.classList.remove('text-rose-600', 'border-rose-400', 'focus:border-rose-500',
                    'focus:ring-rose-500/20');
                this.classList.add('text-slate-900', 'border-slate-300', 'focus:border-indigo-500',
                    'focus:ring-indigo-500/20');
                warningTanggal.classList.remove('flex');
                warningTanggal.classList.add('hidden');
            }
        });

        // --- Logika Checkbox "Sampai Selesai" ---
        const jamSelesaiInput = document.getElementById('jam_selesai');
        const cekSampaiSelesai = document.getElementById('cek_sampai_selesai');

        cekSampaiSelesai.addEventListener('change', function() {
            if (this.checked) {
                jamSelesaiInput.value = '';
                jamSelesaiInput.disabled = true;
                jamSelesaiInput.removeAttribute('required');
            } else {
                jamSelesaiInput.disabled = false;
                jamSelesaiInput.setAttribute('required', 'required');
            }
        });
    </script>
</body>

</html>
