@extends('layouts.app')
@section('title', 'Kelola Pengaduan STNK - Petugas Admin')

@section('content')
<div class="space-y-6">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kelola Pengaduan STNK</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Tinjau, tentukan persyaratan berkas, dan verifikasi permohonan STNK warga.</p>
        </div>
    </div>

    {{-- Filter Status Tabs (Segmented Pill) --}}
    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs font-semibold no-scrollbar">
        <a href="{{ route('admin.stnk.index') }}"
           class="px-3.5 py-2 rounded-xl transition whitespace-nowrap {{ !request('status') ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
            Semua Pengaduan
        </a>
        @foreach([
            'diajukan'        => 'Diajukan',
            'menunggu_berkas' => 'Menunggu Berkas',
            'diproses'        => 'Diproses',
            'approved'        => 'Disetujui',
            'rejected'        => 'Ditolak'
        ] as $key => $label)
            <a href="{{ route('admin.stnk.index', ['status' => $key]) }}"
               class="px-3.5 py-2 rounded-xl transition whitespace-nowrap {{ request('status') === $key ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Daftar Pengaduan Table/Card --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card divide-y divide-slate-100 overflow-hidden">
        @forelse($items as $item)
            <a href="{{ route('admin.stnk.show', $item) }}"
               class="flex flex-col sm:flex-row sm:items-center justify-between p-5 hover:bg-slate-50/80 transition duration-150 gap-4 group">
                <div class="space-y-1.5 min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($item->plat_nomor)
                            <span class="px-2.5 py-0.5 bg-slate-900 text-white rounded-lg text-xs font-mono font-bold tracking-wider shadow-sm">
                                {{ $item->plat_nomor }}
                            </span>
                        @endif
                        <p class="font-bold text-sm text-slate-900 group-hover:text-brand-600 transition truncate">
                            {{ $item->merk_tipe ?: $item->jenis_kendaraan }}
                        </p>
                        @if($item->jenis_model)
                            <span class="text-[11px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">
                                {{ $item->jenis_model }}
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400">
                        <span>Pemilik: <strong class="text-slate-700 font-medium">{{ $item->nama_pemilik ?: $item->nama_pemohon }}</strong></span>
                        @if($item->nik)
                            <span>·</span>
                            <span>NIK: <span class="font-mono text-slate-500">{{ $item->nik }}</span></span>
                        @endif
                        <span>·</span>
                        <span>Diajukan {{ $item->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0 self-start sm:self-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>
                    <span class="text-xs font-semibold text-brand-600 group-hover:translate-x-0.5 transition-transform hidden sm:inline">
                        Tinjau &rarr;
                    </span>
                </div>
            </a>
        @empty
            <div class="py-12 text-center text-slate-400 space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-xs">Tidak ada pengaduan STNK dengan kriteria ini.</p>
            </div>
        @endforelse
    </div>

    <div>{{ $items->links() }}</div>

</div>
@endsection
