<x-app-layout>
    <div x-data="{ sidebarOpen: false, filterOpen: false, qrModalOpen: {{ session()->has('success_qr') ? 'true' : 'false' }} }" class="flex h-screen overflow-hidden bg-slate-50 dark:bg-gray-900 font-sans">

        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/60 z-20 md:hidden" style="display: none;">
        </div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 border-r border-slate-200 dark:border-gray-700 flex flex-col flex-shrink-0 z-30 shadow-[4px_0_24px_rgba(0,0,0,0.02)] md:relative md:translate-x-0 transition-transform duration-300">

            <div class="bg-slate-900 px-6 pt-8 pb-6 border-b-4 border-amber-500 text-center flex-shrink-0">
                <img src="{{ asset('images/icon.png') }}" alt="Logo Instansi"
                    class="w-12 h-12 mx-auto mb-2 object-contain">
                <h1 class="text-white text-[10px] font-semibold uppercase tracking-widest opacity-90">Pemerintah Kab.
                    Katingan</h1>
                <h2 class="text-white text-sm font-extrabold uppercase tracking-widest mt-1">Diskominfostandi</h2>
            </div>

            <nav class="flex-1 overflow-y-auto mt-2 px-4 space-y-1" x-data="{
                activeTab: localStorage.getItem('activeTabAdmin') || 'utama'
            }" x-init="setTimeout(() => switchTab(activeTab), 50)">

                <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3 mt-4">Menu Utama</p>

                <button @click="activeTab = 'utama'; switchTab('utama'); sidebarOpen = false"
                    :class="activeTab === 'utama' ?
                        'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                        'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                    class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 transition-colors"
                        :class="activeTab === 'utama' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    Tabel Utama
                </button>

                <button @click="activeTab = 'diterima'; switchTab('diterima'); sidebarOpen = false"
                    :class="activeTab === 'diterima' ?
                        'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                        'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                    class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group mt-1">
                    <svg class="w-5 h-5 mr-3 transition-colors"
                        :class="activeTab === 'diterima' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Jadwal Diterima
                </button>

                <button @click="activeTab = 'ditolak'; switchTab('ditolak'); sidebarOpen = false"
                    :class="activeTab === 'ditolak' ?
                        'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                        'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                    class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group mt-1">
                    <svg class="w-5 h-5 mr-3 transition-colors"
                        :class="activeTab === 'ditolak' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Surat Ditolak
                </button>

                <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3 mt-6">Riwayat Agenda
                </p>

                <button @click="activeTab = 'selesai'; switchTab('selesai'); sidebarOpen = false"
                    :class="activeTab === 'selesai' ?
                        'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                        'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                    class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 transition-colors"
                        :class="activeTab === 'selesai' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Agenda Selesai
                </button>

                <button @click="activeTab = 'batal'; switchTab('batal'); sidebarOpen = false"
                    :class="activeTab === 'batal' ?
                        'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                        'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                    class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group mt-1">
                    <svg class="w-5 h-5 mr-3 transition-colors"
                        :class="activeTab === 'batal' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                        </path>
                    </svg>
                    Agenda Dibatalkan
                </button>

                @role('super-admin')
                    <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3 mt-6">Pengaturan</p>

                    <button @click="activeTab = 'akun'; switchTab('akun'); sidebarOpen = false"
                        :class="activeTab === 'akun' ?
                            'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                            'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                        class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 transition-colors"
                            :class="activeTab === 'akun' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Manajemen Akun
                    </button>

                    <button @click="activeTab = 'kelola-akses'; switchTab('kelola-akses'); sidebarOpen = false"
                        :class="activeTab === 'kelola-akses' ?
                            'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                            'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                        class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group mt-1">
                        <svg class="w-5 h-5 mr-3 transition-colors"
                            :class="activeTab === 'kelola-akses' ? 'text-slate-800' :
                                'text-slate-400 group-hover:text-slate-500'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Kelola Akses QR
                    </button>

                    <button @click="activeTab = 'qr-gallery'; switchTab('qr-gallery'); sidebarOpen = false"
                        :class="activeTab === 'qr-gallery' ?
                            'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400' :
                            'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700'"
                        class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group mt-1">
                        <svg class="w-5 h-5 mr-3 transition-colors"
                            :class="activeTab === 'qr-gallery' ? 'text-slate-800' : 'text-slate-400 group-hover:text-slate-500'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Galeri QR
                    </button>

                    <p class="px-4 text-[11px] font-bold text-rose-400 uppercase tracking-wider mb-3 mt-6">Tong Sampah</p>

                    <button @click="activeTab = 'sampah'; switchTab('sampah'); sidebarOpen = false"
                        :class="activeTab === 'sampah' ? 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' :
                            'bg-slate-100 text-slate-900 border-l-4 border-slate-800 font-bold dark:bg-slate-800 dark:text-white dark:border-slate-400'"
                        class="flex items-center w-full px-4 py-3 rounded-r-md font-semibold transition-all duration-200 group mb-6">
                        <svg class="w-5 h-5 mr-3 transition-colors"
                            :class="activeTab === 'sampah' ? 'text-rose-600' : 'text-slate-400 group-hover:text-slate-500'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Surat Sampah
                    </button>
                @endrole
            </nav>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-gray-900">

            <header
                class="h-20 sm:h-24 flex items-center justify-between px-4 sm:px-10 z-10 flex-shrink-0 bg-white dark:bg-gray-900 sm:bg-transparent sm:dark:bg-transparent border-b border-slate-200 dark:border-gray-700 sm:border-none">
                <style>
                    main.overflow-y-auto {
                        overflow-y: auto;
                        overflow-y: overlay;
                    }

                    ::-webkit-scrollbar {
                        width: 5px;
                        height: 8px;
                    }

                    ::-webkit-scrollbar-track {
                        background: transparent;
                    }

                    ::-webkit-scrollbar-thumb {
                        background-color: rgba(203, 213, 225, 0.6);
                        border-radius: 10px;
                    }

                    ::-webkit-scrollbar-thumb:hover {
                        background-color: rgba(148, 163, 184, 0.9);
                    }

                    .dark ::-webkit-scrollbar-thumb {
                        background-color: rgba(71, 85, 105, 0.6);
                    }

                    .dark ::-webkit-scrollbar-thumb:hover {
                        background-color: rgba(100, 116, 139, 0.9);
                    }
                </style>

                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true"
                        class="md:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-md focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="hidden sm:block w-1.5 h-8 bg-amber-500 rounded-sm"></div>
                    <div>
                        <h1
                            class="text-lg sm:text-2xl font-extrabold text-slate-900 dark:text-white uppercase tracking-wider leading-none">
                            Dashboard</h1>
                        <p
                            class="text-[10px] sm:text-xs font-bold text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1.5 uppercase tracking-wide">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <div x-show="qrModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div
                        class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="qrModalOpen" x-transition.opacity @click="qrModalOpen = false"
                            class="fixed inset-0 transition-opacity bg-slate-900/75 dark:bg-gray-900/90"
                            aria-hidden="true">
                        </div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            aria-hidden="true">&#8203;</span>

                        <div x-show="qrModalOpen" x-transition.scale
                            class="relative z-10 inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-slate-200 dark:border-gray-700">
                            <div class="absolute top-0 right-0 pt-4 pr-4">
                                <button @click="qrModalOpen = false" type="button"
                                    class="text-slate-400 bg-white dark:bg-gray-800 rounded-md hover:text-slate-500 focus:outline-none transition-colors">
                                    <span class="sr-only">Tutup</span>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-emerald-100 dark:bg-emerald-900/30 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-white uppercase tracking-wide"
                                        id="modal-title">Akses Portal Surat</h3>
                                    <div class="mt-2">
                                        <p class="text-xs font-medium text-slate-500 dark:text-gray-400">Buat QR Code
                                            dan
                                            tautan sekali pakai untuk diberikan kepada instansi yang ingin mengajukan
                                            surat
                                            baru.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 sm:mt-6 border-t border-slate-100 dark:border-gray-700 pt-5">
                                <form action="{{ route('surat.qr-generate') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-xs font-extrabold uppercase tracking-widest text-white bg-slate-900 hover:bg-slate-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">
                                        Generate QR Baru
                                    </button>
                                </form>

                                @if (session('success_qr'))
                                    <div class="mt-6 flex flex-col items-center">
                                        <div id="print-modal-qr"
                                            class="w-full max-w-[280px] bg-white p-5 rounded-lg border-2 border-slate-300 text-center shadow-sm">
                                            <div
                                                class="flex items-center justify-center gap-3 mb-3 pb-2 border-b-2 border-slate-800">
                                                <img src="{{ asset('images/icon.png') }}" alt="Logo"
                                                    class="w-7 h-7 object-contain">
                                                <div class="text-left leading-none">
                                                    <p
                                                        class="text-[9px] font-bold uppercase text-slate-800 tracking-wider">
                                                        Pemerintah Kab. Katingan</p>
                                                    <p class="text-[11px] font-black uppercase text-slate-900 mt-0.5">
                                                        Diskominfostandi</p>
                                                </div>
                                            </div>

                                            <p
                                                class="text-[9px] font-black text-emerald-700 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 inline-block mb-3">
                                                Sesi Akses Baru</p>

                                            <div
                                                class="p-2 bg-white rounded border border-slate-200 inline-block mb-3 shadow-sm">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(session('success_qr')) }}"
                                                    alt="QR Code Link" class="w-36 h-36 object-contain">
                                            </div>

                                            <p
                                                class="text-[8px] font-bold uppercase tracking-wider text-slate-400 leading-none mb-1">
                                                Tautan Resmi Akses:</p>
                                            <p
                                                class="text-[9px] font-mono font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded p-1.5 break-all select-all">
                                                {{ session('success_qr') }}</p>
                                        </div>

                                        <div class="w-full max-w-[280px] mt-4 flex gap-2">
                                            <button type="button"
                                                onclick="downloadQRCard('print-modal-qr', 'QR_Akses_Baru_OPD_Dummy')"
                                                class="flex-1 flex justify-center items-center gap-1.5 py-2 px-3 rounded-md shadow-sm text-xs font-bold uppercase tracking-wider text-white bg-emerald-600 hover:bg-emerald-700 transition-colors cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                    </path>
                                                </svg>
                                                Download JPG
                                            </button>
                                            <button type="button"
                                                onclick="navigator.clipboard.writeText('{{ session('success_qr') }}'); alert('Link disalin!');"
                                                class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 rounded-md transition-colors cursor-pointer"
                                                title="Salin Link">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 10h5m-5-4h5">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">

                    @role('super-admin')
                        <button @click="qrModalOpen = true"
                            class="flex items-center gap-2 px-3 py-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-md hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors shadow-sm focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-wider hidden sm:block">Akses QR</span>
                        </button>
                    @endrole

                    <div
                        class="text-right hidden sm:block border-l border-slate-200 dark:border-gray-700 pl-4 sm:pl-6">
                        <p
                            class="text-sm font-bold text-slate-900 dark:text-white leading-tight uppercase tracking-wide">
                            {{ auth()->user()->name }}
                        </p>
                        <p
                            class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-0.5">
                            {{ auth()->user()->hasRole('super-admin') ? 'Super Admin' : 'Admin' }}
                        </p>
                    </div>

                    <div x-data="{ openProfile: false }" class="relative">
                        <button @click="openProfile = !openProfile" @click.away="openProfile = false"
                            class="flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-md bg-white sm:bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-slate-500/30 cursor-pointer dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-700">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>

                        <div x-show="openProfile" x-transition.origin.top.right style="display: none;"
                            class="absolute right-0 mt-3 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden z-50">

                            <div
                                class="block sm:hidden px-4 py-3 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50 dark:bg-slate-800/50">
                                <p
                                    class="text-sm font-bold text-slate-900 dark:text-white truncate uppercase tracking-wide">
                                    {{ auth()->user()->name }}
                                </p>
                                <p
                                    class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest truncate mt-0.5">
                                    {{ auth()->user()->hasRole('super-admin') ? 'Super Admin' : 'Admin' }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 dark:text-rose-400 dark:hover:bg-rose-900/20 transition-colors flex items-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 px-4 sm:px-10 pb-10 pt-4 sm:pt-0 w-full max-w-7xl mx-auto">

                <div
                    class="mb-6 bg-white dark:bg-gray-800 rounded-md border border-slate-200 dark:border-gray-700 shadow-sm transition-all overflow-hidden">

                    <button type="button" @click="filterOpen = !filterOpen"
                        class="w-full md:hidden px-4 py-3 flex items-center justify-between bg-slate-50 border-b border-slate-200 text-slate-700">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-wider">Filter & Pencarian</span>
                        </div>
                        <svg :class="filterOpen ? 'rotate-180' : ''"
                            class="w-4 h-4 text-slate-500 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <form action="{{ url()->current() }}" method="GET"
                        :class="filterOpen ? 'flex' : 'hidden md:flex'"
                        class="p-4 flex-col md:flex-row gap-4 items-end bg-white dark:bg-gray-800">

                        <div class="flex-1 w-full">
                            <label for="search"
                                class="block text-[10px] sm:text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Cari
                                Data</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-slate-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Ketik nama instansi atau perihal..."
                                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-600 rounded-md text-slate-800 dark:text-gray-300 focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all font-medium text-sm placeholder-slate-400">
                            </div>
                        </div>

                        <div class="w-full md:w-52">
                            <label for="tanggal"
                                class="block text-[10px] sm:text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Filter
                                Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                                class="w-full px-3 py-2 bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-600 rounded-md text-slate-800 dark:text-gray-300 focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all font-medium text-sm cursor-pointer">
                        </div>

                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <button type="submit"
                                class="flex-1 md:flex-none px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-md shadow-sm transition-all cursor-pointer flex items-center justify-center gap-2">
                                Terapkan
                            </button>

                            @if (request('search') || request('tanggal'))
                                <a href="{{ route('dashboard') }}"
                                    class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 dark:text-rose-400 font-bold text-xs uppercase tracking-wider rounded-md border border-rose-200 dark:border-rose-800 transition-all text-center flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-md shadow-sm border border-slate-200 dark:border-gray-700/50 overflow-hidden">
                    <div class="py-6 px-4 sm:px-6">

                        <div id="wadah-tabel-ajax" x-data="{
                            // 1. STATE BARU UNTUK TOGGLE
                            isBulkMode: false,
                        
                            // 2. FUNGSI MEMATIKAN BULK MODE & MEMBERSIHKAN DATA
                            toggleBulkMode() {
                                this.isBulkMode = !this.isBulkMode;
                                if (!this.isBulkMode) {
                                    this.selectedUtama = [];
                                    this.selectedDiterima = [];
                                    this.selectedDitolak = [];
                                    this.selectedSelesai = [];
                                    this.selectedBatal = [];
                                    this.selectedSampahDitolak = [];
                                    this.selectedSampahSelesai = [];
                                    this.selectedSampahBatal = [];
                                    this.selectedAdmin = [];
                                    this.selectedQr = [];
                                }
                            },
                        
                            selectedUtama: [],
                            selectedDiterima: [],
                            selectedDitolak: [],
                            selectedSelesai: [],
                            selectedBatal: [],
                            selectedSampahDitolak: [],
                            selectedSampahSelesai: [],
                            selectedSampahBatal: [],
                            selectedAdmin: [],
                            selectedQr: [],
                        
                            // Fungsi Cerdas Select All
                            toggleAll(type) {
                                let varName = 'selected' + type.charAt(0).toUpperCase() + type.slice(1);
                                let checkboxes = document.querySelectorAll('.cb-' + type);
                                let pageIds = Array.from(checkboxes).map(cb => cb.value);
                        
                                let allChecked = pageIds.length > 0 && pageIds.every(id => this[varName].includes(id));
                        
                                if (allChecked) {
                                    this[varName] = this[varName].filter(id => !pageIds.includes(id));
                                } else {
                                    pageIds.forEach(id => {
                                        if (!this[varName].includes(id)) {
                                            this[varName].push(id);
                                        }
                                    });
                                }
                            },
                        
                            // Cek apakah semua di halaman ini sudah tercentang
                            isAllChecked(type) {
                                let varName = 'selected' + type.charAt(0).toUpperCase() + type.slice(1);
                                let checkboxes = document.querySelectorAll('.cb-' + type);
                                if (checkboxes.length === 0) return false;
                        
                                let pageIds = Array.from(checkboxes).map(cb => cb.value);
                                return pageIds.every(id => this[varName].includes(id));
                            },
                        
                            // Fungsi Eksekusi Data Massal via AJAX
                            executeBulk(url, type, methodInput) {
                                let ids = this['selected' + type.charAt(0).toUpperCase() + type.slice(1)];
                                if (ids.length === 0) return;
                        
                                if (!confirm('Yakin ingin memproses ' + ids.length + ' data yang dipilih?')) return;
                        
                                fetch(url, {
                                        // GANTI KE methodInput agar langsung mengirim PATCH atau DELETE
                                        method: methodInput.toUpperCase(),
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '{{ csrf_token() }}',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: JSON.stringify({
                                            ids: ids // _method sudah dihapus dari sini karena tidak berlaku di JSON
                                        })
                                    })
                                    .then(response => {
                                        if (response.status === 419 || response.status === 401) {
                                            throw new Error('Sesi telah berakhir (419). Silakan refresh halaman (F5).');
                                        }
                                        if (!response.ok) {
                                            throw new Error('Gagal menghubungi server (Error ' + response.status + ')');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] = [];
                                            window.location.reload();
                                        } else {
                                            alert('Gagal: ' + (data.message || 'Alasan tidak diketahui'));
                                        }
                                    }).catch(error => {
                                        console.error('Gagal memproses bulk action:', error);
                                        alert(error.message || 'Terjadi kesalahan jaringan/sistem.');
                                    });
                            }
                        }">

                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-slate-200 dark:border-gray-700 pb-4">
                                <h3 id="judul-tabel"
                                    class="text-lg sm:text-xl font-bold text-slate-900 dark:text-gray-100 uppercase tracking-wide">
                                    Daftar Pengajuan Surat (Menunggu)
                                </h3>

                                <button type="button" @click="toggleBulkMode()"
                                    :class="isBulkMode ? 'bg-slate-800 text-white shadow-sm hover:bg-slate-900' :
                                        'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 border border-slate-200'"
                                    class="px-4 py-2 rounded-md text-xs sm:text-sm uppercase tracking-wider font-bold transition-all flex items-center justify-center gap-2 cursor-pointer w-full sm:w-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                    <span x-text="isBulkMode ? 'Tutup Mode Pilih' : 'Pilih Banyak Data'"></span>
                                </button>
                            </div>

                            <div id="konten-utama">
                                @include('table.tabelSurat', ['surat' => $suratUtama])
                            </div>
                            <div id="konten-diterima" class="hidden">
                                @include('table.tabelDiterima', ['surat' => $suratDiterima])
                            </div>
                            <div id="konten-ditolak" class="hidden">
                                @include('table.tabelDitolak', ['surat' => $suratDitolak])
                            </div>
                            <div id="konten-selesai" class="hidden">
                                @include('table.tabelSelesai', ['surat' => $suratSelesai])
                            </div>
                            <div id="konten-batal" class="hidden">
                                @include('table.tabelBatal', ['surat' => $suratBatal])
                            </div>

                            @role('super-admin')
                                <div id="konten-akun" class="hidden">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-slate-200 dark:border-gray-700 pb-4">

                                        <a href="{{ route('admin.create') }}"
                                            class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs uppercase tracking-wider font-bold rounded-md shadow-sm transition-colors flex items-center justify-center gap-2 w-full sm:w-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Tambah Admin
                                        </a>
                                    </div>

                                    @include('table.tabelAdmin', ['admins' => $admins ?? []])
                                </div>

                                <div id="konten-kelola-akses" class="hidden">
                                    @include('table.tabelAksesQr', ['qrTokens' => $qrTokens ?? []])
                                </div>

                                <div id="konten-qr-gallery" class="hidden">
                                    @include('table.tabelQrGallery', ['qrTokens' => $qrTokens ?? []])
                                </div>

                                <div id="konten-sampah" class="hidden">
                                    <div class="flex flex-col sm:flex-row gap-2 mb-6 border-b border-slate-200 dark:border-gray-700 pb-4 overflow-x-auto"
                                        x-data="{ subTab: localStorage.getItem('activeSubTabAdmin') || 'ditolak' }" x-init="setTimeout(() => switchSubTab(subTab), 50)">
                                        <button @click="subTab = 'ditolak'; switchSubTab('ditolak')"
                                            :class="subTab === 'ditolak' ?
                                                'bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-900/50 dark:text-rose-400' :
                                                'bg-white border border-slate-200 text-slate-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-gray-700'"
                                            class="px-4 py-2 rounded-md text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap">
                                            Surat Ditolak
                                        </button>
                                        <button @click="subTab = 'selesai'; switchSubTab('selesai')"
                                            :class="subTab === 'selesai' ?
                                                'bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-900/50 dark:text-rose-400' :
                                                'bg-white border border-slate-200 text-slate-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-gray-700'"
                                            class="px-4 py-2 rounded-md text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap">
                                            Agenda Selesai
                                        </button>
                                        <button @click="subTab = 'batal'; switchSubTab('batal')"
                                            :class="subTab === 'batal' ?
                                                'bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-900/50 dark:text-rose-400' :
                                                'bg-white border border-slate-200 text-slate-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-gray-700'"
                                            class="px-4 py-2 rounded-md text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap">
                                            Agenda Dibatalkan
                                        </button>
                                    </div>

                                    <div id="sub-sampah-ditolak">
                                        @include('table.tabelsampah', [
                                            'surat' => $sampahDitolak,
                                            'tipe' => 'sampahDitolak',
                                        ])
                                    </div>
                                    <div id="sub-sampah-selesai" class="hidden">
                                        @include('table.tabelsampah', [
                                            'surat' => $sampahSelesai,
                                            'tipe' => 'sampahSelesai',
                                        ])
                                    </div>
                                    <div id="sub-sampah-batal" class="hidden">
                                        @include('table.tabelsampah', [
                                            'surat' => $sampahBatal,
                                            'tipe' => 'sampahBatal',
                                        ])
                                    </div>

                                </div>
                            @endrole
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        let activeMenu = 'utama';
        // Memori Penyimpanan Halaman Paginasi
        let memoryPages = {
            'p_utama': 1,
            'p_diterima': 1,
            'p_ditolak': 1,
            'p_selesai': 1,
            'p_batal': 1,
            's_ditolak': 1,
            's_selesai': 1,
            's_batal': 1
        };

        // Cek URL saat web pertama dibuka untuk inisialisasi memori
        let currentUrlParams = new URLSearchParams(window.location.search);
        for (let key in memoryPages) {
            if (currentUrlParams.has(key)) memoryPages[key] = currentUrlParams.get(key);
        }

        function switchTab(tab) {
            // 1. CEK FALLBACK: Kalau tab yang diminta nggak ada di HTML (karena dibatasi role), paksa balik ke 'utama'
            let targetEl = document.getElementById('konten-' + tab);
            if (!targetEl) {
                tab = 'utama';
                targetEl = document.getElementById('konten-utama');
            }

            activeMenu = tab;
            // SIMPAN INGATAN: Simpan tab yang sedang aktif ke penyimpanan browser
            localStorage.setItem('activeTabAdmin', tab);

            // 2. Sembunyikan semua tab (DENGAN PENGECEKAN AMAN)
            ['utama', 'diterima', 'ditolak', 'selesai', 'batal', 'sampah', 'akun', 'kelola-akses', 'qr-gallery'].forEach(
                t => {
                    let el = document.getElementById('konten-' + t);
                    if (el) { // Cuma di-hidden KALA ELEMENNYA ADA
                        el.classList.add('hidden');
                    }
                });

            // 3. Munculkan yang aktif
            targetEl.classList.remove('hidden');

            const titles = {
                'utama': 'Daftar Pengajuan Surat (Menunggu)',
                'diterima': 'Daftar Penjadwalan (Diterima)',
                'ditolak': 'Daftar Surat Ditolak',
                'selesai': 'Riwayat Agenda Selesai',
                'batal': 'Riwayat Agenda Dibatalkan',
                'sampah': 'Tong Sampah: Arsip Terhapus',
                'akun': 'Manajemen Akun Admin',
                'kelola-akses': 'Manajemen Akses QR',
                'qr-gallery': 'Galeri QR Code Aktif'
            };

            let titleEl = document.getElementById('judul-tabel');
            if (titleEl) {
                titleEl.innerText = titles[tab];
            }
        }

        // Fungsi Top Bar Tong Sampah
        function switchSubTab(subTab) {
            // SIMPAN INGATAN: Simpan sub-tab sampah yang sedang aktif ke penyimpanan browser
            localStorage.setItem('activeSubTabAdmin', subTab);

            ['ditolak', 'selesai', 'batal'].forEach(t => {
                document.getElementById('sub-sampah-' + t).classList.add('hidden');
            });
            document.getElementById('sub-sampah-' + subTab).classList.remove('hidden');
        }

        // Handler Klik Paginasi Tanpa Reload Halaman (AJAX)
        document.addEventListener('click', function(e) {
            let paginationLink = e.target.closest('nav div a, nav a');
            if (!paginationLink) return;

            let rawUrl = paginationLink.getAttribute('href');
            if (!rawUrl) return;

            if (window.location.protocol === 'https:') {
                rawUrl = rawUrl.replace('http://', 'https://');
            }
            // Pastikan URL menggunakan HTTPS jika pakai Ngrok
            // rawUrl = rawUrl.replace('http://', 'https://');
            e.preventDefault();

            // 1. CARI TAHU POSISI KLIK: Deteksi di wadah tabel mana tombol paginasi ini berada
            let container = paginationLink.closest('div[id^="konten-"], div[id^="sub-sampah-"]');
            if (!container) return;

            let targetContainerId = container.id;
            let targetParam = '';

            // 2. PETAKAN WADAH KE PARAMETER: Pastikan kita hanya mengambil parameter yang relevan
            if (targetContainerId === 'konten-utama') targetParam = 'p_utama';
            else if (targetContainerId === 'konten-diterima') targetParam = 'p_diterima';
            else if (targetContainerId === 'konten-ditolak') targetParam = 'p_ditolak';
            else if (targetContainerId === 'konten-selesai') targetParam = 'p_selesai';
            else if (targetContainerId === 'konten-batal') targetParam = 'p_batal';
            else if (targetContainerId === 'sub-sampah-ditolak') targetParam = 's_ditolak';
            else if (targetContainerId === 'sub-sampah-selesai') targetParam = 's_selesai';
            else if (targetContainerId === 'sub-sampah-batal') targetParam = 's_batal';

            if (!targetParam) return;

            // 3. FILTER URL: Buang parameter nyasar & Simpan ke Memori
            let urlObj = new URL(rawUrl);
            let params = new URLSearchParams(urlObj.search);
            let cleanParams = new URLSearchParams();

            // AMANKAN FILTER: Bawa nilai search dan tanggal jika ada
            if (params.has('search')) cleanParams.set('search', params.get('search'));
            if (params.has('tanggal')) cleanParams.set('tanggal', params.get('tanggal'));

            if (params.has(targetParam)) {
                cleanParams.set(targetParam, params.get(targetParam));
                memoryPages[targetParam] = params.get(targetParam); // SIMPAN KE MEMORI LOKAL
            } else {
                cleanParams.set(targetParam, 1);
                memoryPages[targetParam] = 1;
            }

            urlObj.search = cleanParams.toString();
            let finalUrl = urlObj.toString();

            // 4. EKSEKUSI: Ambil data ke server tanpa gangguan parameter nyasar
            fetch(finalUrl, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let targetElement = doc.getElementById(targetContainerId);

                    // Jika halaman penuh ambil innerHTML-nya, jika partial view ambil html langsung
                    let newContent = targetElement ? targetElement.innerHTML : html;

                    document.getElementById(targetContainerId).innerHTML = newContent;
                    window.history.pushState({}, '', finalUrl);
                })
                .catch(error => console.error("Gagal memuat data paginasi via AJAX:", error));
        });

        // 1. Ganti CDN ke html2canvas-pro (Versi yang support warna OKLCH Tailwind)
        const scriptHtml2Canvas = document.createElement('script');
        scriptHtml2Canvas.src = "https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.8/dist/html2canvas-pro.min.js";
        document.head.appendChild(scriptHtml2Canvas);

        // 2. Fungsi cetak/download card QR formal
        function downloadQRCard(elementId, filename, event = null) {
            const element = document.getElementById(elementId);
            if (!element) return;

            if (typeof html2canvas === 'undefined') {
                alert('Sistem sedang memuat library, silakan tunggu sebentar.');
                return;
            }

            // Indikator Loading pada Tombol
            let btn = null;
            let originalText = '';
            let textSpan = null;

            if (event && event.currentTarget) {
                btn = event.currentTarget;
                textSpan = btn.querySelector('.btn-text');
                if (textSpan) {
                    originalText = textSpan.innerText;
                    textSpan.innerText = 'Memproses...';
                }
                btn.disabled = true;
            }

            // Proses Render Gambar Langsung ke Canvas (Anti-OKLCH Error)
            html2canvas(element, {
                scale: 3, // Kualitas HD
                useCORS: true,
                backgroundColor: "#ffffff",
                logging: false
            }).then(canvas => {
                let link = document.createElement('a');
                link.download = filename + '.jpg';
                link.href = canvas.toDataURL('image/jpeg', 0.95);
                link.click();

                // Kembalikan tombol seperti semula
                if (btn && textSpan) {
                    textSpan.innerText = originalText;
                    btn.disabled = false;
                }
            }).catch(error => {
                console.error('Gagal memproses gambar:', error);
                alert('Terjadi kesalahan saat mengunduh gambar.');

                if (btn && textSpan) {
                    textSpan.innerText = originalText;
                    btn.disabled = false;
                }
            });
        }

        setInterval(function() {
            if (activeMenu === 'utama') {
                // Ambil halaman dari memori
                let p_utama = memoryPages['p_utama'];
                let urlObj = new URL("{{ route('dashboard') }}");
                let params = new URLSearchParams(window.location.search);

                // Set parameter halaman
                urlObj.searchParams.set('p_utama', p_utama);
                // Bawa filter jika aktif di browser
                if (params.has('search')) urlObj.searchParams.set('search', params.get('search'));
                if (params.has('tanggal')) urlObj.searchParams.set('tanggal', params.get('tanggal'));

                let fetchUrl = urlObj.toString();

                // 1. SIMPAN POSISI SCROLL SEBELUM DATA DITIMPA
                // Kita cari div yang punya class overflow-x-auto di dalam konten utama
                let scrollContainer = document.querySelector('#konten-utama .overflow-x-auto');
                let currentScrollPosition = scrollContainer ? scrollContainer.scrollLeft : 0;

                fetch(fetchUrl, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // 2. TIMPA HTML DENGAN DATA BARU (Menggunakan Fallback Cerdas)
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');
                        let targetElement = doc.getElementById('konten-utama');
                        let newContent = targetElement ? targetElement.innerHTML : html;

                        document.getElementById('konten-utama').innerHTML = newContent;

                        // 3. KEMBALIKAN POSISI SCROLL PADA ELEMEN YANG BARU DIBUAT
                        let newScrollContainer = document.querySelector('#konten-utama .overflow-x-auto');
                        if (newScrollContainer) {
                            newScrollContainer.scrollLeft = currentScrollPosition;
                        }
                    }).catch(error => console.error("Gagal ambil data utama:", error));
            }
        }, 5000);
    </script>
</x-app-layout>
