@extends('layouts.app')
@section('title', 'Masuk - Portal Layanan Pengaduan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#23150d] via-[#4d2f1d] via-[#8c5a38] via-[#e2d4c5] to-[#ffffff] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Ambient Decorative Lighting: Warm Caramel, Silk White & Mocha --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-white/35 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-[28rem] h-[28rem] bg-[#c89262]/25 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[34rem] h-[34rem] bg-[#f5ebe0]/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 left-1/4 w-80 h-80 bg-white/40 rounded-full blur-2xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        {{-- Card Container with Glassmorphic Border & Soft Halo --}}
        <div class="bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl shadow-[#23150d]/25 border border-white/80 overflow-hidden">
            
            {{-- Header Dekoratif: Deep Espresso, Warm Mocha & Bronze Accents --}}
            <div class="bg-gradient-to-r from-[#23150d] via-[#3a2215] to-[#553522] px-8 pt-8 pb-7 text-center relative overflow-hidden border-b border-[#c89262]/20">
                <div class="absolute -right-8 -bottom-8 w-28 h-28 bg-[#c89262]/25 rounded-full blur-xl"></div>
                <div class="absolute -left-8 -top-8 w-28 h-28 bg-white/10 rounded-full blur-xl"></div>

                {{-- Shield Emblem Icon with Warm Golden Glow --}}
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#3d2417] to-[#1f1008] border border-[#c89262]/50 text-[#f5d09f] mb-3 shadow-lg shadow-black/30 ring-4 ring-[#c89262]/15">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>

                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
                    PORTAL PENGADUAN
                </h1>
                <p class="text-[11px] font-semibold tracking-widest text-[#f5d09f] uppercase mt-1">
                    Layanan Kehilangan STNK & Kecelakaan
                </p>
                <div class="flex items-center justify-center gap-1.5 mt-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] text-[#f5ebe0] font-medium">Sistem Terintegrasi Online 24 Jam</span>
                </div>
            </div>

            {{-- Form Content --}}
            <div class="p-7 sm:p-8 space-y-5">
                
                {{-- Global Error Alerts --}}
                @if ($errors->any())
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-700 text-xs flex items-start gap-2.5">
                        <svg class="w-4 h-4 shrink-0 text-rose-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="flex-1">
                            <span class="font-bold">Gagal Masuk:</span>
                            <ul class="list-disc list-inside mt-0.5 space-y-0.5 text-[11px]">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Input Email --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="nama@email.com"
                                class="w-full pl-10 pr-4 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                        </div>
                    </div>

                    {{-- Input Password with Toggle --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                placeholder="••••••••"
                                class="w-full pl-10 pr-10 py-2.5 bg-stone-50/80 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#7d4e2d] focus:ring-2 focus:ring-[#7d4e2d]/20 focus:bg-white transition duration-200">
                            <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-600 focus:outline-none">
                                <svg id="eye-icon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" 
                                class="w-4 h-4 rounded border-stone-300 text-[#7d4e2d] focus:ring-[#7d4e2d]/40 transition">
                            <span class="text-xs text-stone-600 font-medium">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    {{-- Submit Button: Rich Coffee/Chocolate to Caramel --}}
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#2c170e] via-[#52331f] to-[#3a2012] hover:from-[#3d2315] hover:via-[#633e26] hover:to-[#4a2918] text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-[#2c170e]/25 hover:shadow-[#2c170e]/35 active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2 group text-sm tracking-wide border border-[#c89262]/20">
                        <span>Masuk ke Akun</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>

                {{-- 1-Click Quick Demo Fillers --}}
                <div class="pt-3 border-t border-stone-100">
                    <p class="text-[11px] font-semibold text-stone-400 uppercase tracking-wider text-center mb-2">
                        Akun Uji Coba Cepat (Demo):
                    </p>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="fillDemo('admin@pengaduan.test', 'password')"
                                class="px-3 py-2 bg-gradient-to-r from-[#fdf8f4] to-[#fbf2eb] hover:from-[#faeee4] hover:to-[#f5e3d3] text-[#6d4223] border border-[#e5cdb7] rounded-xl text-xs font-semibold text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                            <span>👮 Petugas Admin</span>
                        </button>
                        <button type="button" onclick="fillDemo('user@pengaduan.test', 'password')"
                                class="px-3 py-2 bg-gradient-to-r from-[#faf8f6] to-[#f5f2ee] hover:from-[#f3eee7] hover:to-[#ede5dc] text-[#553c2a] border border-[#ded5cb] rounded-xl text-xs font-semibold text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                            <span>👤 Warga Pelapor</span>
                        </button>
                    </div>
                </div>

                {{-- Register Link --}}
                <div class="pt-2 text-center">
                    <p class="text-xs text-stone-500">
                        Belum memiliki akun pengaduan? 
                        <a href="{{ route('register') }}" class="font-bold text-[#7d4e2d] hover:text-[#52331f] hover:underline transition ml-1">
                            Daftar Akun Baru
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

<script>
    function togglePassword() {
        const passInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeIcon.classList.add('text-[#7d4e2d]');
        } else {
            passInput.type = 'password';
            eyeIcon.classList.remove('text-[#7d4e2d]');
        }
    }

    function fillDemo(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection