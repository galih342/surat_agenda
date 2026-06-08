<div>
    <div x-show="selectedDitolak.length > 0" style="display: none;"
        class="mb-4 flex flex-wrap items-center justify-between bg-indigo-50 dark:bg-indigo-900/40 p-3 rounded-xl border border-indigo-200 dark:border-indigo-700/50 transition-all">
        <span class="text-sm font-bold text-indigo-700 dark:text-indigo-400">
            <span x-text="selectedDitolak.length"></span> surat terpilih
        </span>
        <div class="flex gap-2">
            <button type="button" @click="executeBulk('{{ route('surat.bulk-destroy') }}', 'ditolak', 'DELETE')"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600 text-white text-xs font-bold rounded-lg hover:bg-rose-700 shadow-sm transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                Hapus Terpilih
            </button>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar pb-4">
        <table class="w-full text-left border-collapse min-w-max" id="tabel-ditolak-container">
            <thead>
                <tr
                    class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-sm uppercase tracking-wider">
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 w-10 text-center">
                        <input type="checkbox" x-show="isBulkMode" x-transition.opacity @change="toggleAll('ditolak')" :checked="isAllChecked('ditolak')"
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
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/25 transition-colors">
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" x-show="isBulkMode" x-transition.opacity value="{{ $item->id }}" x-model="selectedDitolak"
                                class="cb-ditolak rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer dark:bg-gray-800 dark:border-gray-600">
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
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Ditolak
                            </span>

                            <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Pindah surat ditolak ini ke tong sampah?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition-colors cursor-pointer"
                                    title="Hapus ke Tong Sampah">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-gray-500 dark:text-gray-400">
                            Belum ada pengajuan surat yang ditolak.
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
