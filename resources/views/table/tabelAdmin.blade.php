<div>
    <div x-show="selectedAdmin.length > 0" style="display: none;"
        class="mb-4 flex flex-wrap items-center justify-between bg-rose-50 dark:bg-rose-900/40 p-3 rounded-xl border border-rose-200 dark:border-rose-700/50 transition-all">
        <span class="text-sm font-bold text-rose-700 dark:text-rose-400">
            <span x-text="selectedAdmin.length"></span> akun terpilih
        </span>
        <div class="flex gap-2">
            <button type="button" @click="executeBulk('{{ route('admin.bulk-delete') }}', 'admin', 'DELETE')"
                class="px-3 py-1.5 bg-rose-600 text-white text-xs font-bold rounded-lg hover:bg-rose-700 shadow-sm cursor-pointer">Hapus
                Terpilih</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar pb-4">
        <table class="w-full text-left border-collapse min-w-max" id="tabel-admin-container">
            <thead>
                <tr
                    class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-sm uppercase tracking-wider">
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 w-10 text-center">
                        <input type="checkbox" x-show="isBulkMode" x-transition.opacity @change="toggleAll('admin')"
                            :checked="isAllChecked('admin')"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold">Informasi Pengguna
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold">Peran Akses (Role)
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 font-semibold text-center">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($admins as $admin)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/25 transition-colors"
                        :class="selectedAdmin.includes('{{ $admin->id }}') ? 'bg-indigo-50/50 dark:bg-indigo-900/20' : ''">

                        <td class="py-4 px-4 text-center">
                            @if (auth()->id() !== $admin->id)
                                <input type="checkbox" x-show="isBulkMode" x-transition.opacity
                                    value="{{ $admin->id }}" x-model="selectedAdmin"
                                    class="cb-admin rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                            @else
                                <span x-show="isBulkMode"
                                    class="inline-block w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600"
                                    title="Ini akun Anda"></span>
                            @endif
                        </td>

                        <td
                            class="py-4 px-4 font-medium text-gray-900 dark:text-white max-w-[150px] whitespace-normal break-words leading-relaxed">
                            <div class="flex items-center gap-2">
                                {{ $admin->name }}
                                @if (auth()->id() === $admin->id)
                                    <span
                                        class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full uppercase tracking-wider font-bold border border-emerald-200">Anda</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-normal">
                                {{ $admin->email }}
                            </div>
                        </td>

                        <td class="py-4 px-4 max-w-[150px] whitespace-normal break-words leading-relaxed">
                            <span
                                class="px-3 py-1 text-[11px] font-bold uppercase tracking-wider rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800/50 dark:text-gray-400">
                                Role Pengguna
                            </span>
                        </td>

                        <td class="py-4 px-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.edit', $admin->id) }}"
                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-500 text-white rounded-md hover:bg-amber-600 transition-colors text-xs font-semibold shadow-sm cursor-pointer">
                                    Edit
                                </a>

                                @if (auth()->id() !== $admin->id)
                                    <form action="{{ route('admin.destroy', $admin->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus akun admin ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-600 text-white rounded-md hover:bg-rose-700 transition-colors text-xs font-semibold shadow-sm cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-4 text-center text-gray-500 dark:text-gray-400">
                            Belum ada data admin terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
