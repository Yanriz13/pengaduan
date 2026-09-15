@extends('layouts.app')
@section('title', 'Laporan Kecelakaan Darurat - Petugas Admin')

@section('content')
<div class="space-y-6">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Laporan Kecelakaan Darurat</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pantau titik koordinat kejadian, lokasi GPS, dan tanggapi pesan pelapor secara real-time.</p>
        </div>
    </div>

    {{-- Filter Status Tabs (Segmented Pill) --}}
    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs font-semibold no-scrollbar">
        <a href="{{ route('admin.kecelakaan.index') }}"
           class="px-3.5 py-2 rounded-xl transition whitespace-nowrap {{ !request('status') ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
            Semua Laporan
        </a>
        @foreach(['baru' => 'Baru Masuk', 'diproses' => 'Sedang Ditangani', 'selesai' => 'Selesai'] as $key => $label)
            <a href="{{ route('admin.kecelakaan.index', ['status' => $key]) }}"
               class="px-3.5 py-2 rounded-xl transition whitespace-nowrap {{ request('status') === $key ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Daftar Laporan Table/Cards --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card divide-y divide-slate-100 overflow-hidden">
        @forelse($items as $item)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 hover:bg-slate-50/80 transition duration-150 gap-4">
                <a href="{{ route('admin.kecelakaan.show', $item) }}" class="flex-1 min-w-0 space-y-1.5 group">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $item->status === 'baru' ? 'bg-rose-500 animate-ping' : 'bg-slate-300' }}"></span>
                        <p class="font-bold text-sm text-slate-900 group-hover:text-rose-600 transition truncate">
                            {{ $item->judul }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400">
                        <span>Pelapor: <strong class="text-slate-700 font-medium">{{ $item->user->name }}</strong></span>
                        <span>·</span>
                        <span>{{ $item->created_at->diffForHumans() }}</span>
                        @if($item->nama_lokasi)
                            <span>·</span>
                            <span class="text-slate-600 font-medium truncate max-w-sm">📍 {{ $item->nama_lokasi }}</span>
                        @endif
                    </div>
                </a>

                <div class="flex items-center gap-2.5 shrink-0 self-start sm:self-center">
                    @if($item->google_maps_url)
                        <a href="{{ $item->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                           title="Buka titik koordinat di Google Maps"
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm transition">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                            </svg>
                            <span>Maps ↗</span>
                        </a>
                    @endif

                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>

                    <a href="{{ route('admin.kecelakaan.show', $item) }}"
                       class="text-xs font-bold text-brand-600 hover:text-brand-700 px-2 py-1">
                        Buka &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-slate-400 space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="text-xs">Tidak ada laporan kecelakaan dengan status ini.</p>
            </div>
        @endforelse
    </div>

    <div>{{ $items->links() }}</div>

</div>
@endsection
