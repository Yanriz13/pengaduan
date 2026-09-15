<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Layanan Pengaduan')</title>

    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fdf9f5',
                            100: '#f7eee3',
                            200: '#edd8c4',
                            300: '#debca0',
                            400: '#c59571',
                            500: '#ab744b',
                            600: '#8c5832',
                            700: '#724326',
                            800: '#5c351f',
                            900: '#432617',
                            950: '#28150c',
                        },
                        police: {
                            gold: '#d4a373',
                            navy: '#23150d',
                            dark: '#1a0e08',
                            steel: '#3f2518',
                            blue: '#724326',
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'card': '0 4px 20px -2px rgba(44, 23, 14, 0.06)',
                        'glow': '0 0 25px -5px rgba(140, 88, 50, 0.35)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body
    class="bg-stone-50 text-stone-800 antialiased min-h-full flex flex-col selection:bg-brand-500 selection:text-white">

    @auth
        {{-- Header / Navbar Modern Glassmorphism --}}
        <header class="glass-header border-b border-stone-200/80 sticky top-0 z-30 transition-all">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-16">

                    {{-- Brand Identity --}}
                    <div class="flex items-center gap-8">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}"
                            class="flex items-center gap-3 group">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#23150d] via-[#3f2518] to-[#724326] text-amber-300 flex items-center justify-center shadow-md shadow-[#23150d]/20 ring-1 ring-white/20 group-hover:scale-105 transition duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-extrabold text-stone-900 tracking-tight text-base">PORTAL</span>
                                    <span
                                        class="font-extrabold bg-gradient-to-r from-[#724326] to-[#b0774a] bg-clip-text text-transparent text-base">PENGADUAN</span>
                                </div>
                                <p class="text-[10px] font-semibold tracking-wider text-stone-400 uppercase -mt-0.5">Layanan
                                    Polsek Terpadu</p>
                            </div>
                        </a>

                        {{-- Desktop Menu --}}
                        <nav class="hidden md:flex items-center gap-1 text-sm">
                            @if(auth()->user()->isAdmin())
                                {{-- Admin Menu --}}
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-semibold text-xs tracking-wide transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#2c170e] to-[#4a2c1d] text-white shadow-sm shadow-[#2c170e]/20' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                                    <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('admin.stnk.index') }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-semibold text-xs tracking-wide transition duration-150 {{ request()->routeIs('admin.stnk.*') ? 'bg-gradient-to-r from-[#2c170e] to-[#4a2c1d] text-white shadow-sm shadow-[#2c170e]/20' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                                    <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Pengaduan STNK</span>
                                    <span id="badge-nav-stnk"
                                        class="{{ (!isset($countStnkBelum) || $countStnkBelum === 0) ? 'hidden' : '' }} ml-1 px-1.5 py-0.5 text-[10px] font-extrabold rounded-full bg-amber-500 text-white">
                                        {{ $countStnkBelum ?? 0 }}
                                    </span>
                                </a>

                                {{-- Menu Pengaduan Kecelakaan (Admin) - Dikomentari / Dinonaktifkan
                                <a href="{{ route('admin.kecelakaan.index') }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-semibold text-xs tracking-wide transition duration-150 {{ request()->routeIs('admin.kecelakaan.*') ? 'bg-gradient-to-r from-[#2c170e] to-[#4a2c1d] text-white shadow-sm shadow-[#2c170e]/20' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                                    <svg class="w-4 h-4 opacity-80 text-rose-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Pengaduan Kecelakaan</span>
                                    <span id="badge-nav-kecelakaan"
                                        class="{{ (!isset($countKecelakaanBelum) || $countKecelakaanBelum === 0) ? 'hidden' : '' }} ml-1 px-1.5 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white animate-pulse">
                                        {{ $countKecelakaanBelum ?? 0 }}
                                    </span>
                                </a>
                                --}}
                            @else
                                {{-- User Menu --}}
                                <a href="{{ route('user.dashboard') }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-semibold text-xs tracking-wide transition duration-150 {{ request()->routeIs('user.dashboard') ? 'bg-brand-600 text-white shadow-sm shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('user.stnk.index') }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-semibold text-xs tracking-wide transition duration-150 {{ request()->routeIs('user.stnk.*') ? 'bg-brand-600 text-white shadow-sm shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Pengaduan STNK</span>
                                </a>

                                {{-- Menu Lapor Kecelakaan (User) - Dikomentari / Dinonaktifkan
                                <a href="{{ route('user.kecelakaan.index') }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-semibold text-xs tracking-wide transition duration-150 {{ request()->routeIs('user.kecelakaan.*') ? 'bg-brand-600 text-white shadow-sm shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <svg class="w-4 h-4 opacity-80 text-rose-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Lapor Kecelakaan</span>
                                </a>
                                --}}
                            @endif
                        </nav>
                    </div>

                    {{-- User Profile Pill & Actions --}}
                    <div class="flex items-center gap-2 sm:gap-3">

                        {{-- ── NOTIFICATION BELL DROPDOWN (KHUSUS ADMIN) ── --}}
                        @if(auth()->user()->isAdmin())
                            <details class="relative" id="admin-notif-dropdown">
                                <summary
                                    class="list-none p-2.5 rounded-2xl border border-slate-200/80 bg-white hover:bg-slate-50 transition cursor-pointer select-none shadow-sm relative text-slate-600 hover:text-slate-900">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>

                                    {{-- Badge Angka Belum Ditangani --}}
                                    <span id="notif-badge-bell"
                                        class="{{ (!isset($totalNotifAdmin) || $totalNotifAdmin === 0) ? 'hidden' : '' }} absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1.5 rounded-full bg-rose-600 text-white text-[10px] font-extrabold flex items-center justify-center ring-2 ring-white shadow-sm animate-pulse">
                                        {{ $totalNotifAdmin ?? 0 }}
                                    </span>
                                </summary>

                                <div
                                    class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl shadow-slate-900/15 border border-slate-100 py-3 text-sm z-50 overflow-hidden">
                                    <div class="px-5 pb-3 border-b border-slate-100 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="text-base">🔔</span>
                                            <h3 class="font-extrabold text-sm text-slate-900">Pengaduan Masuk</h3>
                                        </div>
                                        <span id="notif-dropdown-total"
                                            class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ (isset($totalNotifAdmin) && $totalNotifAdmin > 0) ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $totalNotifAdmin ?? 0 }} Belum Ditangani
                                        </span>
                                    </div>

                                    {{-- Daftar Pengaduan Belum Ditangani --}}
                                    <div class="max-h-80 overflow-y-auto divide-y divide-slate-50 p-2"
                                        id="notif-list-container">
                                        {{-- Kecelakaan Baru --}}
                                        @if(isset($kecelakaanBelumDitangani) && $kecelakaanBelumDitangani->count() > 0)
                                            @foreach($kecelakaanBelumDitangani as $k)
                                                <a href="{{ route('admin.kecelakaan.show', $k) }}"
                                                    class="p-3 rounded-2xl hover:bg-rose-50/60 transition flex items-start gap-3 group">
                                                    <div
                                                        class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                                        🚨
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between gap-1">
                                                            <span
                                                                class="text-[10px] font-bold text-rose-600 uppercase tracking-wide">Kecelakaan
                                                                Baru</span>
                                                            <span
                                                                class="text-[10px] text-slate-400">{{ $k->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p
                                                            class="text-xs font-bold text-slate-900 truncate group-hover:text-rose-600 transition">
                                                            {{ $k->judul }}</p>
                                                        <p class="text-[11px] text-slate-500 truncate">Pelapor:
                                                            {{ $k->user->name ?? 'Warga' }}</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif

                                        {{-- STNK Diajukan --}}
                                        @if(isset($stnkBelumDitangani) && $stnkBelumDitangani->count() > 0)
                                            @foreach($stnkBelumDitangani as $s)
                                                <a href="{{ route('admin.stnk.show', $s) }}"
                                                    class="p-3 rounded-2xl hover:bg-amber-50/60 transition flex items-start gap-3 group">
                                                    <div
                                                        class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                                        📄
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between gap-1">
                                                            <span
                                                                class="text-[10px] font-bold text-amber-600 uppercase tracking-wide">STNK
                                                                Diajukan</span>
                                                            <span
                                                                class="text-[10px] text-slate-400">{{ $s->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p
                                                            class="text-xs font-bold text-slate-900 truncate group-hover:text-amber-700 transition">
                                                            {{ $s->plat_nomor ? '[' . $s->plat_nomor . '] ' : '' }}{{ $s->merk_tipe ?: $s->jenis_kendaraan }}
                                                        </p>
                                                        <p class="text-[11px] text-slate-500 truncate">Pemilik:
                                                            {{ $s->nama_pemilik ?: ($s->nama_pemohon ?: ($s->user->name ?? 'Warga')) }}
                                                        </p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif

                                        @if((!isset($totalNotifAdmin) || $totalNotifAdmin === 0))
                                            <div class="py-8 text-center text-slate-400 space-y-1">
                                                <p class="text-2xl">🎉</p>
                                                <p class="text-xs font-semibold text-slate-600">Semua pengaduan telah ditangani!</p>
                                                <p class="text-[10px] text-slate-400">Tidak ada laporan baru yang tertunda.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div
                                        class="px-4 pt-2.5 pb-1 border-t border-slate-100 flex items-center justify-between text-xs font-bold">
                                        <a href="{{ route('admin.kecelakaan.index', ['status' => 'baru']) }}"
                                            class="text-rose-600 hover:underline">
                                            Laka Baru &rarr;
                                        </a>
                                        <a href="{{ route('admin.stnk.index', ['status' => 'diajukan']) }}"
                                            class="text-brand-600 hover:underline">
                                            STNK Baru &rarr;
                                        </a>
                                    </div>
                                </div>
                            </details>
                        @endif

                        <details class="relative">
                            <summary
                                class="list-none flex items-center gap-2.5 p-1 sm:pl-2.5 sm:pr-3 rounded-full hover:bg-slate-100 border border-slate-200/60 bg-white transition cursor-pointer select-none shadow-sm">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-tr {{ auth()->user()->isAdmin() ? 'from-[#23150d] to-[#724326] text-amber-300' : 'from-brand-600 to-brand-400 text-white' }} flex items-center justify-center text-xs font-bold shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-xs font-semibold text-slate-800 leading-tight">{{ auth()->user()->name }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 leading-tight">
                                        {{ auth()->user()->isAdmin() ? 'Administrator' : 'Warga / Pelapor' }}
                                    </p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>

                            <div
                                class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl shadow-stone-900/10 border border-stone-100 py-1.5 text-sm z-40 divide-y divide-stone-100">
                                <div class="px-4 py-3">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                                    <div class="mt-2 flex items-center gap-1.5">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold {{ auth()->user()->isAdmin() ? 'bg-amber-50 text-amber-700 border border-amber-200/60' : 'bg-brand-50 text-brand-700 border border-brand-200/60' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-amber-500' : 'bg-brand-500' }}"></span>
                                            {{ auth()->user()->isAdmin() ? 'Petugas Admin' : 'Akun Warga' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center gap-2 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>Keluar dari Akun</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </details>

                        {{-- Mobile menu button --}}
                        <label for="mobile-menu-toggle"
                            class="md:hidden p-2 rounded-xl bg-white border border-stone-200/80 hover:bg-stone-50 cursor-pointer shadow-sm">
                            <svg class="w-5 h-5 text-stone-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                    </div>
                </div>

                {{-- Mobile Drawer Navigation --}}
                <input type="checkbox" id="mobile-menu-toggle" class="peer hidden">
                <nav
                    class="hidden peer-checked:block md:hidden py-4 border-t border-stone-100 space-y-1 text-sm animate-fadeIn">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#2c170e] to-[#4a2c1d] text-white' : 'text-stone-700 hover:bg-stone-100' }}">
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.stnk.index') }}"
                            class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.stnk.*') ? 'bg-gradient-to-r from-[#2c170e] to-[#4a2c1d] text-white' : 'text-stone-700 hover:bg-stone-100' }}">
                            <span>Pengaduan STNK</span>
                            <span id="badge-mobile-stnk"
                                class="{{ (!isset($countStnkBelum) || $countStnkBelum === 0) ? 'hidden' : '' }} px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-500 text-white">
                                {{ $countStnkBelum ?? 0 }}
                            </span>
                        </a>
                        <a href="{{ route('admin.kecelakaan.index') }}"
                            class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.kecelakaan.*') ? 'bg-gradient-to-r from-[#2c170e] to-[#4a2c1d] text-white' : 'text-stone-700 hover:bg-stone-100' }}">
                            <span>Pengaduan Kecelakaan</span>
                            <span id="badge-mobile-kecelakaan"
                                class="{{ (!isset($countKecelakaanBelum) || $countKecelakaanBelum === 0) ? 'hidden' : '' }} px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-600 text-white animate-pulse">
                                {{ $countKecelakaanBelum ?? 0 }}
                            </span>
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('user.dashboard') ? 'bg-brand-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('user.stnk.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('user.stnk.*') ? 'bg-brand-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                            <span>Pengaduan STNK</span>
                        </a>
                        <a href="{{ route('user.kecelakaan.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('user.kecelakaan.*') ? 'bg-brand-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                            <span>Lapor Kecelakaan</span>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-100">
                        @csrf
                        <button
                            class="w-full text-left px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar dari Akun</span>
                        </button>
                    </form>
                </nav>
            </div>
        </header>
    @endauth

    {{-- Main Content Body --}}
    <main class="flex-1 w-full flex flex-col">
        @auth
            <div class="max-w-6xl mx-auto w-full px-4 sm:px-6 py-6 sm:py-8 space-y-6 flex-1">
                {{-- Flash Alert Sukses --}}
                @if(session('status'))
                    <div
                        class="rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/80 text-emerald-900 px-4 py-3.5 text-sm flex items-center gap-3 shadow-sm shadow-emerald-500/5">
                        <div
                            class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="text-xs sm:text-sm font-medium leading-relaxed">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                {{-- Flash Alert Error Validation --}}
                @if(isset($errors) && $errors->any())
                    <div
                        class="rounded-2xl bg-gradient-to-r from-rose-50 to-red-50 border border-rose-200/80 text-rose-900 px-4 py-3.5 text-sm shadow-sm shadow-rose-500/5 flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-xs uppercase tracking-wide text-rose-800 mb-1">Periksa kembali data
                                formulir:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        @else
            {{-- Guest Full-bleed Container (Login & Register) --}}
            <div class="flex-1 flex flex-col justify-center">
                @yield('content')
            </div>
        @endauth
    </main>

    @auth
        {{-- Footer Modern --}}
        <footer class="border-t border-slate-200/70 bg-white/70 py-5 text-center text-xs text-slate-500">
            <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="font-medium text-slate-600">Sistem Pelayanan Pengaduan Terpadu</span>
                </div>
                <p class="text-[11px] text-slate-400">
                    &copy; {{ date('Y') }} Kepolisian Sektor & Layanan Publik. Seluruh hak cipta dilindungi.
                </p>
            </div>
        </footer>
    @endauth

    {{-- ── FLOATING TOAST CONTAINER & REAL-TIME NOTIFICATION (ADMIN ONLY) ── --}}
    @auth
        @if(auth()->user()->isAdmin())
            {{-- Toast Notifications Container --}}
            <div id="admin-toast-container"
                class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-[calc(100vw-2.5rem)] pointer-events-none">
            </div>

            <script>
                    (function () {
                        let lastKnownTotal = {{ $totalNotifAdmin ?? 0 }};
                        let hasInitialized = false;

                        // Play pleasant sound chime using Web Audio API
                        function playNotificationChime() {
                            try {
                                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                                if (!AudioCtx) return;
                                const ctx = new AudioCtx();
                                const now = ctx.currentTime;

                                // First chime (D5)
                                const osc1 = ctx.createOscillator();
                                const gain1 = ctx.createGain();
                                osc1.type = 'sine';
                                osc1.frequency.setValueAtTime(587.33, now);
                                gain1.gain.setValueAtTime(0.2, now);
                                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.3);
                                osc1.connect(gain1);
                                gain1.connect(ctx.destination);
                                osc1.start(now);
                                osc1.stop(now + 0.3);

                                // Second chime higher pitch (A5)
                                const osc2 = ctx.createOscillator();
                                const gain2 = ctx.createGain();
                                osc2.type = 'sine';
                                osc2.frequency.setValueAtTime(880, now + 0.12);
                                gain2.gain.setValueAtTime(0.25, now + 0.12);
                                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.55);
                                osc2.connect(gain2);
                                gain2.connect(ctx.destination);
                                osc2.start(now + 0.12);
                                osc2.stop(now + 0.55);
                            } catch (e) {
                                // User hasn't interacted with page yet or audio policy blocked
                            }
                        }

                        // Show modern floating toast
                        function showAdminToast(item) {
                            const container = document.getElementById('admin-toast-container');
                            if (!container) return;

                            const isLaka = item.type === 'kecelakaan';
                            const toast = document.createElement('div');
                            toast.className = `pointer-events-auto bg-white/95 backdrop-blur-xl border ${isLaka ? 'border-rose-200 shadow-rose-500/20' : 'border-amber-200 shadow-amber-500/20'} shadow-2xl rounded-3xl p-4 transition-all duration-300 transform translate-y-4 opacity-0 flex items-start gap-3.5 ring-1 ring-black/5`;

                            const iconHtml = isLaka
                                ? `<div class="w-10 h-10 rounded-2xl bg-rose-500 text-white flex items-center justify-center font-bold text-lg shrink-0 shadow-md shadow-rose-500/30 animate-bounce">🚨</div>`
                                : `<div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-bold text-lg shrink-0 shadow-md shadow-amber-500/30">📄</div>`;

                            const badgeHtml = isLaka
                                ? `<span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-700">Laka Baru Masuk!</span>`
                                : `<span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">STNK Baru Diajukan!</span>`;

                            toast.innerHTML = `
                                    ${iconHtml}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-1 mb-1">
                                            ${badgeHtml}
                                            <span class="text-[10px] text-slate-400 font-medium">${item.time || 'Baru saja'}</span>
                                        </div>
                                        <h4 class="text-xs font-extrabold text-slate-900 truncate leading-snug">${item.title}</h4>
                                        <p class="text-[11px] text-slate-500 truncate mt-0.5">Pelapor: <strong class="text-slate-700">${item.user}</strong></p>
                                        <div class="mt-2.5 flex items-center gap-2">
                                            <a href="${item.url}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold ${isLaka ? 'bg-rose-600 hover:bg-rose-700' : 'bg-slate-900 hover:bg-slate-800'} text-white transition shadow-sm">
                                                <span>Lihat & Tangani</span>
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                            <button type="button" class="close-toast text-slate-400 hover:text-slate-600 text-xs px-2 py-1 font-medium">Tutup</button>
                                        </div>
                                    </div>
                                `;

                            // Close button handler
                            toast.querySelector('.close-toast').addEventListener('click', () => {
                                toast.classList.add('opacity-0', 'translate-y-4');
                                setTimeout(() => toast.remove(), 300);
                            });

                            container.prepend(toast);

                            // Animate in
                            requestAnimationFrame(() => {
                                toast.classList.remove('translate-y-4', 'opacity-0');
                                toast.classList.add('translate-y-0', 'opacity-100');
                            });

                            // Auto-dismiss after 9 seconds
                            setTimeout(() => {
                                if (toast.parentElement) {
                                    toast.classList.add('opacity-0', 'translate-y-4');
                                    setTimeout(() => toast.remove(), 300);
                                }
                            }, 9000);
                        }

                        // Update UI Badges & Notification Dropdown Content
                        function updateUiWithNotificationData(data) {
                            // 1. Bell badge
                            const bellBadge = document.getElementById('notif-badge-bell');
                            if (bellBadge) {
                                bellBadge.textContent = data.total;
                                if (data.total > 0) {
                                    bellBadge.classList.remove('hidden');
                                } else {
                                    bellBadge.classList.add('hidden');
                                }
                            }

                            // 2. Dropdown Header Total
                            const ddTotal = document.getElementById('notif-dropdown-total');
                            if (ddTotal) {
                                ddTotal.textContent = `${data.total} Belum Ditangani`;
                                if (data.total > 0) {
                                    ddTotal.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700';
                                } else {
                                    ddTotal.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500';
                                }
                            }

                            // 3. Desktop Nav Badges
                            const navStnk = document.getElementById('badge-nav-stnk');
                            if (navStnk) {
                                navStnk.textContent = data.count_stnk;
                                if (data.count_stnk > 0) navStnk.classList.remove('hidden');
                                else navStnk.classList.add('hidden');
                            }

                            const navLaka = document.getElementById('badge-nav-kecelakaan');
                            if (navLaka) {
                                navLaka.textContent = data.count_kecelakaan;
                                if (data.count_kecelakaan > 0) navLaka.classList.remove('hidden');
                                else navLaka.classList.add('hidden');
                            }

                            // 4. Mobile Nav Badges
                            const mobStnk = document.getElementById('badge-mobile-stnk');
                            if (mobStnk) {
                                mobStnk.textContent = data.count_stnk;
                                if (data.count_stnk > 0) mobStnk.classList.remove('hidden');
                                else mobStnk.classList.add('hidden');
                            }

                            const mobLaka = document.getElementById('badge-mobile-kecelakaan');
                            if (mobLaka) {
                                mobLaka.textContent = data.count_kecelakaan;
                                if (data.count_kecelakaan > 0) mobLaka.classList.remove('hidden');
                                else mobLaka.classList.add('hidden');
                            }

                            // 5. Dropdown List items
                            const listContainer = document.getElementById('notif-list-container');
                            if (listContainer && Array.isArray(data.items)) {
                                if (data.items.length === 0) {
                                    listContainer.innerHTML = `
                                            <div class="py-8 text-center text-slate-400 space-y-1">
                                                <p class="text-2xl">🎉</p>
                                                <p class="text-xs font-semibold text-slate-600">Semua pengaduan telah ditangani!</p>
                                                <p class="text-[10px] text-slate-400">Tidak ada laporan baru yang tertunda.</p>
                                            </div>
                                        `;
                                } else {
                                    let html = '';
                                    data.items.forEach(item => {
                                        const isLaka = item.type === 'kecelakaan';
                                        html += `
                                                <a href="${item.url}" class="p-3 rounded-2xl hover:${isLaka ? 'bg-rose-50/60' : 'bg-amber-50/60'} transition flex items-start gap-3 group">
                                                    <div class="w-8 h-8 rounded-xl ${isLaka ? 'bg-rose-100 text-rose-600' : 'bg-amber-100 text-amber-700'} flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                                        ${isLaka ? '🚨' : '📄'}
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between gap-1">
                                                            <span class="text-[10px] font-bold ${isLaka ? 'text-rose-600' : 'text-amber-600'} uppercase tracking-wide">
                                                                ${isLaka ? 'Kecelakaan Baru' : 'STNK Diajukan'}
                                                            </span>
                                                            <span class="text-[10px] text-slate-400">${item.time}</span>
                                                        </div>
                                                        <p class="text-xs font-bold text-slate-900 truncate group-hover:${isLaka ? 'text-rose-600' : 'text-amber-700'} transition">
                                                            ${item.plat ? '[' + item.plat + '] ' : ''}${item.title}
                                                        </p>
                                                        <p class="text-[11px] text-slate-500 truncate">Pelapor: ${item.user}</p>
                                                    </div>
                                                </a>
                                            `;
                                    });
                                    listContainer.innerHTML = html;
                                }
                            }
                        }

                        // Poll the server
                        function checkNotifications() {
                            fetch("{{ route('admin.notifications.check') }}", {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (typeof data.total === 'number') {
                                        // If there are new unhandled complaints since last check
                                        if (hasInitialized && data.total > lastKnownTotal) {
                                            playNotificationChime();

                                            // Display toast for the newest item
                                            if (Array.isArray(data.items) && data.items.length > 0) {
                                                showAdminToast(data.items[0]);
                                            }
                                        }

                                        lastKnownTotal = data.total;
                                        hasInitialized = true;
                                        updateUiWithNotificationData(data);
                                    }
                                })
                                .catch(err => {
                                    // Silently handle network drops
                                });
                        }

                        // Initial flag setup
                        hasInitialized = true;

                        // Poll every 12 seconds
                        setInterval(checkNotifications, 12000);
                    })();
            </script>
        @endif
    @endauth

    {{-- ── 3D Pop-up Flash Message (Success / Error) ── --}}
    @include('partials.popup-3d')

</body>

</html>