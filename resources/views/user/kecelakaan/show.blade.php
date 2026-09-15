@extends('layouts.app')
@section('title', 'Detail Laporan Kecelakaan')

@section('content')
<div class="space-y-6">

    {{-- Header & Status --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <a href="{{ route('user.kecelakaan.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-2">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali ke riwayat laporan</span>
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $item->judul }}</h1>
            <p class="text-xs text-slate-400 mt-0.5">Dilaporkan pada {{ $item->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 self-start sm:self-auto {{ $item->statusColor() }}">
            {{ $item->statusLabel() }}
        </span>
    </div>

    {{-- Grid: Peta Lokasi & Chat Thread --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        {{-- Panel Kiri: Lokasi Kejadian & Foto --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
            <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-sm text-slate-900">Titik Koordinat Kejadian</h2>
                    <p class="text-[11px] text-slate-400">Lokasi GPS yang Anda laporkan</p>
                </div>
                @if($item->google_maps_url)
                    <a href="{{ $item->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 hover:scale-[1.02] active:scale-95 transition">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                        </svg>
                        <span>Buka di Google Maps ↗</span>
                    </a>
                @endif
            </div>

            @if($item->nama_lokasi)
                <div class="p-3.5 bg-red-50/70 border border-red-100 rounded-2xl flex items-start gap-3">
                    <span class="text-lg leading-none mt-0.5">📍</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-bold text-red-900 uppercase tracking-wide">Patokan / Alamat Terdeteksi:</p>
                        <p class="text-xs text-red-800 mt-0.5 leading-relaxed font-semibold">{{ $item->nama_lokasi }}</p>
                    </div>
                </div>
            @endif

            {{-- Leaflet Map Container --}}
            <div id="map" class="w-full h-72 rounded-2xl border border-slate-200 z-10 overflow-hidden shadow-inner"></div>

            <div class="flex flex-wrap items-center justify-between gap-2 p-3 bg-slate-50 rounded-2xl border border-slate-100 text-xs">
                <div class="font-mono text-slate-600">
                    <span class="text-slate-400">Koordinat:</span> {{ $item->latitude }}, {{ $item->longitude }}
                </div>
                @if($item->google_maps_url)
                    <button type="button" onclick="copyMapUrl('{{ $item->google_maps_url }}', this)"
                            class="inline-flex items-center gap-1 px-3 py-1 bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl text-xs font-semibold shadow-sm transition">
                        <svg class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>Salin Link Maps</span>
                    </button>
                @endif
            </div>

            @if($item->foto_path)
                <div class="pt-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Foto Bukti Kejadian:</p>
                    <a href="{{ asset('storage/'.$item->foto_path) }}" target="_blank" class="block group relative rounded-2xl overflow-hidden shadow-sm border border-slate-200">
                        <img src="{{ asset('storage/'.$item->foto_path) }}" class="w-full max-h-56 object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition">
                            🔍 Perbesar Foto
                        </div>
                    </a>
                </div>
            @endif
        </div>

        {{-- Panel Kanan: Percakapan / Chat Thread dengan Petugas --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 flex flex-col h-[34rem]">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                    <h2 class="font-bold text-sm text-slate-900">Percakapan dengan Petugas Piket</h2>
                </div>
                <span class="text-[11px] text-slate-400">Komunikasi Langsung</span>
            </div>

            {{-- Message History Stream --}}
            <div class="flex-1 overflow-y-auto space-y-3.5 pr-2" id="chat-stream">
                @forelse($item->messages as $msg)
                    @php $isMine = $msg->user_id === auth()->id(); @endphp
                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[85%] {{ $isMine ? 'bg-gradient-to-r from-[#8c5832] to-[#b0774a] text-white rounded-2xl rounded-tr-none' : 'bg-slate-100 text-slate-800 rounded-2xl rounded-tl-none border border-slate-200/60' }} px-4 py-3 shadow-sm text-sm space-y-1">
                            <div class="flex items-center justify-between gap-4 text-[10px] {{ $isMine ? 'text-white/80' : 'text-slate-400' }}">
                                <span class="font-bold">{{ $isMine ? 'Anda (Pelapor)' : ($msg->user->name . ' (Petugas Piket)') }}</span>
                                <span>{{ $msg->created_at->format('H:i') }}</span>
                            </div>

                            @if($msg->pesan)
                                <p class="leading-relaxed whitespace-pre-wrap">{{ $msg->pesan }}</p>
                            @endif

                            @if($msg->nama_lokasi)
                                <p class="text-xs font-semibold {{ $isMine ? 'text-white/90' : 'text-slate-700' }}">
                                    📍 {{ $msg->nama_lokasi }}
                                </p>
                            @endif

                            @if($msg->latitude && $msg->longitude)
                                <div class="pt-1">
                                    <a href="{{ $msg->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-xl {{ $isMine ? 'bg-white/20 hover:bg-white/30 text-white' : 'bg-red-50 hover:bg-red-100 text-red-600 border border-red-200' }} transition">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                                        </svg>
                                        <span>Buka di Google Maps</span>
                                    </a>
                                </div>
                            @endif

                            @if($msg->foto_path)
                                <div class="pt-1">
                                    <a href="{{ asset('storage/'.$msg->foto_path) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$msg->foto_path) }}" class="rounded-xl max-h-40 object-cover border {{ $isMine ? 'border-white/20' : 'border-slate-200' }}">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-center text-slate-400 py-12">Belum ada percakapan dengan petugas.</p>
                @endforelse
            </div>

            {{-- Form Kirim Pesan --}}
            <form method="POST" action="{{ route('user.kecelakaan.pesan', $item) }}" enctype="multipart/form-data" class="mt-3 pt-3 border-t border-slate-100 space-y-2">
                @csrf
                <textarea name="pesan" rows="2" placeholder="Ketik pesan atau informasi tambahan untuk petugas..."
                    class="w-full text-xs sm:text-sm rounded-2xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20"></textarea>
                
                <div class="flex items-center justify-between gap-2">
                    <input type="file" name="foto" accept="image/*"
                           class="text-xs text-slate-500 file:mr-2 file:text-xs file:font-semibold file:border-0 file:bg-slate-100 file:text-slate-700 file:px-3 file:py-1.5 file:rounded-xl cursor-pointer">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-5 py-2 rounded-xl shadow-sm transition shrink-0">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>

{{-- Leaflet Map Scripts --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([{{ $item->latitude ?? -6.2 }}, {{ $item->longitude ?? 106.8 }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const popupHtml = `
        <div style="font-family: inherit; min-width: 180px; padding: 2px;">
            <strong style="font-size: 13px; color: #0f172a; display: block; margin-bottom: 4px;">Titik Kejadian</strong>
            @if($item->nama_lokasi)
                <div style="font-size: 11px; color: #475569; margin-bottom: 6px; line-height: 1.3;">{{ addslashes($item->nama_lokasi) }}</div>
            @endif
            <div style="font-size: 10px; color: #64748b; margin-bottom: 6px;">{{ $item->latitude }}, {{ $item->longitude }}</div>
            @if($item->google_maps_url)
                <a href="{{ $item->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                   style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; color: #dc2626; text-decoration: underline;">
                    🗺️ Buka di Google Maps &rarr;
                </a>
            @endif
        </div>
    `;

    L.marker([{{ $item->latitude ?? -6.2 }}, {{ $item->longitude ?? 106.8 }}]).addTo(map)
        .bindPopup(popupHtml).openPopup();

    function copyMapUrl(url, btn) {
        navigator.clipboard.writeText(url).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = `<span class="text-emerald-600 font-bold">✓ Tersalin!</span>`;
            setTimeout(() => {
                btn.innerHTML = originalHtml;
            }, 2000);
        }).catch(() => {
            prompt('Salin link Google Maps:', url);
        });
    }

    // Auto scroll chat to bottom
    const stream = document.getElementById('chat-stream');
    if (stream) {
        stream.scrollTop = stream.scrollHeight;
    }
</script>
@endsection
