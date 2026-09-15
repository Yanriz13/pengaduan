@extends('layouts.app')
@section('title', 'Riwayat Laporan Kecelakaan - Akun Warga')

@section('content')
<div class="space-y-6">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Laporan Kejadian Kecelakaan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar laporan kecelakaan darurat yang telah Anda kirimkan ke petugas piket.</p>
        </div>
        <a href="{{ route('user.kecelakaan.create') }}"
           class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-md shadow-rose-600/20 transition self-start sm:self-auto">
            <span>🚨 + Lapor Kejadian Baru</span>
        </a>
    </div>

    {{-- Daftar Laporan --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card divide-y divide-slate-100 overflow-hidden">
        @forelse($items as $item)
            <a href="{{ route('user.kecelakaan.show', $item) }}"
               class="flex flex-col sm:flex-row sm:items-center justify-between p-5 hover:bg-slate-50/80 transition duration-150 gap-4 group">
                <div class="space-y-1.5 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $item->status === 'baru' ? 'bg-rose-500 animate-ping' : 'bg-slate-300' }}"></span>
                        <p class="font-bold text-sm text-slate-900 group-hover:text-rose-600 transition truncate">
                            {{ $item->judul }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400">
                        <span>Dilaporkan {{ $item->created_at->diffForHumans() }}</span>
                        @if($item->nama_lokasi)
                            <span>·</span>
                            <span class="text-slate-600 font-medium truncate max-w-sm">📍 {{ $item->nama_lokasi }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0 self-start sm:self-center">
                    @if($item->google_maps_url)
                        <span class="text-[11px] px-2.5 py-1 rounded-lg bg-red-50 text-red-700 border border-red-200/80 font-semibold inline-flex items-center gap-1">
                            🗺️ Maps
                        </span>
                    @endif
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>
                    <svg class="w-4 h-4 text-slate-300 group-hover:text-rose-600 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        @empty
            <div class="py-12 text-center text-slate-400 space-y-3">
                <div class="w-16 h-16 rounded-3xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Belum ada laporan kecelakaan</p>
                    <p class="text-xs text-slate-400 mt-0.5">Jika Anda melihat atau mengalami kecelakaan di jalan, laporkan segera ke petugas.</p>
                </div>
                <a href="{{ route('user.kecelakaan.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-semibold hover:bg-rose-700 transition">
                    <span>🚨 Buat Laporan Darurat</span>
                </a>
            </div>
        @endforelse
    </div>

    <div>{{ $items->links() }}</div>

</div>
@endsection
