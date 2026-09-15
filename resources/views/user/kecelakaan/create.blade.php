@extends('layouts.app')
@section('title', 'Lapor Kecelakaan')
@section('content')

<div class="mb-6 max-w-xl mx-auto">
    <a href="{{ route('user.kecelakaan.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-2">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Kembali ke riwayat laporan</span>
    </a>
    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">🚨 Lapor Kecelakaan Darurat</h1>
    <p class="text-xs sm:text-sm text-slate-500 mt-1">Ambil foto kejadian secara langsung — lokasi GPS akan otomatis terdeteksi.</p>
</div>

<form method="POST" action="{{ route('user.kecelakaan.store') }}" enctype="multipart/form-data"
      id="form-laporan" class="space-y-5 max-w-xl mx-auto">
    @csrf

    {{-- ─── PANEL KAMERA ─── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="font-bold text-slate-900 text-sm">📷 Foto Bukti Kejadian</h2>
            <span class="text-[11px] text-slate-400 font-medium">Kamera / Galeri</span>
        </div>

        {{-- Area preview / placeholder --}}
        <div id="foto-preview-wrapper"
             class="relative w-full aspect-video bg-slate-50 border-2 border-dashed border-slate-200 hover:border-brand-400 rounded-2xl overflow-hidden flex items-center justify-center cursor-pointer transition"
             onclick="document.getElementById('input-foto').click()">
            <div id="foto-placeholder" class="text-center pointer-events-none p-4">
                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-2xl mx-auto mb-2.5">
                    📷
                </div>
                <p class="text-xs sm:text-sm font-bold text-slate-700">Ambil Foto / Pilih dari Galeri</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Klik di sini untuk membuka kamera ponsel Anda</p>
            </div>
            <img id="foto-preview" src="" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover">
        </div>

        {{-- Input file — capture=environment agar langsung kamera belakang di HP --}}
        <input type="file" id="input-foto" name="foto"
               accept="image/*" capture="environment"
               class="hidden">

        {{-- Tombol aksi foto --}}
        <div class="flex gap-2">
            <button type="button" id="btn-kamera"
                onclick="document.getElementById('input-foto').click()"
                class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-bold px-4 py-3 rounded-2xl shadow-sm transition">
                📷 Ambil / Ganti Foto
            </button>
            <button type="button" id="btn-hapus-foto"
                class="hidden px-4 py-3 rounded-2xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs sm:text-sm font-bold transition">
                🗑 Hapus
            </button>
        </div>

        @error('foto')
            <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    {{-- ─── LOKASI ─── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3.5" id="panel-lokasi">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="font-bold text-slate-900 text-sm">📍 Titik Lokasi GPS</h2>
            <span id="lokasi-status" class="text-[11px] text-slate-400 italic">Belum terdeteksi</span>
        </div>

        {{-- Nama lokasi (hasil reverse geocoding) --}}
        <div id="nama-lokasi-box" class="hidden bg-emerald-50 border border-emerald-200/80 rounded-2xl p-3.5">
            <p class="text-[11px] text-emerald-700 font-bold uppercase tracking-wide mb-0.5">📍 Lokasi Terdeteksi:</p>
            <p id="nama-lokasi-text" class="text-xs text-emerald-950 font-semibold leading-relaxed"></p>
        </div>

        {{-- Koordinat tersembunyi --}}
        <input type="hidden" id="latitude"    name="latitude"    value="{{ old('latitude') }}">
        <input type="hidden" id="longitude"   name="longitude"   value="{{ old('longitude') }}">
        <input type="hidden" id="nama_lokasi" name="nama_lokasi" value="{{ old('nama_lokasi') }}">

        {{-- Tombol ambil lokasi manual --}}
        <button type="button" id="btn-lokasi"
            class="inline-flex items-center gap-2 text-xs font-bold text-brand-700 bg-brand-50 border border-brand-200 hover:bg-brand-100 px-4 py-2.5 rounded-2xl transition">
            <span id="lokasi-icon">🔍</span>
            <span id="lokasi-label">Deteksi Lokasi GPS Sekarang</span>
        </button>

        {{-- Koordinat detail (tersembunyi, tampil setelah deteksi) --}}
        <div id="koordinat-detail" class="hidden text-xs text-slate-400 font-mono bg-slate-50 p-2 rounded-xl">
            <span id="lat-display"></span>, <span id="lng-display"></span>
        </div>

        @error('latitude')
            <p class="text-xs text-rose-500 font-semibold">⚠️ {{ $message }} — Aktifkan GPS lalu klik "Deteksi Lokasi GPS Sekarang".</p>
        @enderror
    </div>

    {{-- ─── INFO LAPORAN ─── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="font-bold text-slate-900 text-sm">📝 Keterangan Laporan</h2>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                Judul Laporan Singkat <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                   placeholder="Contoh: Tabrakan roda dua di depan SPBU"
                   class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20">
            @error('judul')
                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Deskripsi Kronologi</label>
            <textarea name="deskripsi" rows="3"
                      placeholder="Ceritakan kronologi singkat kejadian atau kondisi korban di lapangan..."
                      class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20">{{ old('deskripsi') }}</textarea>
        </div>
    </div>

    <button type="submit" id="btn-submit"
        class="w-full bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-700 hover:to-red-700 text-white font-extrabold py-3.5 rounded-2xl text-sm transition shadow-lg shadow-rose-600/25 active:scale-[0.99]">
        🚨 Kirim Laporan Kecelakaan ke Petugas
    </button>
</form>

<script>
/* ═══════════════════════════════════════
   PREVIEW FOTO
═══════════════════════════════════════ */
const inputFoto    = document.getElementById('input-foto');
const preview      = document.getElementById('foto-preview');
const placeholder  = document.getElementById('foto-placeholder');
const btnHapus     = document.getElementById('btn-hapus-foto');

inputFoto.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        btnHapus.classList.remove('hidden');
    };
    reader.readAsDataURL(file);

    // Otomatis ambil lokasi saat foto diambil
    ambilLokasi();
});

btnHapus.addEventListener('click', function () {
    inputFoto.value = '';
    preview.src = '';
    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    btnHapus.classList.add('hidden');
});

/* ═══════════════════════════════════════
   GPS + REVERSE GEOCODING
═══════════════════════════════════════ */
const btnLokasi      = document.getElementById('btn-lokasi');
const lokStatus      = document.getElementById('lokasi-status');
const lokIcon        = document.getElementById('lokasi-icon');
const lokLabel       = document.getElementById('lokasi-label');
const namaBox        = document.getElementById('nama-lokasi-box');
const namaText       = document.getElementById('nama-lokasi-text');
const koordinatDetail= document.getElementById('koordinat-detail');
const latDisplay     = document.getElementById('lat-display');
const lngDisplay     = document.getElementById('lng-display');

const inputLat  = document.getElementById('latitude');
const inputLng  = document.getElementById('longitude');
const inputNama = document.getElementById('nama_lokasi');

btnLokasi.addEventListener('click', ambilLokasi);

function ambilLokasi() {
    if (!navigator.geolocation) {
        lokStatus.textContent = '❌ GPS tidak didukung perangkat ini';
        return;
    }

    lokIcon.textContent  = '⏳';
    lokLabel.textContent = 'Mendeteksi lokasi...';
    lokStatus.textContent = 'Mengambil koordinat GPS...';
    btnLokasi.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            inputLat.value = lat;
            inputLng.value = lng;

            latDisplay.textContent = lat.toFixed(6);
            lngDisplay.textContent = lng.toFixed(6);
            koordinatDetail.classList.remove('hidden');

            lokIcon.textContent  = '✅';
            lokLabel.textContent = 'Lokasi Terdeteksi — Klik untuk Refresh';
            lokStatus.textContent = 'GPS aktif';
            btnLokasi.disabled = false;

            // Reverse geocoding via OpenStreetMap Nominatim
            reverseGeocode(lat, lng);
        },
        function (err) {
            lokIcon.textContent  = '❌';
            lokLabel.textContent = 'Gagal — Coba Lagi';
            lokStatus.textContent = 'GPS gagal. Pastikan izin lokasi diaktifkan.';
            btnLokasi.disabled = false;
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

function reverseGeocode(lat, lng) {
    namaBox.classList.remove('hidden');
    namaText.textContent = 'Mencari nama lokasi...';

    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`)
        .then(r => r.json())
        .then(data => {
            const addr    = data.address || {};
            const jalan   = addr.road || addr.pedestrian || addr.footway || '';
            const nomor   = addr.house_number ? ' No.' + addr.house_number : '';
            const kel     = addr.suburb || addr.village || addr.neighbourhood || '';
            const kec     = addr.city_district || addr.county || '';
            const kota    = addr.city || addr.town || addr.municipality || '';
            const provinsi= addr.state || '';

            const parts = [jalan + nomor, kel, kec, kota, provinsi].filter(Boolean);
            const namaLengkap = parts.join(', ') || data.display_name || `${lat}, ${lng}`;

            namaText.textContent = namaLengkap;
            inputNama.value      = namaLengkap;
        })
        .catch(() => {
            const fallback = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            namaText.textContent = fallback;
            inputNama.value      = fallback;
        });
}

// Jika ada old() value (setelah validasi error), tampilkan kembali
@if(old('latitude'))
    inputLat.value = '{{ old('latitude') }}';
    inputLng.value = '{{ old('longitude') }}';
    const lat = parseFloat('{{ old('latitude') }}');
    const lng = parseFloat('{{ old('longitude') }}');
    latDisplay.textContent = lat.toFixed(6);
    lngDisplay.textContent = lng.toFixed(6);
    koordinatDetail.classList.remove('hidden');
    @if(old('nama_lokasi'))
        namaText.textContent = '{{ old('nama_lokasi') }}';
        namaBox.classList.remove('hidden');
        inputNama.value = '{{ old('nama_lokasi') }}';
        lokIcon.textContent = '✅';
        lokLabel.textContent = 'Lokasi Terdeteksi — Klik untuk Refresh';
    @endif
@endif
</script>
@endsection
