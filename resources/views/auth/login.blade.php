<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengelola - Diskominfostandi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-white sm:bg-gray-100 dark:bg-gray-900 text-slate-800 dark:text-slate-200 font-sans antialiased flex items-center justify-center min-h-screen sm:p-4 relative">

    <div
        class="w-full min-h-screen sm:min-h-fit sm:max-w-md bg-white dark:bg-gray-800 sm:rounded-xl sm:shadow-[0_4px_20px_rgba(0,0,0,0.08)] sm:border sm:border-slate-200 dark:sm:border-gray-700 flex flex-col overflow-hidden relative z-0">

        <div
            class="bg-slate-900 px-6 pt-12 pb-10 sm:pt-10 sm:pb-8 border-b-4 border-amber-500 text-center flex-shrink-0">
            <img src="{{ asset('images/icon.png') }}" alt="Logo Instansi" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h1 class="text-white text-xs font-semibold uppercase tracking-wider opacity-90">Pemerintah Kabupaten
                Katingan</h1>
            <h2 class="text-white text-lg sm:text-xl font-extrabold uppercase tracking-widest mt-1">Diskominfostandi</h2>
            <p class="text-slate-400 text-[10px] mt-2.5 font-bold uppercase tracking-widest">Sistem Informasi Pengajuan
                Agenda</p>
        </div>

        <div class="p-6 sm:p-8 flex-1 flex flex-col justify-center">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="username" value="USERNAME PENGELOLA"
                        class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300" />
                    <x-text-input id="username"
                        class="block mt-1.5 w-full py-3 px-4 rounded-md border-slate-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm hover:border-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 text-base font-semibold text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-400 transition-all"
                        type="text" name="username" :value="old('username')" required autofocus autocomplete="username"
                        placeholder="Masukkan nama pengguna" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="KATA SANDI"
                        class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300" />
                    <x-text-input id="password"
                        class="block mt-1.5 w-full py-3 px-4 rounded-md border-slate-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm hover:border-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 text-base font-semibold text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-400 transition-all"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="Masukkan kata sandi" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block pt-1">
                    <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                        <input id="remember_me" type="checkbox"
                            class="rounded-sm border-slate-300 text-slate-900 shadow-sm focus:ring-slate-500 transition-colors w-4 h-4 cursor-pointer"
                            name="remember">
                        <span
                            class="ms-2 text-xs font-bold uppercase tracking-wider text-slate-600 group-hover:text-slate-900 transition-colors">Ingat
                            Saya</span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-widest rounded-md shadow-sm transition-colors focus:outline-none focus:ring-4 focus:ring-slate-500/30 cursor-pointer">
                        Masuk Sistem
                    </button>
                    <p class="text-center text-[10px] font-medium text-slate-400 mt-4 uppercase tracking-wider">
                        Harap jaga keamanan kredensial akun Anda.
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
