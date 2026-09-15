@extends('layouts.app')
@section('title', 'Tinjau Pengaduan STNK - Petugas Admin')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    {{-- Header & Status --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.stnk.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-2">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali ke daftar pengaduan</span>
            </a>
            <div class="flex flex-wrap items-center gap-2.5">
                @if($item->plat_nomor)
                    <span class="px-3 py-1 bg-slate-900 text-white rounded-xl text-sm font-mono font-bold tracking-wider shadow-sm">
                        {{ $item->plat_nomor }}
                    </span>
                @endif
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    {{ $item->merk_tipe ?: $item->jenis_kendaraan }}
                </h1>
            </div>
        </div>
        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 self-start sm:self-auto {{ $item->statusColor() }}">
            {{ $item->statusLabel() }}
        </span>
    </div>

    {{-- Info Pemohon & Spesifikasi Kendaraan Lengkap (Kartu Inspeksi Petugas) --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-6">
        {{-- 1. Data Identitas Pemilik Kendaraan --}}
        <div>
            <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100">
                <div class="w-7 h-7 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-xs font-bold">👤</div>
                <h2 class="font-bold text-sm text-slate-800">1. Data Identitas Pemilik Kendaraan</h2>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-sm">
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nama Pemilik (KTP/BPKB)</dt>
                    <dd class="font-bold text-slate-900 mt-0.5">{{ $item->nama_pemilik ?: $item->nama_pemohon }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">NIK / Nomor KTP</dt>
                    <dd class="font-mono font-bold text-slate-900 mt-0.5">{{ $item->nik ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Telepon / WhatsApp</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">
                        @if($item->no_hp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank"
                               class="text-emerald-600 hover:text-emerald-700 font-semibold inline-flex items-center gap-1.5 hover:underline">
                                <span>{{ $item->no_hp }}</span>
                                <span class="text-[10px] bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded-full font-bold">WhatsApp ↗</span>
                            </a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Akun Pelapor</dt>
                    <dd class="text-slate-700 text-xs font-medium mt-0.5">{{ $item->user->name }} ({{ $item->user->email }})</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Waktu Pengajuan</dt>
                    <dd class="text-slate-800 text-xs font-medium mt-0.5">{{ $item->created_at->translatedFormat('d M Y H:i') }}</dd>
                </div>
                <div class="sm:col-span-2 md:col-span-3 bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Alamat Lengkap (KTP & Domisili Terdaftar)</dt>
                    <dd class="font-medium text-slate-800 text-xs leading-relaxed mt-1">{{ $item->alamat ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- 2. Data / Spesifikasi Kendaraan Bermotor --}}
        <div>
            <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100">
                <div class="w-7 h-7 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">🚗</div>
                <h2 class="font-bold text-sm text-slate-800">2. Data / Spesifikasi Kendaraan Bermotor</h2>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Polisi</dt>
                    <dd class="font-mono font-bold text-slate-900 mt-0.5">{{ $item->plat_nomor ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Merk & Tipe</dt>
                    <dd class="font-bold text-slate-900 mt-0.5">{{ $item->merk_tipe ?: $item->jenis_kendaraan }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Jenis & Model</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">{{ $item->jenis_model ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tahun & Warna</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">
                        {{ $item->tahun_pembuatan ? $item->tahun_pembuatan . ' · ' : '' }}{{ $item->warna ?: '-' }}
                    </dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Rangka</dt>
                    <dd class="font-mono text-xs text-slate-800 mt-0.5">{{ $item->nomor_rangka ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Mesin</dt>
                    <dd class="font-mono text-xs text-slate-800 mt-0.5">{{ $item->nomor_mesin ?: '-' }}</dd>
                </div>
                <div class="sm:col-span-2 bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor BPKB</dt>
                    <dd class="font-mono font-medium text-slate-900 mt-0.5">{{ $item->nomor_bpkb ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        @if($item->deskripsi)
            <div class="pt-2 border-t border-slate-100">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Kronologi / Catatan Kejadian dari Pemohon</p>
                <p class="text-xs text-slate-700 bg-slate-50/80 rounded-2xl p-4 leading-relaxed border border-slate-100">{{ $item->deskripsi }}</p>
            </div>
        @endif
    </div>

    {{-- ─── Panel Persyaratan Berkas untuk Pemohon ─── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h2 class="font-bold text-slate-900 text-base">📋 Persyaratan Berkas untuk Pemohon</h2>
                <p class="text-xs text-slate-400 mt-0.5">Tentukan berkas yang wajib diunggah pemohon untuk proses validasi</p>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">
                {{ $item->persyaratanBerkas->count() }} item
            </span>
        </div>

        {{-- Daftar Persyaratan yang Sudah Ada --}}
        @if($item->persyaratanBerkas->count() > 0)
            <div class="divide-y divide-slate-100 space-y-1">
                @foreach($item->persyaratanBerkas as $berkas)
                    <div class="flex items-start justify-between py-3.5 gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-sm text-slate-900">{{ $berkas->label }}</span>
                                @if($berkas->is_required)
                                    <span class="text-[10px] bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full font-bold">Wajib</span>
                                @else
                                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium">Opsional</span>
                                @endif

                                {{-- Status User Upload --}}
                                @if($berkas->berkas_user_path)
                                    <a href="{{ asset('storage/'.$berkas->berkas_user_path) }}" target="_blank"
                                       class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full font-semibold hover:underline inline-flex items-center gap-1">
                                        <span>✅ File Telah Diunggah (Lihat)</span>
                                    </a>
                                @else
                                    <span class="text-xs bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-full font-medium">
                                        ⏳ Menunggu User
                                    </span>
                                @endif
                            </div>
                            @if($berkas->keterangan)
                                <p class="text-xs text-slate-400 mt-1">{{ $berkas->keterangan }}</p>
                            @endif
                        </div>

                        {{-- Tombol Hapus Persyaratan --}}
                        @if(in_array($item->status, ['diajukan', 'menunggu_berkas', 'rejected']))
                            <form method="POST" action="{{ route('admin.stnk.persyaratan.destroy', [$item, $berkas]) }}"
                                  onsubmit="return confirm('Hapus persyaratan ini?')"
                                  class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-50 transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400 italic py-2">Belum ada persyaratan berkas yang ditentukan.</p>
        @endif

        {{-- Form Tambah Persyaratan Baru --}}
        @if(in_array($item->status, ['diajukan', 'menunggu_berkas', 'rejected']))
            <div class="border border-dashed border-slate-200 rounded-2xl p-5 bg-slate-50/70 space-y-3">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-600">+ Tambah Persyaratan Berkas Baru</p>
                <form method="POST" action="{{ route('admin.stnk.persyaratan.store', $item) }}" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-600 block mb-1">Nama Dokumen / Berkas <span class="text-rose-500">*</span></label>
                            <input type="text" name="label" required placeholder="Contoh: KTP Asli, Fotokopi BPKB, Surat Laporan Polisi"
                                class="w-full text-xs sm:text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 bg-white">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600 block mb-1">Keterangan / Panduan (opsional)</label>
                            <input type="text" name="keterangan" placeholder="Contoh: Scan warna asli jelas terbaca"
                                class="w-full text-xs sm:text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 bg-white">
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-semibold text-slate-600">
                            <input type="checkbox" name="is_required" value="1" checked
                                class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            <span>Wajib diunggah oleh pemohon</span>
                        </label>
                        <button type="submit"
                            class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition">
                            + Tambahkan ke Daftar
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tombol Kirim Persyaratan ke Pemohon --}}
            @if($item->persyaratanBerkas->count() > 0 && $item->status === 'diajukan')
                <div class="pt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('admin.stnk.kirim-persyaratan', $item) }}" class="space-y-3">
                        @csrf
                        <textarea name="catatan_admin" rows="2"
                            placeholder="Tulis pesan / catatan khusus untuk pemohon terkait persyaratan ini (opsional)..."
                            class="w-full text-xs sm:text-sm rounded-2xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20">{{ $item->catatan_admin }}</textarea>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-bold px-6 py-3 rounded-xl shadow-md shadow-amber-500/20 transition">
                            <span>📨 Kirim Persyaratan ke Pemohon</span>
                        </button>
                    </form>
                </div>
            @elseif($item->status === 'menunggu_berkas')
                <div class="bg-amber-50 border border-amber-200 rounded-2xl px-4 py-3 text-xs text-amber-800 font-medium">
                    ⏳ Persyaratan telah dikirim ke pemohon. Menunggu pemohon melengkapi unggahan berkas.
                </div>
            @endif
        @endif
    </div>

    {{-- ─── Panel Keputusan & Verifikasi Petugas ─── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-4">
        <h2 class="font-bold text-slate-900 text-base">⚖️ Keputusan Status Pengaduan</h2>

        @if(in_array($item->status, ['diproses', 'menunggu_berkas']) && ($item->berkas_user_path || $item->persyaratanBerkas->whereNotNull('berkas_user_path')->count() > 0))
            <p class="text-xs text-slate-500">Periksa berkas yang telah dikirim pemohon di atas sebelum memutuskan.</p>
            <div class="flex flex-wrap items-center gap-3 pt-1">
                <form method="POST" action="{{ route('admin.stnk.approve', $item) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition">
                        <span>✅ Berkas Lengkap & Sah — Setujui</span>
                    </button>
                </form>

                <button type="button" onclick="document.getElementById('reject-form').classList.toggle('hidden')"
                    class="inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                    <span>❌ Tolak / Minta Perbaikan</span>
                </button>
            </div>

            <form id="reject-form" method="POST" action="{{ route('admin.stnk.reject', $item) }}" class="hidden pt-3 space-y-2">
                @csrf
                <textarea name="catatan_admin" required rows="2" placeholder="Jelaskan alasan penolakan atau berkas yang perlu diperbaiki oleh pemohon..."
                    class="w-full text-xs sm:text-sm rounded-2xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20"></textarea>
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition">
                    Kirim Penolakan ke Pemohon
                </button>
            </form>
        @elseif($item->status === 'approved')
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3 text-xs text-emerald-800 font-semibold flex items-center gap-2">
                <span>✅ Pengaduan ini telah disetujui. Silakan unggah dokumen akhir resmi di bawah ini.</span>
            </div>
        @elseif($item->status === 'rejected')
            <div class="bg-rose-50 border border-rose-200 rounded-2xl px-4 py-3 text-xs text-rose-800 font-semibold flex items-center gap-2">
                <span>❌ Pengaduan ini berstatus ditolak.</span>
            </div>
        @else
            <p class="text-xs text-slate-400">Menunggu pemohon mengunggah berkas untuk dapat diverifikasi.</p>
        @endif
    </div>

    {{-- ─── Panel Penerbitan Dokumen Akhir Resmi (setelah Approved) ─── --}}
    @if($item->status === 'approved')
    <div class="bg-white rounded-3xl border-2 border-emerald-200 shadow-card p-6 sm:p-7 space-y-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shadow-sm">
                📄
            </div>
            <div>
                <h2 class="font-extrabold text-slate-900 text-base">Penerbitan Dokumen Akhir ke Pemohon</h2>
                <p class="text-xs text-slate-400">Upload surat keterangan resmi hasil pengaduan (Surat Tanda Penerimaan Laporan Kehilangan STNK)</p>
            </div>
        </div>

        @if($item->dokumen_akhir_path)
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-bold text-emerald-900">✅ Dokumen Telah Diterbitkan</p>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ $item->nama_dokumen_akhir }}</p>
                </div>
                <a href="{{ asset('storage/'.$item->dokumen_akhir_path) }}" target="_blank"
                   class="text-xs font-bold text-brand-600 hover:underline shrink-0">
                    Lihat Dokumen ↗
                </a>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.stnk.upload-dokumen-akhir', $item) }}"
              enctype="multipart/form-data" class="space-y-3 pt-2">
            @csrf
            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-600 block mb-1">
                    Judul Dokumen Resmi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_dokumen_akhir" required
                       value="{{ old('nama_dokumen_akhir', $item->nama_dokumen_akhir ?? 'Surat Keterangan Tanda Lapor Kehilangan STNK') }}"
                       class="w-full text-xs sm:text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20">
            </div>
            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-600 block mb-1">
                    File Dokumen Resmi <span class="text-rose-500">*</span>
                    <span class="normal-case font-normal text-slate-400">(PDF, JPG, PNG - maks. 10MB)</span>
                </label>
                <input type="file" name="dokumen_akhir" required accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 file:mr-2 file:text-xs file:font-semibold file:border-0 file:bg-emerald-50 file:text-emerald-700 file:px-3 file:py-1 file:rounded-lg cursor-pointer">
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition">
                <span>📨 {{ $item->dokumen_akhir_path ? 'Perbarui Dokumen Resmi' : 'Terbitkan Dokumen ke Pemohon' }}</span>
            </button>
        </form>
    </div>
    @endif

</div>
@endsection
