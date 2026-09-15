<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi {{ ucfirst($tipe) }} - {{ $periode }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }
            .page-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 py-8 px-4 sm:px-6">

    {{-- Top Action Bar (No Print) --}}
    <div class="no-print max-w-4xl mx-auto mb-6 flex flex-wrap items-center justify-between gap-3 bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                &larr; Kembali ke Dashboard
            </a>
            <span class="text-xs text-slate-400">|</span>
            <span class="text-xs font-semibold text-slate-600">Dokumen Rekapitulasi Resmi (Siap Cetak / PDF)</span>
        </div>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition shadow-md">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <span>Cetak / Unduh PDF</span>
        </button>
    </div>

    {{-- Printable Paper Container --}}
    <div class="page-container max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-200/80">
        
        {{-- Kop Surat Resmi Kepolisian --}}
        <div class="border-b-4 border-double border-slate-900 pb-4 mb-6">
            <div class="text-center space-y-0.5">
                <h3 class="text-xs font-bold tracking-widest uppercase text-slate-700">KEPOLISIAN NEGARA REPUBLIK INDONESIA</h3>
                <h4 class="text-xs font-bold tracking-wider uppercase text-slate-700">DAERAH JAWA BARAT - RESOR KOTA</h4>
                <h2 class="text-base font-extrabold tracking-wide uppercase text-slate-900">SENTRA PELAYANAN KEPOLISIAN TERPADU (SPKT)</h2>
                <p class="text-[10px] text-slate-500">Jl. Raya Pelayanan Publik No. 01, Telp: (0251) 8320000 / Layanan Bebas Pulsa 110</p>
            </div>
        </div>

        {{-- Judul Laporan & Nomor Dokumen --}}
        <div class="text-center my-6 space-y-1">
            <h1 class="text-lg sm:text-xl font-extrabold tracking-tight uppercase text-slate-900">
                LAPORAN REKAPITULASI PENGADUAN MASYARAKAT ({{ strtoupper($tipe) }})
            </h1>
            <p class="text-xs font-semibold text-slate-600">
                Periode: <span class="underline decoration-slate-400 font-bold">{{ $periode }}</span>
            </p>
            <p class="text-[10px] text-slate-400 font-mono">
                No. Dok: REKAP/{{ strtoupper($tipe) }}/{{ date('Ymd') }}/SPKT-01
            </p>
        </div>

        {{-- Ringkasan Angka Rekapitulasi --}}
        <div class="mb-8">
            <h5 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-1.5">
                <span>I. RINGKASAN STATISTIK PENGADUAN</span>
            </h5>
            <div class="grid grid-cols-4 gap-3 border border-slate-200 rounded-2xl p-4 bg-slate-50/60 text-center">
                <div class="border-r border-slate-200 pr-2">
                    <span class="text-[10px] font-bold text-slate-500 uppercase block">Total Pengaduan</span>
                    <span class="text-2xl font-extrabold text-slate-900">{{ $total }}</span>
                    <span class="text-[9px] text-slate-400 block mt-0.5">Laporan Masuk</span>
                </div>
                <div class="border-r border-slate-200 pr-2">
                    <span class="text-[10px] font-bold text-rose-600 uppercase block">Kasus Laka</span>
                    <span class="text-2xl font-extrabold text-rose-600">{{ $count_laka }}</span>
                    <span class="text-[9px] text-slate-400 block mt-0.5">Kecelakaan</span>
                </div>
                <div class="border-r border-slate-200 pr-2">
                    <span class="text-[10px] font-bold text-amber-600 uppercase block">Pengaduan STNK</span>
                    <span class="text-2xl font-extrabold text-amber-600">{{ $count_stnk }}</span>
                    <span class="text-[9px] text-slate-400 block mt-0.5">Surat Hilang</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase block">Ditangani / Selesai</span>
                    <span class="text-2xl font-extrabold text-emerald-600">{{ $selesai }}</span>
                    <span class="text-[9px] text-emerald-700 font-semibold block mt-0.5">({{ $persentase }}% Selesai)</span>
                </div>
            </div>
        </div>

        {{-- Bagian II: Rincian Kasus Kecelakaan Lalu Lintas --}}
        <div class="mb-8">
            <h5 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-3">
                II. RINCIAN PENGADUAN KEJADIAN KECELAKAAN LALU LINTAS ({{ $count_laka }} KASUS)
            </h5>
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-200 text-[11px] font-bold text-slate-700 uppercase">
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3 w-28">Waktu Kejadian</th>
                            <th class="py-2.5 px-3">Judul / Peristiwa Kejadian</th>
                            <th class="py-2.5 px-3">Pelapor</th>
                            <th class="py-2.5 px-3">Lokasi / Titik GPS</th>
                            <th class="py-2.5 px-3 w-24 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($lakaList as $idx => $laka)
                            <tr class="{{ $loop->even ? 'bg-slate-50/50' : '' }}">
                                <td class="py-2 px-3 text-center font-medium text-slate-500">{{ $idx + 1 }}</td>
                                <td class="py-2 px-3 text-[11px] text-slate-600">{{ $laka->created_at->translatedFormat('d/m/Y H:i') }}</td>
                                <td class="py-2 px-3 font-semibold text-slate-900">{{ $laka->judul }}</td>
                                <td class="py-2 px-3 text-slate-700">{{ $laka->user->name ?? 'Warga' }}</td>
                                <td class="py-2 px-3 text-[11px] text-slate-600">
                                    {{ $laka->nama_lokasi ?: ($laka->latitude ? $laka->latitude.', '.$laka->longitude : '-') }}
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $laka->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : ($laka->status === 'diproses' ? 'bg-blue-100 text-blue-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ $laka->statusLabel() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-slate-400 text-xs italic">
                                    Tidak ada laporan kecelakaan pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bagian III: Rincian Pengaduan Kehilangan STNK --}}
        <div class="mb-10">
            <h5 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-3">
                III. RINCIAN PERMOHONAN KEHILANGAN STNK ({{ $count_stnk }} PERMOHONAN)
            </h5>
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-200 text-[11px] font-bold text-slate-700 uppercase">
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3 w-28">Waktu Masuk</th>
                            <th class="py-2.5 px-3">Nomor Polisi</th>
                            <th class="py-2.5 px-3">Kendaraan</th>
                            <th class="py-2.5 px-3">Nama Pemilik</th>
                            <th class="py-2.5 px-3">No. HP</th>
                            <th class="py-2.5 px-3 w-28 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($stnkList as $idx => $stnk)
                            <tr class="{{ $loop->even ? 'bg-slate-50/50' : '' }}">
                                <td class="py-2 px-3 text-center font-medium text-slate-500">{{ $idx + 1 }}</td>
                                <td class="py-2 px-3 text-[11px] text-slate-600">{{ $stnk->created_at->translatedFormat('d/m/Y H:i') }}</td>
                                <td class="py-2 px-3 font-mono font-bold text-slate-900">{{ $stnk->plat_nomor ?: '-' }}</td>
                                <td class="py-2 px-3 text-slate-800">{{ $stnk->merk_tipe ?: ($stnk->jenis_kendaraan ?: '-') }}</td>
                                <td class="py-2 px-3 font-medium text-slate-700">{{ $stnk->nama_pemilik ?: ($stnk->nama_pemohon ?: ($stnk->user->name ?? '-')) }}</td>
                                <td class="py-2 px-3 text-[11px] text-slate-600">{{ $stnk->no_hp ?: '-' }}</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ in_array($stnk->status, ['approved', 'selesai']) ? 'bg-emerald-100 text-emerald-800' : ($stnk->status === 'diajukan' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $stnk->statusLabel() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-slate-400 text-xs italic">
                                    Tidak ada permohonan STNK pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Lembar Pengesahan Tanda Tangan --}}
        <div class="pt-6 border-t border-slate-200 mt-8">
            <div class="flex justify-between items-start text-xs text-slate-700 px-6">
                <div class="text-center space-y-1">
                    <p>Mengetahui,</p>
                    <p class="font-bold uppercase text-slate-900">KEPALA SPKT POLSEK</p>
                    <div class="h-20"></div>
                    <p class="font-bold underline text-slate-900">( .................................................... )</p>
                    <p class="text-[10px] text-slate-500">AIPTU NRP. ...........................</p>
                </div>

                <div class="text-center space-y-1">
                    <p>Dibuat di: Bogor, {{ $tanggal_doc }}</p>
                    <p class="font-bold uppercase text-slate-900">PETUGAS OPERATOR PIKET</p>
                    <div class="h-20 flex items-center justify-center">
                        <span class="text-[10px] text-slate-400 italic">Tercetak secara elektronik</span>
                    </div>
                    <p class="font-bold underline text-slate-900">( {{ strtoupper(auth()->user()->name) }} )</p>
                    <p class="text-[10px] text-slate-500">ID Petugas: #{{ auth()->user()->id }} · SPKT Online</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
