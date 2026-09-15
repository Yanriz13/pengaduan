@extends('layouts.app')
@section('title', 'Daftar Pengaduan STNK - Akun Warga')

@section('content')
<div class="space-y-6">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengaduan Pembuatan STNK</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar permohonan surat kehilangan dan pengurusan STNK Anda.</p>
        </div>
        <a href="{{ route('user.stnk.create') }}"
           class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm hover:shadow transition self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>+ Ajukan Pengaduan Baru</span>
        </a>
    </div>

    {{-- Kartu Daftar Pengaduan --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card divide-y divide-slate-100 overflow-hidden">
        @forelse($items as $item)
            <a href="{{ route('user.stnk.show', $item) }}"
               class="flex flex-col sm:flex-row sm:items-center justify-between p-5 hover:bg-slate-50/80 transition duration-150 gap-4 group">
                <div class="space-y-1.5 min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($item->plat_nomor)
                            <span class="px-2.5 py-0.5 bg-slate-900 text-white rounded-lg text-xs font-mono font-bold tracking-wider shadow-sm">
                                {{ $item->plat_nomor }}
                            </span>
                        @endif
                        <p class="font-bold text-sm text-slate-900 group-hover:text-brand-600 transition">
                            {{ $item->merk_tipe ?: $item->jenis_kendaraan }}
                        </p>
                        @if($item->jenis_model)
                            <span class="text-[11px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">
                                {{ $item->jenis_model }}
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400">
                        <span>Pemilik: <strong class="text-slate-600 font-medium">{{ $item->nama_pemilik ?: $item->nama_pemohon }}</strong></span>
                        <span>·</span>
                        <span>Diajukan {{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0 self-start sm:self-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>
                    <svg class="w-4 h-4 text-slate-300 group-hover:text-brand-600 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        @empty
            <div class="py-12 text-center text-slate-400 space-y-3">
                <div class="w-16 h-16 rounded-3xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Belum ada pengaduan STNK</p>
                    <p class="text-xs text-slate-400 mt-0.5">Ajukan surat keterangan kehilangan STNK secara online sekarang.</p>
                </div>
                <a href="{{ route('user.stnk.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-semibold hover:bg-brand-700 transition">
                    <span>+ Buat Pengaduan Sekarang</span>
                </a>
            </div>
        @endforelse
    </div>

    <div>{{ $items->links() }}</div>

</div>
@endsection
