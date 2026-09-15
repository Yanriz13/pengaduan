@extends('layouts.app')
@section('title', 'Dashboard Warga - Portal Layanan Pengaduan')

@section('content')
<div class="space-y-6">
    
    {{-- Hero Welcome Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#23150d] via-[#3a2215] to-[#553522] p-6 sm:p-8 text-white shadow-card border border-[#c89262]/20">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#c89262]/20 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-[#c89262]/30 text-xs text-[#f5d09f] font-medium mb-3 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal Pelayanan Masyarakat</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Halo, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-amber-100/80 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">
                    Ajukan surat kehilangan STNK secara resmi atau laporkan kejadian kecelakaan darurat langsung ke petugas piket.
                </p>
            </div>

            {{-- Quick Actions Group --}}
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                <a href="{{ route('user.stnk.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gradient-to-r from-[#8c5832] to-[#ab744b] hover:from-[#724326] hover:to-[#8c5832] text-white font-semibold text-xs shadow-lg shadow-[#8c5832]/30 hover:scale-[1.02] active:scale-95 transition duration-150 border border-white/15">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajukan STNK Hilang</span>
                </a>
                <a href="{{ route('user.kecelakaan.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white font-semibold text-xs shadow-lg shadow-rose-600/30 hover:scale-[1.02] active:scale-95 transition duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Lapor Kecelakaan 🚨</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Statistik Counter Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
        {{-- Card STNK --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-card hover:shadow-lg transition duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">Pengaduan STNK</span>
                <p class="text-3xl font-extrabold text-slate-900">{{ $stnkCount }}</p>
                <a href="{{ route('user.stnk.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 hover:underline pt-1">
                    <span>Lihat semua berkas</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#724326] to-[#c89262] text-white flex items-center justify-center shadow-lg shadow-[#724326]/20 group-hover:scale-110 transition duration-200">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        {{-- Card Kecelakaan --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-card hover:shadow-lg transition duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">Laporan Kecelakaan</span>
                <p class="text-3xl font-extrabold text-slate-900">{{ $kecelakaanCount }}</p>
                <a href="{{ route('user.kecelakaan.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700 hover:underline pt-1">
                    <span>Lihat riwayat laporan</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-rose-600 to-amber-500 text-white flex items-center justify-center shadow-lg shadow-rose-500/20 group-hover:scale-110 transition duration-200">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Dua Kolom Aktivitas Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- List STNK Terbaru --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                    <h2 class="font-bold text-slate-800 text-sm">Pengaduan STNK Terbaru</h2>
                </div>
                <a href="{{ route('user.stnk.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="space-y-2.5">
                @forelse($stnkTerbaru as $item)
                    <a href="{{ route('user.stnk.show', $item) }}"
                       class="group p-3.5 rounded-2xl border border-slate-100 hover:border-brand-200 hover:bg-slate-50/80 transition duration-150 flex items-center justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <div class="flex items-center gap-2">
                                @if($item->plat_nomor)
                                    <span class="px-2 py-0.5 bg-slate-900 text-white rounded text-[11px] font-mono font-bold">
                                        {{ $item->plat_nomor }}
                                    </span>
                                @endif
                                <p class="font-semibold text-xs sm:text-sm text-slate-900 group-hover:text-brand-600 transition truncate">
                                    {{ $item->merk_tipe ?: $item->jenis_kendaraan }}
                                </p>
                            </div>
                            <p class="text-[11px] text-slate-400">
                                {{ $item->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold shrink-0 {{ $item->statusColor() }}">
                            {{ $item->statusLabel() }}
                        </span>
                    </a>
                @empty
                    <div class="py-8 text-center text-slate-400 space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-xs">Belum ada pengaduan STNK yang diajukan.</p>
                        <a href="{{ route('user.stnk.create') }}" class="inline-block text-xs font-bold text-brand-600 hover:underline">
                            + Ajukan sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- List Kecelakaan Terbaru --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                    <h2 class="font-bold text-slate-800 text-sm">Laporan Kecelakaan Terbaru</h2>
                </div>
                <a href="{{ route('user.kecelakaan.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="space-y-2.5">
                @forelse($kecelakaanTerbaru as $item)
                    <a href="{{ route('user.kecelakaan.show', $item) }}"
                       class="group p-3.5 rounded-2xl border border-slate-100 hover:border-rose-200 hover:bg-slate-50/80 transition duration-150 flex items-center justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <p class="font-semibold text-xs sm:text-sm text-slate-900 group-hover:text-rose-600 transition truncate">
                                {{ $item->judul }}
                            </p>
                            <p class="text-[11px] text-slate-400">
                                {{ $item->created_at->diffForHumans() }}
                                @if($item->nama_lokasi)
                                    · 📍 {{ Str::limit($item->nama_lokasi, 35) }}
                                @endif
                            </p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold shrink-0 {{ $item->statusColor() }}">
                            {{ $item->statusLabel() }}
                        </span>
                    </a>
                @empty
                    <div class="py-8 text-center text-slate-400 space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="text-xs">Belum ada laporan kecelakaan darurat.</p>
                        <a href="{{ route('user.kecelakaan.create') }}" class="inline-block text-xs font-bold text-rose-600 hover:underline">
                            + Lapor kejadian
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
