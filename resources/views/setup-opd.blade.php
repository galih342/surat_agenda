<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Instansi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-50 font-sans antialiased flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="bg-slate-900 p-6 border-b-4 border-amber-500 text-center">
            <h2 class="text-white text-lg font-black uppercase tracking-widest">Selamat Datang!</h2>
            <p class="text-slate-400 text-xs font-semibold mt-1">Sistem Pengajuan Agenda Katingan</p>
        </div>
        <div class="p-6">
            <div class="mb-6 text-center">
                <span
                    class="inline-block bg-amber-100 text-amber-800 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full mb-2">Langkah
                    1 dari 1</span>
                <p class="text-slate-600 text-sm font-bold">Silakan tetapkan nama Instansi / OPD Anda. <br><span
                        class="text-rose-500">Perhatian: Data ini hanya dapat diisi satu kali!</span></p>
            </div>
            <form action="{{ route('surat.store-setup') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2">Email
                        Akun</label>
                    <input type="email" value="{{ $email }}" disabled
                        class="block w-full px-4 py-3 rounded-lg border-slate-200 bg-slate-100 text-sm font-bold text-slate-500 cursor-not-allowed outline-none">
                </div>
                <div class="mb-6">
                    <label for="nama_opd"
                        class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2">Nama Instansi
                        / OPD Lengkap</label>
                    <input type="text" name="nama_opd" id="nama_opd" required autofocus autocomplete="off"
                        class="block w-full px-4 py-3 rounded-lg border-slate-300 bg-white shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-sm font-bold text-slate-900"
                        placeholder="Contoh: Dinas Diskominfostandi">
                </div>
                <button type="submit"
                    class="w-full bg-slate-900 text-white font-black text-sm uppercase tracking-widest py-4 rounded-xl hover:bg-slate-800 transition-colors shadow-md">
                    Simpan Permanen & Lanjut
                </button>
            </form>
        </div>
    </div>
</body>

</html>
