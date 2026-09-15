@extends('layouts.app')
@section('title', 'Ajukan Pengaduan Kehilangan STNK')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">

    {{-- Breadcrumb & Judul --}}
    <div>
        <a href="{{ route('user.stnk.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-2">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali ke Daftar Pengaduan</span>
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Ajukan Pengaduan STNK Hilang</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Lengkapi data identitas pemilik dan spesifikasi kendaraan sesuai dokumen resmi (KTP & BPKB).</p>
    </div>

    <form method="POST" action="{{ route('user.stnk.store') }}" class="space-y-6">
        @csrf

        {{-- ══════════════════════════════════════════ --}}
        {{-- 1. DATA IDENTITAS PEMILIK KENDARAAN       --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="w-9 h-9 rounded-2xl bg-brand-50 text-brand-600 font-extrabold text-sm flex items-center justify-center shadow-sm">
                    1
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Data Identitas Pemilik Kendaraan</h2>
                    <p class="text-xs text-slate-400">Pastikan data sesuai dengan identitas asli pemilik pada KTP dan catatan Samsat</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nama Pemilik --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nama Pemilik Kendaraan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_pemilik"
                        value="{{ old('nama_pemilik', auth()->user()->name) }}" required
                        placeholder="Nama lengkap sesuai KTP, BPKB, dan catatan Samsat"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('nama_pemilik') border-rose-400 bg-rose-50/20 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Harus sesuai persis dengan nama yang tertera di KTP & BPKB.</p>
                    @error('nama_pemilik')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIK / Nomor KTP --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        NIK / Nomor KTP <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nik" maxlength="20"
                        value="{{ old('nik') }}" required
                        placeholder="Contoh: 3201xxxxxxxxxxxx"
                        class="w-full font-mono rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('nik') border-rose-400 bg-rose-50/20 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Sesuai identitas asli pemilik kendaraan (16 digit).</p>
                    @error('nik')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Telepon / HP --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="no_hp"
                        value="{{ old('no_hp', auth()->user()->no_hp ?? '') }}" required
                        placeholder="Contoh: 081234567890"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('no_hp') border-rose-400 bg-rose-50/20 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Nomor aktif yang dapat dihubungi oleh petugas.</p>
                    @error('no_hp')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Lengkap --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Alamat Lengkap Pemilik <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alamat" rows="2" required
                        placeholder="Alamat jalan, nomor rumah, RT/RW, Kelurahan/Desa, Kecamatan, Kota/Kabupaten"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('alamat') border-rose-400 bg-rose-50/20 @enderror">{{ old('alamat') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Sesuai dengan alamat pada KTP dan domisili terdaftar kendaraan.</p>
                    @error('alamat')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 2. DATA / SPESIFIKASI KENDARAAN BERMOTOR  --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="w-9 h-9 rounded-2xl bg-blue-50 text-blue-600 font-extrabold text-sm flex items-center justify-center shadow-sm">
                    2
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Data / Spesifikasi Kendaraan Bermotor</h2>
                    <p class="text-xs text-slate-400">Rincian spesifikasi kendaraan yang STNK-nya dilaporkan hilang</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nomor Polisi (Plat Nomor) --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nomor Polisi (Plat Nomor) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="plat_nomor"
                        value="{{ old('plat_nomor') }}" required
                        placeholder="Contoh: B 1234 ABC"
                        class="w-full uppercase font-mono tracking-wider rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('plat_nomor') border-rose-400 bg-rose-50/20 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Nomor kendaraan yang STNK-nya hilang.</p>
                    @error('plat_nomor')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Merk dan Tipe Kendaraan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Merk dan Tipe Kendaraan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="merk_tipe"
                        value="{{ old('merk_tipe') }}" required
                        placeholder="Contoh: Honda Vario 125, Toyota Avanza 1.3 G"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('merk_tipe') border-rose-400 bg-rose-50/20 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Pabrikan merk serta tipe varian kendaraan.</p>
                    @error('merk_tipe')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis dan Model Kendaraan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Jenis dan Model Kendaraan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="jenis_model" list="jenis-model-list"
                        value="{{ old('jenis_model') }}" required
                        placeholder="Contoh: Sepeda Motor / Minibus / Sedan"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('jenis_model') border-rose-400 bg-rose-50/20 @enderror">
                    <datalist id="jenis-model-list">
                        <option value="Sepeda Motor">
                        <option value="Minibus">
                        <option value="Sedan">
                        <option value="Pick Up">
                        <option value="Truk">
                        <option value="SUV">
                        <option value="Hatchback">
                    </datalist>
                    <p class="text-[11px] text-slate-400 mt-1">Bentuk / model klasifikasi fisik kendaraan.</p>
                    @error('jenis_model')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Pembuatan dan Warna Kendaraan --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Tahun <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="tahun_pembuatan" min="1970" max="{{ date('Y') + 1 }}"
                            value="{{ old('tahun_pembuatan', date('Y')) }}" required
                            placeholder="2022"
                            class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('tahun_pembuatan') border-rose-400 bg-rose-50/20 @enderror">
                        @error('tahun_pembuatan')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Warna <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="warna"
                            value="{{ old('warna') }}" required
                            placeholder="Hitam Metalik"
                            class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition @error('warna') border-rose-400 bg-rose-50/20 @enderror">
                        @error('warna')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Nomor Rangka --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nomor Rangka (VIN)
                    </label>
                    <input type="text" name="nomor_rangka"
                        value="{{ old('nomor_rangka') }}"
                        placeholder="Nomor unik rangka dari BPKB / cek fisik"
                        class="w-full font-mono uppercase rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition">
                    <p class="text-[11px] text-slate-400 mt-1">Tercantum pada BPKB atau hasil gesek cek fisik.</p>
                </div>

                {{-- Nomor Mesin --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nomor Mesin
                    </label>
                    <input type="text" name="nomor_mesin"
                        value="{{ old('nomor_mesin') }}"
                        placeholder="Nomor unik mesin kendaraan"
                        class="w-full font-mono uppercase rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition">
                    <p class="text-[11px] text-slate-400 mt-1">Sesuai hasil gesek mesin atau yang tertera di BPKB.</p>
                </div>

                {{-- Nomor BPKB --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nomor BPKB
                    </label>
                    <input type="text" name="nomor_bpkb"
                        value="{{ old('nomor_bpkb') }}"
                        placeholder="Nomor Buku Pemilik Kendaraan Bermotor (contoh: M-1234567-B)"
                        class="w-full font-mono uppercase rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition">
                    <p class="text-[11px] text-slate-400 mt-1">Nomor tercetak di lembar cover atau lembar data kepemilikan BPKB.</p>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 3. KRONOLOGI / KETERANGAN KEHILANGAN      --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-4">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="w-9 h-9 rounded-2xl bg-amber-50 text-amber-600 font-extrabold text-sm flex items-center justify-center shadow-sm">
                    3
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Kronologi / Keterangan Kejadian</h2>
                    <p class="text-xs text-slate-400">Deskripsi singkat perihal kehilangan STNK (opsional)</p>
                </div>
            </div>

            <div>
                <textarea name="deskripsi" rows="3"
                    placeholder="Ceritakan kronologi singkat kehilangan, perkiraan waktu, perkiraan lokasi, atau keterangan pendukung lainnya..."
                    class="w-full rounded-2xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 transition">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2c170e] via-[#52331f] to-[#3a2012] hover:from-[#3d2315] hover:to-[#4a2918] text-white font-bold px-6 py-3 rounded-2xl shadow-lg shadow-[#2c170e]/25 hover:shadow-[#2c170e]/35 active:scale-95 transition text-sm border border-[#c89262]/20">
                <span>🚀 Kirim Pengaduan STNK</span>
            </button>
            <a href="{{ route('user.stnk.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 px-4 py-3">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
