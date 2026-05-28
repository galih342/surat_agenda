<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Surat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .filepond--panel-root {
            background-color: #f8fafc !important;
            /* bg-slate-50 */
            border: 2px dashed #cbd5e1 !important;
            /* border-slate-300 */
            border-radius: 1rem !important;
            /* rounded-2xl */
        }

        .filepond--drop-label {
            color: #475569 !important;
            /* text-slate-600 */
            font-weight: 500;
        }

        .filepond--drop-label label {
            cursor: pointer;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-blue-50 text-slate-800 selection:bg-indigo-500 selection:text-white min-h-screen relative">

    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-100/50 to-transparent -z-10"></div>

    @if (Route::has('login'))
        <div class="absolute top-0 right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-slate-200 rounded-full text-sm font-semibold text-slate-600 hover:text-indigo-600 hover:shadow-sm transition-all">
                    Dashboard Admin
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-slate-200 rounded-full text-sm font-semibold text-slate-600 hover:text-indigo-600 hover:shadow-sm transition-all">
                    Login Admin
                </a>
            @endauth
        </div>
    @endif

    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-0">

        <div
            class="w-full max-w-3xl bg-white/90 backdrop-blur-xl p-8 sm:p-12 rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] shadow-indigo-200/50 border border-white">

            <div class="mb-10 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 mb-4 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <h1
                    class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 to-blue-500 tracking-tight">
                    Pengajuan Surat
                </h1>
                <p class="text-slate-500 mt-3 text-sm sm:text-base">
                    Silakan lengkapi formulir di bawah ini beserta dokumen pendukung yang diperlukan.
                </p>
            </div>

            <form action="{{ url('/simpan-surat') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="nama_opd" class="block font-semibold text-sm text-slate-700 mb-1.5">Nama OPD</label>
                    <input type="text" name="nama_opd" id="nama_opd" required
                        class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 shadow-sm focus:bg-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200"
                        placeholder="Masukkan nama Organisasi Perangkat Daerah">
                </div>

                <div>
                    <label for="perihal" class="block font-semibold text-sm text-slate-700 mb-1.5">Perihal
                        Surat</label>
                    <input type="text" name="perihal" id="perihal" required
                        class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 shadow-sm focus:bg-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200"
                        placeholder="Contoh: Undangan Rapat Koordinasi">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_acara" class="block font-semibold text-sm text-slate-700 mb-1.5">Tanggal
                            Acara</label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" required
                            class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 shadow-sm focus:bg-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 text-slate-600">

                        <span id="warning_tanggal" class="hidden text-xs text-red-500 mt-1.5 items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-3.5 h-3.5">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tanggal sudah lewat!
                        </span>
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-slate-700 mb-1.5">Jam Pelaksanaan</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="time" name="jam_mulai" id="jam_mulai" required
                                    class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 shadow-sm focus:bg-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 text-slate-600">
                                <span class="text-xs text-slate-400 mt-1 block">Dimulai</span>
                            </div>

                            <div class="relative">
                                <input type="time" name="jam_selesai" id="jam_selesai" required
                                    class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 shadow-sm focus:bg-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 text-slate-600 disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed">

                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-slate-400">Selesai</span>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="sampai_selesai" id="cek_sampai_selesai"
                                            class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50 w-3.5 h-3.5">
                                        <span class="ml-1.5 text-xs text-slate-500 font-medium">Sampai selesai</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <label for="surat" class="block font-semibold text-sm text-slate-700 mb-2">Upload File Surat
                        (Hanya PDF, Maks. 2MB)</label>
                    <input type="file" class="filepond" name="surat" id="surat" accept="application/pdf"
                        required>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl font-bold text-sm text-white shadow-lg shadow-indigo-200 hover:shadow-xl hover:from-indigo-700 hover:to-blue-700 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform transition-all duration-200 ease-in-out">
                        <span>Kirim Pengajuan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Daftarkan plugin validasi tipe dan ukuran
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize
            );

            const inputElement = document.querySelector('input[id="surat"]');

            FilePond.create(inputElement, {
                storeAsFile: true,
                labelIdle: 'Tarik & Letakkan file surat Anda di sini atau <span class="filepond--label-action text-indigo-600 hover:underline"> Telusuri </span>',
                credits: false,

                // Konfigurasi Validasi PDF dan Maks 2MB
                acceptedFileTypes: ['application/pdf'],
                labelFileTypeNotAllowed: 'Tipe file tidak valid',
                fileValidateTypeLabelExpectedTypes: 'Hanya menerima dokumen PDF',
                maxFileSize: '2MB',
                labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                labelMaxFileSize: 'Ukuran maksimum adalah {filesize}'
            });
        });

        // --- Validasi Real-time Tanggal Acara ---
        const tanggalInput = document.getElementById('tanggal_acara');
        const warningTanggal = document.getElementById('warning_tanggal');

        // Mendapatkan tanggal lokal hari ini dengan format YYYY-MM-DD
        const dateObj = new Date();
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
        const day = String(dateObj.getDate()).padStart(2, '0');
        const today = `${year}-${month}-${day}`;

        // Atribut 'min' otomatis mematikan (disable) tanggal sebelum hari ini di kalender bawaan browser
        tanggalInput.setAttribute('min', today);

        // Validasi jika user mengetik manual (real-time)
        tanggalInput.addEventListener('input', function() {
            if (this.value && this.value < today) {
                // Ubah border dan text menjadi merah, tampilkan warning
                this.classList.add('text-red-600', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
                this.classList.remove('text-slate-600', 'border-slate-200', 'focus:border-indigo-500',
                    'focus:ring-indigo-200');
                warningTanggal.classList.remove('hidden');
                warningTanggal.classList.add('flex');

                // (Opsional) Mengosongkan value jika ingin benar-benar memaksa user tidak bisa submit
                // this.value = ''; 
            } else {
                // Kembalikan ke style normal, sembunyikan warning
                this.classList.remove('text-red-600', 'border-red-500', 'focus:border-red-500',
                    'focus:ring-red-200');
                this.classList.add('text-slate-600', 'border-slate-200', 'focus:border-indigo-500',
                    'focus:ring-indigo-200');
                warningTanggal.classList.remove('flex');
                warningTanggal.classList.add('hidden');
            }
        });

        // --- Logika Checkbox "Sampai Selesai" ---
        const jamSelesaiInput = document.getElementById('jam_selesai');
        const cekSampaiSelesai = document.getElementById('cek_sampai_selesai');

        cekSampaiSelesai.addEventListener('change', function() {
            if (this.checked) {
                jamSelesaiInput.value = ''; // Kosongkan nilainya
                jamSelesaiInput.disabled = true; // Matikan inputnya (warna akan abu-abu otomatis karena Tailwind)
                jamSelesaiInput.removeAttribute('required'); // Hapus wajib isi agar form bisa dikirim
            } else {
                jamSelesaiInput.disabled = false; // Nyalakan lagi
                jamSelesaiInput.setAttribute('required', 'required'); // Wajibkan isi lagi
            }
        });
    </script>
</body>

</html>
