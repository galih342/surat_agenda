<x-app-layout>
    <div class="min-h-screen bg-slate-50 dark:bg-gray-900 font-sans flex flex-col">

        <header
            class="h-20 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm flex items-center px-8 z-10 shrink-0">
            <div class="flex items-center">
                <img src="{{ asset('images/icon.png') }}" alt="Logo"
                    class="w-9 h-9 object-contain mr-3 transition-transform hover:scale-105 duration-300">
                <span class="text-xl font-extrabold text-gray-800 dark:text-white tracking-wide">Nama OPD</span>
            </div>
        </header>

        <main class="flex-1 flex flex-col items-center justify-center p-6 sm:p-10 overflow-y-auto">

            <div class="w-full max-w-3xl">
                <div class="flex items-center gap-4 mb-8">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center justify-center w-10 h-10 bg-white dark:bg-gray-800 rounded-full shadow-sm border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-indigo-600 hover:border-indigo-200 dark:hover:border-indigo-500/50 transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                            Edit Akun Admin</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-medium">Perbarui informasi akun
                            pengelola sistem di bawah ini.</p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 dark:border-gray-700/60 p-8 sm:p-10 transition-all duration-300">
                    <form action="{{ route('admin.update', $admin->id) }}" method="POST" class="space-y-7">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name"
                                class="block text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-2 ml-1">Nama
                                Lengkap</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $admin->name) }}" required
                                    class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-medium text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                            </div>
                            @error('name')
                                <p class="text-xs font-semibold text-rose-500 mt-2 ml-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                            <div>
                                <label for="username"
                                    class="block text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-2 ml-1">Username</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" name="username" id="username"
                                        value="{{ old('username', $admin->username) }}" required
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-medium text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                                </div>
                                @error('username')
                                    <p class="text-xs font-semibold text-rose-500 mt-2 ml-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="role"
                                    class="block text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-2 ml-1">Peran
                                    Akses (Role)</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                    <select name="role" id="role" required
                                        class="w-full pl-12 pr-10 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-medium text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                                        <option value="admin"
                                            {{ old('role', $admin->hasRole('admin') ? 'admin' : '') == 'admin' ? 'selected' : '' }}>
                                            Admin Biasa</option>
                                        <option value="super-admin"
                                            {{ old('role', $admin->hasRole('super-admin') ? 'super-admin' : '') == 'super-admin' ? 'selected' : '' }}>
                                            Super Admin</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('role')
                                    <p class="text-xs font-semibold text-rose-500 mt-2 ml-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 p-4 rounded-r-2xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-indigo-800 dark:text-indigo-300 font-medium">Biarkan kolom password
                                di bawah ini kosong jika Anda tidak ingin mengubah password lama.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                            <div>
                                <label for="password"
                                    class="block text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-2 ml-1">Password
                                    Baru</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="password" name="password" id="password"
                                        placeholder="Ketik sandi baru jika ingin mengubahnya"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-medium text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                                </div>
                                @error('password')
                                    <p class="text-xs font-semibold text-rose-500 mt-2 ml-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-2 ml-1">Konfirmasi
                                    Password</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="Ulangi sandi baru"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-medium text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div
                            class="pt-6 mt-4 border-t border-gray-100 dark:border-gray-700/80 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 sm:gap-4">
                            <a href="{{ route('dashboard') }}"
                                class="w-full sm:w-auto px-6 py-3.5 sm:py-3 rounded-2xl font-bold text-sm text-gray-500 bg-gray-50 hover:bg-gray-100 border border-transparent hover:border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-all duration-200 text-center">
                                Batal
                            </a>
                            <button type="submit"
                                class="w-full sm:w-auto px-8 py-3.5 sm:py-3 rounded-2xl font-bold text-sm text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.25)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.35)] transition-all duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                    </path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>
