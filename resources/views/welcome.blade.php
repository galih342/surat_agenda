<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Tamu - Pengajuan Agenda</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .filepond--panel-root {
            background-color: #f8fafc !important;
            border: 2px dashed #cbd5e1 !important;
            border-radius: 0.5rem !important;
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

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-amber-200 selection:text-amber-900"
    x-data="portalData()">

    <header class="bg-slate-900 border-b-4 border-amber-500 sticky top-0 z-40 shadow-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon.png') }}" alt="Logo"
                    class="w-10 h-10 sm:w-12 sm:h-12 object-contain bg-white rounded-full p-1 shadow-sm">
                <div>
                    <h1
                        class="text-white text-[10px] sm:text-xs font-bold uppercase tracking-wider opacity-80 leading-none mb-1">
                        Pemerintah Kab. Katingan</h1>
                    <h2 class="text-white text-sm sm:text-lg font-black uppercase tracking-widest leading-none">Portal
                        Agenda</h2>
                </div>
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-amber-400 text-[10px] font-black uppercase tracking-widest">Akses Pengguna Terkunci</p>
                <p class="text-slate-300 text-xs font-bold truncate max-w-[200px]">{{ $email }}</p>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-6xl w-full mx-auto p-4 sm:p-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 shadow-sm animate-[pulse_1s_ease-in-out_2]">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4 class="text-sm font-black text-rose-900 uppercase tracking-wide">Pengajuan Ditolak Sistem!</h4>
                </div>
                <ul class="text-xs font-bold text-rose-700 list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex gap-2 sm:gap-4 mb-6 border-b border-slate-200 pb-px">
            <button @click="activeTab = 'riwayat'"
                :class="activeTab === 'riwayat' ? 'border-amber-500 text-slate-900' :
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="pb-3 px-2 sm:px-4 border-b-2 font-black text-xs sm:text-sm uppercase tracking-wider transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Riwayat Pengajuan
            </button>
            <button @click="activeTab = 'form'"
                :class="activeTab === 'form' ? 'border-amber-500 text-slate-900' :
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="pb-3 px-2 sm:px-4 border-b-2 font-black text-xs sm:text-sm uppercase tracking-wider transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajukan Surat Baru
            </button>
        </div>

        <div x-show="activeTab === 'riwayat'" x-cloak class="space-y-6">

            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 sm:gap-4">
                <div @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'ring-2 ring-slate-800 scale-[1.02]' : 'hover:scale-[1.02] border-slate-200'" class="bg-white p-4 rounded-xl border shadow-sm flex flex-col cursor-pointer transition-all">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Surat</span>
                    <span class="text-2xl font-black text-slate-800 mt-1">{{ $surats->count() }}</span>
                </div>
                <div @click="filterStatus = 'menunggu'" :class="filterStatus === 'menunggu' ? 'ring-2 ring-amber-500 scale-[1.02]' : 'hover:scale-[1.02] border-amber-200'" class="bg-amber-50 p-4 rounded-xl border shadow-sm flex flex-col cursor-pointer transition-all">
                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Menunggu</span>
                    <span class="text-2xl font-black text-amber-800 mt-1">{{ $surats->where('status', 'menunggu')->count() }}</span>
                </div>
                <div @click="filterStatus = 'diterima'" :class="filterStatus === 'diterima' ? 'ring-2 ring-emerald-500 scale-[1.02]' : 'hover:scale-[1.02] border-emerald-200'" class="bg-emerald-50 p-4 rounded-xl border shadow-sm flex flex-col cursor-pointer transition-all">
                    <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Disetujui</span>
                    <span class="text-2xl font-black text-emerald-800 mt-1">{{ $surats->where('status', 'diterima')->count() }}</span>
                </div>
                <div @click="filterStatus = 'ditolak'" :class="filterStatus === 'ditolak' ? 'ring-2 ring-rose-500 scale-[1.02]' : 'hover:scale-[1.02] border-rose-200'" class="bg-rose-50 p-4 rounded-xl border shadow-sm flex flex-col cursor-pointer transition-all">
                    <span class="text-[10px] font-black text-rose-700 uppercase tracking-widest">Ditolak</span>
                    <span class="text-2xl font-black text-rose-800 mt-1">{{ $surats->where('status', 'ditolak')->count() }}</span>
                </div>
                <div @click="filterStatus = 'batal'" :class="filterStatus === 'batal' ? 'ring-2 ring-slate-500 scale-[1.02]' : 'hover:scale-[1.02] border-slate-300'" class="bg-slate-100 p-4 rounded-xl border shadow-sm flex flex-col cursor-pointer transition-all">
                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Dibatalkan</span>
                    <span class="text-2xl font-black text-slate-800 mt-1">{{ $surats->where('status', 'batal')->count() }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Detail Dokumen Anda</h3>
                </div>
                <div class="p-4 space-y-3 max-h-[500px] overflow-y-auto custom-scrollbar">
                    @forelse($surats as $item)
                        <div id="item-{{ $item->id }}" data-status="{{ $item->status }}"
                            x-show="filterStatus === 'all' || filterStatus === $el.dataset.status"
                            class="p-4 bg-white border border-slate-200 rounded-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:border-slate-300 hover:shadow-md">
                            <div class="flex-1">
                                <h4 class="font-black text-slate-900 text-sm uppercase tracking-wider mb-1">
                                    {{ $item->perihal }}</h4>
                                <div class="flex items-center gap-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-3">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                
                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                    <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded transition-colors shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Dokumen
                                    </a>
                                    
                                    @if($item->status === 'menunggu')
                                    <form id="form-batal-{{ $item->id }}" action="{{ route('surat.batal-user', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menarik/membatalkan pengajuan ini?');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-[10px] font-black uppercase tracking-widest rounded transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Batalkan
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <div id="badge-{{ $item->id }}" class="flex-shrink-0 flex sm:justify-end">
                                </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Belum ada dokumen
                                yang diajukan.</p>
                            <button @click="activeTab = 'form'"
                                class="mt-4 px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-800 text-[10px] font-black uppercase tracking-widest rounded transition-colors">Mulai
                                Pengajuan</button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'form'" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 sm:p-8">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-wide">Formulir Agenda Baru</h3>
                    <p class="text-slate-500 text-xs font-semibold mt-1">Lengkapi data dan unggah dokumen surat
                        pengantar antar-OPD di bawah ini.</p>
                </div>

                <form action="{{ url('/simpan-surat') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div
                        class="bg-slate-50 border border-slate-200 p-5 rounded-xl grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="nama_opd"
                                class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2">Nama
                                Instansi / OPD Pengirim</label>
                            <input type="text" name="nama_opd" id="nama_opd" required readonly
                                value="{{ $opdTerakhir }}"
                                class="block w-full px-4 py-3 rounded-lg border-slate-200 bg-slate-100 shadow-inner text-sm font-bold text-slate-500 cursor-not-allowed outline-none"
                                title="Nama instansi telah dikunci secara permanen">
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label
                                    class="block font-black text-[10px] text-slate-600 uppercase tracking-widest">Email
                                    Akun</label>
                                <span
                                    class="text-[8px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-black tracking-widest uppercase flex items-center gap-1"><svg
                                        class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> Terverifikasi</span>
                            </div>
                            <input type="email" name="email_pengirim" value="{{ $email }}" readonly
                                class="block w-full px-4 py-3 rounded-lg border-slate-200 bg-slate-100 shadow-inner text-sm font-bold text-slate-500 cursor-not-allowed outline-none">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(item, index) in suratList" :key="item.id">
                            <div
                                class="p-5 border-2 border-slate-100 bg-white rounded-xl relative transition-all shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h4
                                        class="font-black text-slate-800 uppercase tracking-wider text-xs flex items-center gap-2">
                                        <span
                                            class="bg-slate-800 text-white w-6 h-6 flex items-center justify-center rounded-full text-[10px]"
                                            x-text="index + 1"></span>
                                        Data Dokumen
                                    </h4>
                                    <button type="button" x-show="suratList.length > 1"
                                        @click="removeSurat(item.id)"
                                        class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded text-[10px] font-black uppercase tracking-widest transition-colors">
                                        Hapus Surat
                                    </button>
                                </div>

                                <div class="mb-5">
                                    <label
                                        class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2">Perihal
                                        Surat</label>
                                    <input type="text" name="perihal[]" required
                                        class="block w-full px-4 py-3 rounded-lg border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-slate-800 focus:ring-2 focus:ring-slate-800/20 text-sm font-bold text-slate-900"
                                        placeholder="Contoh: Undangan Sosialisasi Program">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                    <div>
                                        <label
                                            class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2">Tanggal
                                            Acara</label>
                                        <input type="date" name="tanggal_acara[]" required :min="today"
                                            @input="validateDate($event)"
                                            class="block w-full px-4 py-3 rounded-lg border-slate-300 bg-slate-50 shadow-sm focus:border-slate-800 focus:ring-2 focus:ring-slate-800/20 text-sm font-bold text-slate-900 cursor-pointer">
                                        <span
                                            class="warning-tanggal hidden text-[10px] font-black tracking-widest text-rose-500 mt-1.5 items-center gap-1"><svg
                                                class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>Tanggal sudah lewat!</span>
                                    </div>
                                    <div>
                                        <label
                                            class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2">Waktu
                                            Pelaksanaan</label>
                                        <div class="flex items-center gap-2">
                                            <input type="time" name="jam_mulai[]" required
                                                class="block w-full px-3 py-3 rounded-lg border-slate-300 bg-slate-50 shadow-sm focus:border-slate-800 text-sm font-bold text-slate-900">
                                            <span class="font-black text-slate-300">-</span>
                                            <input type="time" name="jam_selesai[]" :disabled="item.sampaiSelesai"
                                                :required="!item.sampaiSelesai"
                                                class="block w-full px-3 py-3 rounded-lg border-slate-300 bg-slate-50 shadow-sm focus:border-slate-800 text-sm font-bold text-slate-900 disabled:opacity-50">
                                        </div>
                                        <div class="mt-2 flex justify-end">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="hidden" name="sampai_selesai_hidden[]"
                                                    :value="item.sampaiSelesai ? '1' : '0'">
                                                <input type="checkbox" x-model="item.sampaiSelesai"
                                                    @change="if(item.sampaiSelesai) $el.closest('.grid').querySelector('input[name=\'jam_selesai[]\']').value = ''"
                                                    class="rounded text-slate-800 focus:ring-slate-800 w-3.5 h-3.5">
                                                <span
                                                    class="ml-2 text-[9px] text-slate-500 font-black uppercase tracking-widest">Sampai
                                                    selesai</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <label
                                        class="block font-black text-[10px] text-slate-600 uppercase tracking-widest mb-2 flex items-center gap-1.5"><svg
                                            class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg> Lampiran Dokumen PDF (Maks 2MB)</label>
                                    <input type="file" name="surat[]" accept="application/pdf" required
                                        x-init="initFilePond($el)">
                                </div>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addSurat()"
                        class="w-full py-3.5 border-2 border-dashed border-slate-300 text-slate-500 font-black text-[10px] sm:text-xs uppercase tracking-widest rounded-xl hover:border-slate-500 hover:text-slate-800 hover:bg-slate-50 transition-all flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Agenda Lain
                    </button>

                    <div class="pt-6 mt-4 border-t border-slate-200">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-8 py-4 bg-slate-900 rounded-xl font-black text-xs sm:text-sm tracking-widest uppercase text-white hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                            Kirim Seluruh Dokumen
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <script>
        // 1. Inisialisasi Plugin FilePond
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
        });

        // 2. Alpine JS Data (Mengatur Tab & Form)
        document.addEventListener('alpine:init', () => {
            Alpine.data('portalData', () => ({
                // Jika ada session success, buka tab riwayat. Jika tidak, buka form.
                activeTab: '{{ session('success') ? 'riwayat' : 'form' }}',
                filterStatus: 'all', // Variabel penyimpan status filter
                suratList: [{
                    id: Date.now(),
                    sampaiSelesai: false
                }],
                today: new Date().toISOString().split('T')[0],

                addSurat() {
                    this.suratList.push({
                        id: Date.now(),
                        sampaiSelesai: false
                    });
                },
                removeSurat(id) {
                    this.suratList = this.suratList.filter(item => item.id !== id);
                },
                initFilePond(element) {
                    setTimeout(() => {
                        FilePond.create(element, {
                            storeAsFile: true,
                            labelIdle: '<span class="font-bold text-xs sm:text-sm text-slate-600 uppercase tracking-wider">Tap / Tarik PDF ke sini</span>',
                            credits: false,
                            acceptedFileTypes: ['application/pdf'],
                            maxFileSize: '2MB'
                        });
                    }, 50);
                },
                validateDate(event) {
                    const input = event.target;
                    const warning = input.parentElement.querySelector('.warning-tanggal');
                    if (input.value && input.value < this.today) {
                        input.classList.add('text-rose-600', 'border-rose-400');
                        warning.classList.remove('hidden');
                        warning.classList.add('flex');
                    } else {
                        input.classList.remove('text-rose-600', 'border-rose-400');
                        warning.classList.remove('flex');
                        warning.classList.add('hidden');
                    }
                }
            }));
        });

        // 3. Script Check Status Realtime AJAX (Pindah dari status.blade.php)
        const emailPengirim = "{{ urlencode($email) }}";

        function getBadgeHTML(status) {
            if (status === 'menunggu')
            return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-amber-50 text-amber-700 text-[9px] font-black uppercase tracking-widest"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Menunggu</span>`;
            if (status === 'diterima')
            return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-emerald-50 text-emerald-700 text-[9px] font-black uppercase tracking-widest"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Disetujui</span>`;
            if (status === 'ditolak')
            return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-rose-50 text-rose-700 text-[9px] font-black uppercase tracking-widest"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak</span>`;
            
            // TAMBAHAN: BADGE DIBATALKAN
            if (status === 'batal')
            return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-slate-200 text-slate-700 text-[9px] font-black uppercase tracking-widest"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg> Dibatalkan</span>`;
            
            // DEFAULT (Selesai)
            return `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-indigo-50 text-indigo-700 text-[9px] font-black uppercase tracking-widest"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Selesai</span>`;
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
                    data.surats.forEach(surat => {
                        const badgeContainer = document.getElementById('badge-' + surat.id);
                        const itemContainer = document.getElementById('item-' + surat.id);
                        const formBatal = document.getElementById('form-batal-' + surat.id);

                        if (badgeContainer) badgeContainer.innerHTML = getBadgeHTML(surat.status);
                        
                        // Update status untuk engine filter Alpine
                        if (itemContainer) itemContainer.dataset.status = surat.status;
                        
                        // Hilangkan tombol "Batalkan" kalau statusnya udah nggak "menunggu" lagi
                        if (formBatal && surat.status !== 'menunggu') {
                            formBatal.style.display = 'none';
                        }

                        if (surat.status === 'menunggu') masihAdaAntrean = true;
                    });
                    if (!masihAdaAntrean) clearInterval(pollingInterval);
                })
                .catch(error => console.error("Gagal mengecek status:", error));
        }

        checkStatus();
        let pollingInterval = setInterval(checkStatus, 3000);
    </script>
</body>

</html>
