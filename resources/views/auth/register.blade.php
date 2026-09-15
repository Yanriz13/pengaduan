@extends('layouts.app')
@section('title', 'Daftar Akun Warga - Portal Layanan Pengaduan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#23150d] via-[#4d2f1d] via-[#8c5a38] via-[#e2d4c5] to-[#ffffff] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Ambient Decorative Lighting: Warm Caramel, Silk White & Mocha --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-white/35 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-[28rem] h-[28rem] bg-[#c89262]/25 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[34rem] h-[34rem] bg-[#f5ebe0]/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 left-1/4 w-80 h-80 bg-white/40 rounded-full blur-2xl pointer-events-none"></div>

    <div class="w-full max-w-lg relative z-10">
        
        {{-- Card Container with Glassmorphism --}}
        <div class="bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl shadow-[#23150d]/25 border border-white/80 overflow-hidden">
            
            {{-- Header Dekoratif --}}
            <div class="bg-gradient-to-r from-[#23150d] via-[#3a2215] to-[#553522] px-8 pt-8 pb-7 text-center relative overflow-hidden border-b border-[#c89262]/20">
                <div class="absolute -right-8 -bottom-8 w-28 h-28 bg-[#c89262]/25 rounded-full blur-xl"></div>
                <div class="absolute -left-8 -top-8 w-28 h-28 bg-white/10 rounded-full blur-xl"></div>

                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-[#3d2417] to-[#1f1008] border border-[#c89262]/50 text-[#f5d09f] mb-2 shadow-lg ring-4 ring-[#c89262]/15">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>

                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
                    PENDAFTARAN AKUN WARGA
                </h1>
                <p class="text-xs font-semibold tracking-wider text-[#f5d09f] uppercase mt-1">
                    Buat Akun untuk Pengaduan STNK & Kecelakaan
                </p>
            </div>

            {{-- Form Content --}}
            <div class="p-7 sm:p-8 space-y-4">
                
                @if ($errors->any())
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-700 text-xs flex items-start gap-2.5">
                        <svg class="w-4 h-4 shrink-0 text-rose-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="flex-1">
                            <span class="font-bold">Periksa kembali data Anda:</span>
                            <ul class="list-disc list-inside mt-0.5 space-y-0.5 text-[11px]">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                            Nama Lengkap (Sesuai KTP) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Contoh: Budi Santoso"
                                class="w-full pl-10 pr-4 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                        </div>
                    </div>

                    {{-- Grid: Email & No. HP --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative rounded-xl">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="nama@email.com"
                                    class="w-full pl-10 pr-4 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                                No. Telepon / WhatsApp
                            </label>
                            <div class="relative rounded-xl">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                    placeholder="08123456789"
                                    class="w-full pl-10 pr-4 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                            </div>
                        </div>
                    </div>

                    {{-- Grid: Password & Konfirmasi Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" name="password" required
                                placeholder="Minimal 8 karakter"
                                class="w-full px-3.5 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                                Ulangi Sandi <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" required
                                placeholder="Ulangi kata sandi"
                                class="w-full px-3.5 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#2c170e] via-[#52331f] to-[#3a2012] hover:from-[#3d2315] hover:via-[#633e26] hover:to-[#4a2918] text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-[#2c170e]/25 hover:shadow-[#2c170e]/35 active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2 group text-sm tracking-wide border border-[#c89262]/20">
                            <span>Daftar Akun Baru</span>
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Back to Login Link --}}
                <div class="pt-2 text-center border-t border-stone-100">
                    <p class="text-xs text-stone-500">
                        Sudah memiliki akun? 
                        <a href="{{ route('login') }}" class="font-bold text-[#7d4e2d] hover:text-[#52331f] hover:underline transition ml-1">
                            Masuk ke Akun
                        </a>
                    </p>
                </div>

            </div>
        </div>

        {{-- Footer Copyright --}}
        <div class="mt-6 text-center">
            <p class="text-xs text-stone-600/90 font-medium">
                &copy; {{ date('Y') }} Kepolisian Sektor & Sistem Pengaduan Masyarakat
            </p>
        </div>

    </div>
</div>
@endsection
