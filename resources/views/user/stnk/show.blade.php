@extends('layouts.app')
@section('title', 'Detail Pengaduan STNK')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">

    {{-- Header & Status --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('user.stnk.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-2">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali ke daftar</span>
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

    {{-- Info Pengaduan Lengkap (Kartu Inspeksi) --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-6">
        {{-- 1. Data Identitas Pemilik --}}
        <div>
            <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100">
                <div class="w-7 h-7 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-xs font-bold">👤</div>
                <h2 class="font-bold text-sm text-slate-800">1. Data Identitas Pemilik Kendaraan</h2>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
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
                    <dd class="font-medium text-slate-900 mt-0.5">{{ $item->no_hp ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Waktu Pengajuan</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">{{ $item->created_at->translatedFormat('d M Y H:i') }}</dd>
                </div>
                <div class="sm:col-span-2 bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Alamat Lengkap (KTP & Domisili)</dt>
                    <dd class="font-medium text-slate-800 text-xs leading-relaxed mt-1">{{ $item->alamat ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- 2. Spesifikasi Kendaraan --}}
        <div>
            <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100">
                <div class="w-7 h-7 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">🚗</div>
                <h2 class="font-bold text-sm text-slate-800">2. Spesifikasi Kendaraan Bermotor</h2>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-sm">
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Polisi</dt>
                    <dd class="font-mono font-bold text-slate-900 mt-0.5">{{ $item->plat_nomor ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Merk & Tipe</dt>
                    <dd class="font-bold text-slate-900 mt-0.5">{{ $item->merk_tipe ?: $item->jenis_kendaraan }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Jenis / Model</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">{{ $item->jenis_model ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tahun Pembuatan</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">{{ $item->tahun_pembuatan ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Warna Kendaraan</dt>
                    <dd class="font-medium text-slate-900 mt-0.5">{{ $item->warna ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor BPKB</dt>
                    <dd class="font-mono font-medium text-slate-900 mt-0.5">{{ $item->nomor_bpkb ?: '-' }}</dd>
                </div>
                <div class="bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Rangka</dt>
                    <dd class="font-mono text-xs text-slate-800 mt-0.5">{{ $item->nomor_rangka ?: '-' }}</dd>
                </div>
                <div class="sm:col-span-2 bg-slate-50/70 p-3 rounded-2xl">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Mesin</dt>
                    <dd class="font-mono text-xs text-slate-800 mt-0.5">{{ $item->nomor_mesin ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        @if($item->deskripsi)
            <div class="pt-2 border-t border-slate-100">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Kronologi / Keterangan Tambahan</p>
                <p class="text-xs text-slate-700 bg-slate-50/80 rounded-2xl p-4 leading-relaxed border border-slate-100">{{ $item->deskripsi }}</p>
            </div>
        @endif

        @if($item->catatan_admin)
            <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200/80 rounded-2xl p-4 text-sm text-amber-900 flex items-start gap-3">
                <span class="text-lg leading-none mt-0.5">📌</span>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-xs uppercase tracking-wide text-amber-800 mb-0.5">Catatan dari Petugas Admin</p>
                    <p class="text-xs leading-relaxed text-amber-800">{{ $item->catatan_admin }}</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ─── Panel Persyaratan Berkas dari Admin ─── --}}
    @if($item->persyaratanBerkas->count() > 0)
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 space-y-4">
        <div>
            <h2 class="font-bold text-slate-900 text-base">📋 Persyaratan Berkas dari Petugas</h2>
            <p class="text-xs text-slate-400 mt-0.5">Upload dokumen persyaratan di bawah ini. Format: PDF, JPG, PNG (maks. 5MB per file).</p>
        </div>

        {{-- Progress Bar --}}
        @php
            $total = $item->persyaratanBerkas->count();
            $uploaded = $item->persyaratanBerkas->whereNotNull('berkas_user_path')->count();
            $pct = $total > 0 ? round($uploaded / $total * 100) : 0;
            $canUpload = in_array($item->status, ['menunggu_berkas', 'rejected']);
        @endphp
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
            <div class="flex justify-between text-xs font-semibold text-slate-600">
                <span>Progress Upload Kelengkapan</span>
                <span class="text-brand-600">{{ $uploaded }} dari {{ $total }} berkas ({{ $pct }}%)</span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                <div class="bg-gradient-to-r from-brand-600 to-emerald-500 h-2.5 rounded-full transition-all duration-500"
                     style="width: {{ $pct }}%"></div>
            </div>
        </div>

        <div class="space-y-3 pt-1">
            @foreach($item->persyaratanBerkas as $berkas)
                <div class="border rounded-2xl p-4 transition {{ $berkas->berkas_user_path ? 'bg-emerald-50/50 border-emerald-200/80' : 'bg-white border-slate-200/70 hover:border-slate-300' }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-slate-900">{{ $berkas->label }}</span>
                                @if($berkas->is_required)
                                    <span class="text-[10px] bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full font-bold">Wajib</span>
                                @else
                                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium">Opsional</span>
                                @endif
                            </div>
                            @if($berkas->keterangan)
                                <p class="text-xs text-slate-400 mt-0.5">{{ $berkas->keterangan }}</p>
                            @endif
                        </div>

                        {{-- Status View --}}
                        @if($berkas->berkas_user_path)
                            <a href="{{ asset('storage/'.$berkas->berkas_user_path) }}" target="_blank"
                               class="shrink-0 text-xs font-semibold bg-emerald-600 text-white px-3.5 py-1.5 rounded-xl hover:bg-emerald-700 shadow-sm transition inline-flex items-center gap-1 self-start sm:self-auto">
                                <span>✅ Lihat File</span>
                            </a>
                        @else
                            <span class="shrink-0 text-xs font-semibold bg-amber-100 text-amber-800 px-3 py-1 rounded-xl self-start sm:self-auto">
                                ⏳ Belum Diupload
                            </span>
                        @endif
                    </div>

                    {{-- Form Upload per Item --}}
                    @if($canUpload)
                        <form method="POST"
                              action="{{ route('user.stnk.upload-berkas-item', [$item, $berkas]) }}"
                              enctype="multipart/form-data"
                              class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                            @csrf
                            <input type="file" name="berkas_item"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   required
                                   class="flex-1 text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 file:mr-2 file:text-xs file:font-semibold file:border-0 file:bg-brand-50 file:text-brand-700 file:px-2.5 file:py-1 file:rounded-lg cursor-pointer">
                            <button type="submit"
                                class="shrink-0 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                                {{ $berkas->berkas_user_path ? 'Ganti File' : 'Upload Sekarang' }}
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        @if($item->status === 'diproses')
            <div class="bg-blue-50 border border-blue-200/80 rounded-2xl px-4 py-3.5 text-xs text-blue-900 font-medium flex items-center gap-2">
                <span class="text-base">🔍</span>
                <span>Seluruh berkas persyaratan telah dikirim. Petugas sedang melakukan verifikasi keabsahan dokumen.</span>
            </div>
        @endif
    </div>
    @endif

    {{-- Dokumen Akhir Resmi dari Petugas (setelah Approved) --}}
    @if($item->status === 'approved')
        <div class="bg-white rounded-3xl border-2 border-emerald-300 shadow-card p-6 sm:p-7 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl shadow-sm">
                    📜
                </div>
                <div>
                    <h2 class="font-extrabold text-slate-900 text-base">Surat Keterangan Resmi Telah Terbit</h2>
                    <p class="text-xs text-slate-400">Pengaduan STNK Anda telah diverifikasi dan disetujui petugas</p>
                </div>
            </div>

            @if($item->dokumen_akhir_path)
                <div class="bg-emerald-50/80 border border-emerald-200/80 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-emerald-950">{{ $item->nama_dokumen_akhir }}</p>
                        <p class="text-xs text-emerald-700 mt-0.5">Dokumen resmi dapat diunduh untuk keperluan pengurusan di Samsat</p>
                    </div>
                    <a href="{{ asset('storage/'.$item->dokumen_akhir_path) }}"
                       target="_blank"
                       download
                       class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-3 rounded-xl shadow-md shadow-emerald-600/20 hover:scale-[1.02] active:scale-95 transition">
                        <span>⬇️ Unduh Dokumen Resmi</span>
                    </a>
                </div>
            @else
                <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-5 text-center text-xs text-slate-400">
                    ⏳ Petugas sedang menerbitkan dokumen akhir. Silakan periksa kembali berkala.
                </div>
            @endif
        </div>
    @elseif($item->status === 'rejected')
        <div class="bg-rose-50 border border-rose-200/80 rounded-3xl p-6 text-rose-900 space-y-1">
            <p class="font-bold text-sm">❌ Pengaduan Ditolak</p>
            @if($item->catatan_admin)
                <p class="text-xs text-rose-700 leading-relaxed">{{ $item->catatan_admin }}</p>
            @endif
            <p class="text-xs text-rose-600 mt-2 font-medium">Silakan lengkapi atau perbaiki berkas sesuai petunjuk petugas di atas.</p>
        </div>
    @endif

</div>
@endsection
