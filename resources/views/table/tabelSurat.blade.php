<div>
    <div x-show="selectedUtama.length > 0" style="display: none;"
        class="mb-4 flex flex-wrap items-center justify-between bg-indigo-50 dark:bg-indigo-900/40 p-3 rounded-xl border border-indigo-200 dark:border-indigo-700/50 transition-all">
        <span class="text-sm font-bold text-indigo-700 dark:text-indigo-400">
            <span x-text="selectedUtama.length"></span> surat terpilih
        </span>
        <div class="flex gap-2">
            <button type="button" @click="executeBulk('{{ route('surat.bulk-terima') }}', 'utama', 'PATCH')"
                class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 shadow-sm cursor-pointer">Terima
                Terpilih</button>
            <button type="button" @click="executeBulk('{{ route('surat.bulk-tolak') }}', 'utama', 'PATCH')"
                class="px-3 py-1.5 bg-rose-600 text-white text-xs font-bold rounded-lg hover:bg-rose-700 shadow-sm cursor-pointer">Tolak
                Terpilih</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar pb-4">
        <table class="w-full text-left border-collapse min-w-max" id="tabel-surat-container">
            <thead>
                <tr
                    class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-sm uppercase tracking-wider">
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 w-10 text-center">
                        <input type="checkbox" x-show="isBulkMode" x-transition.opacity @change="toggleAll('utama')" :checked="isAllChecked('utama')"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold">Nama OPD</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold">Perihal Surat</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold">Waktu Acara</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold">Surat</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold text-center">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($surat as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/25 transition-colors"
                        :class="selectedUtama.includes({{ $item->id }}) ? 'bg-indigo-50/50 dark:bg-indigo-900/20' : ''">
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" x-show="isBulkMode" x-transition.opacity value="{{ $item->id }}" x-model="selectedUtama"
                                class="cb-utama rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                        </td>
                        <!-- Kolom Nama OPD dibatasi lebarnya dan dipaksa turun baris -->
                        <td
                            class="py-4 px-4 font-medium text-gray-900 dark:text-white max-w-[80px] whitespace-normal break-words leading-relaxed">
                            {{ $item->nama_opd }}
                        </td>

                        <!-- Kolom Perihal juga dibatasi lebarnya dan dipaksa turun baris -->
                        <td class="py-4 px-4 max-w-[150px] whitespace-normal break-words leading-relaxed">
                            {{ $item->perihal }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium">
                                {{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} -
                                {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : 'Selesai' }}
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-medium">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="truncate max-w-[150px]" title="{{ basename($item->file_surat) }}">
                                    @php
                                        $fileBase = basename($item->file_surat);
                                        $name = pathinfo($fileBase, PATHINFO_FILENAME);
                                        $ext = pathinfo($fileBase, PATHINFO_EXTENSION);
                                        echo strlen($name) > 20
                                            ? substr($name, 0, 5) . '...' . substr($name, -5) . '.' . $ext
                                            : $fileBase;
                                    @endphp
                                </span>
                            </div>
                            <div class="mt-2 flex items-center gap-3 ml-2">
                                <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                                    class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">Preview</a>
                                <span class="text-gray-300 text-xs">|</span>
                                <a href="{{ asset('storage/' . $item->file_surat) }}" download
                                    class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 transition-colors">Download</a>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('surat.terima', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors text-xs font-semibold shadow-sm cursor-pointer">
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ route('surat.tolak', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-xs font-semibold shadow-sm cursor-pointer">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-gray-500 dark:text-gray-400">
                            Belum ada data pengajuan surat masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Navigasi Paginasi -->
<div class="mt-6 px-2">
    {{ $surat->withQueryString()->links() }}
</div>
