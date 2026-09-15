@extends('layouts.app')
@section('title', 'Dashboard Petugas Admin - Statistik & Rekapitulasi')

@section('content')
    <div class="space-y-6">

        {{-- ── 1. Admin Command Center Header Banner ── --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#23150d] via-[#3a2215] to-[#553522] p-6 sm:p-8 text-white shadow-card border border-[#c89262]/20">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#c89262]/20 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-[#c89262]/30 text-xs text-[#f5d09f] font-semibold mb-3 backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Pusat Statistik, Kendali & Rekapitulasi Laporan</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Dashboard & Rekapitulasi Pengaduan
                    </h1>
                    <p class="text-amber-100/80 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                        Pantau grafik tren kejadian kecelakaan per hari, statistik pengaduan hari ini, serta rekapitulasi
                        harian dan bulanan yang siap dicetak untuk pelaporan.
                    </p>
                </div>

                {{-- Quick Action Buttons: Cetak Laporan Langsung --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('admin.rekap.cetak', ['tipe' => 'harian', 'tanggal' => $filterTanggal]) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition shadow-sm backdrop-blur-md">
                        <svg class="w-4 h-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Cetak Rekap Harian</span>
                    </a>
                    <a href="{{ route('admin.rekap.cetak', ['tipe' => 'bulanan', 'bulan' => $filterBulan, 'tahun' => $filterTahun]) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-[#c89262] to-[#a47148] hover:from-[#d4a373] hover:to-[#b08055] text-white text-xs font-extrabold transition shadow-md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Cetak Rekap Bulanan</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── 2. Snapshot Metrik Pengaduan HARI INI ── --}}
        <div>
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <h2 class="text-xs font-extrabold text-slate-700 tracking-wider uppercase">
                        Ringkasan Hari Ini ({{ now()->translatedFormat('l, d F Y') }})
                    </h2>
                </div>
                <span class="text-[11px] font-semibold text-slate-400">Live Database Update</span>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                {{-- 1. Total Masuk Hari Ini --}}
                <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-card hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-600 tracking-wider uppercase">Total Hari Ini</span>
                        <div
                            class="w-9 h-9 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold text-xs">
                            📊
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-extrabold text-slate-900">{{ $totalHariIni }}</p>
                        <span class="text-[11px] font-bold text-slate-500">laporan</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Gabungan laka & STNK</p>
                </div>

                {{-- 2. Kasus Laka Hari Ini --}}
                <div class="bg-white rounded-3xl p-5 border border-rose-100 shadow-card hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-rose-700 tracking-wider uppercase">Laka Hari Ini</span>
                        <div
                            class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs animate-pulse">
                            🚨
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-extrabold text-rose-600">{{ $kecelakaanHariIni }}</p>
                        <span class="text-[11px] font-bold text-rose-700">kejadian</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Laporan kecelakaan lalu lintas</p>
                </div>

                {{-- 3. STNK Masuk Hari Ini --}}
                <div class="bg-white rounded-3xl p-5 border border-amber-100 shadow-card hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-amber-700 tracking-wider uppercase">STNK Hari Ini</span>
                        <div
                            class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs">
                            📄
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-extrabold text-amber-600">{{ $stnkHariIni }}</p>
                        <span class="text-[11px] font-bold text-amber-700">berkas</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Permohonan surat hilang STNK</p>
                </div>

                {{-- 4. Selesai / Ditangani Hari Ini --}}
                <div class="bg-white rounded-3xl p-5 border border-emerald-100 shadow-card hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-emerald-700 tracking-wider uppercase">Ditangani Hari Ini</span>
                        <div
                            class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                            ✅
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-extrabold text-emerald-600">{{ $selesaiHariIni }}</p>
                        <span class="text-[11px] font-bold text-emerald-700">selesai</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Laporan berhasil dituntaskan</p>
                </div>
            </div>
        </div>

        {{-- ── 3. Seksi Visual Grafik Modern (Charts) ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Grafik 1: Tren Kasus Kecelakaan (Laka) Per Hari (Span 2 Kolom) --}}
            <div
                class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-card p-6 flex flex-col justify-between space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-rose-500"></div>
                            <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">
                                Tren Kasus Kecelakaan (Laka) Per Hari
                            </h3>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Grafik harian dalam 14 hari terakhir</p>
                    </div>

                    {{-- Toggle Filter Dataset --}}
                    <div class="inline-flex p-1 bg-slate-100 rounded-xl text-xs font-bold">
                        <button type="button" id="btn-chart-all" onclick="setChartMode('all')"
                            class="px-2.5 py-1 rounded-lg bg-white shadow-sm text-slate-800 transition">
                            Semua
                        </button>
                        <button type="button" id="btn-chart-laka" onclick="setChartMode('laka')"
                            class="px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-800 transition">
                            🚨 Laka Saja
                        </button>
                        <button type="button" id="btn-chart-stnk" onclick="setChartMode('stnk')"
                            class="px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-800 transition">
                            📄 STNK Saja
                        </button>
                    </div>
                </div>

                {{-- Canvas Grafik Line Chart --}}
                <div class="w-full h-64 sm:h-72 relative">
                    <canvas id="dailyTrendChart"></canvas>
                </div>

                <div
                    class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="font-medium text-slate-700">Kecelakaan (Laka)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="font-medium text-slate-700">Pengaduan STNK</span>
                        </div>
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium">Diperbarui realtime sesuai tanggal masuk</span>
                </div>
            </div>

            {{-- Grafik 2: Komposisi Pengaduan Hari Ini (Donut Chart) --}}
            <div
                class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 flex flex-col justify-between space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-brand-600"></div>
                        <h3 class="font-extrabold text-slate-900 text-sm">
                            Komposisi Pengaduan Hari Ini
                        </h3>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Proporsi laporan yang masuk hari ini</p>
                </div>

                {{-- Donut Chart Canvas --}}
                <div class="w-full h-56 relative flex items-center justify-center">
                    <canvas id="todayCompositionChart"></canvas>
                </div>

                {{-- Legend List --}}
                <div class="space-y-2 pt-2 border-t border-slate-100 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600 font-medium">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            Kasus Kecelakaan
                        </span>
                        <strong class="font-extrabold text-slate-900">{{ $kecelakaanHariIni }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600 font-medium">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            Kehilangan STNK
                        </span>
                        <strong class="font-extrabold text-slate-900">{{ $stnkHariIni }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600 font-medium">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            Ditangani Hari Ini
                        </span>
                        <strong class="font-extrabold text-emerald-600">{{ $selesaiHariIni }}</strong>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── 4. Grafik Tren Bulanan Tahun Berjalan (Bar Chart) ── --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-600"></div>
                        <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">
                            Grafik Pengaduan Bulanan Tahun {{ $filterTahun }}
                        </h3>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Perbandingan jumlah kasus kecelakaan dan STNK per bulan
                        (Januari - Desember)</p>
                </div>

                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <input type="hidden" name="tanggal" value="{{ $filterTanggal }}">
                    <input type="hidden" name="bulan" value="{{ $filterBulan }}">
                    <select name="tahun" onchange="this.form.submit()"
                        class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 bg-slate-50 focus:ring-2 focus:ring-brand-500">
                        @for($y = date('Y'); $y >= date('Y') - 4; $y--)
                            <option value="{{ $y }}" {{ $filterTahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            <div class="w-full h-64 sm:h-72 relative">
                <canvas id="monthlyBarChart"></canvas>
            </div>
        </div>

        {{-- ── 5. SEKSI REKAPITULASI UNTUK REPORT (HARIAN & BULANAN) ── --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">

            {{-- Section Header & Tab Navigation --}}
            <div
                class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-base">📑</span>
                        <h2 class="font-extrabold text-slate-900 text-base">Rekapitulasi & Laporan Pengaduan</h2>
                    </div>
                    <p class="text-slate-500 text-xs mt-0.5">
                        Data rekapitulasi terstruktur yang dapat difilter tanggal/bulan dan dicetak langsung dalam format
                        dokumen resmi.
                    </p>
                </div>

                {{-- Tab Buttons --}}
                <div class="inline-flex p-1 bg-slate-200/80 rounded-2xl text-xs font-bold">
                    <button type="button" id="tab-btn-harian" onclick="switchReportTab('harian')"
                        class="px-4 py-2 rounded-xl bg-white text-slate-900 shadow-sm transition">
                        📅 Rekap Harian
                    </button>
                    <button type="button" id="tab-btn-bulanan" onclick="switchReportTab('bulanan')"
                        class="px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition">
                        📆 Rekap Bulanan
                    </button>
                </div>
            </div>

            {{-- ── TAB 1: REKAPITULASI HARIAN ── --}}
            <div id="tab-content-harian" class="p-6 space-y-6">

                {{-- Filter Tanggal & Action Bar --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-3">
                        <input type="hidden" name="tahun" value="{{ $filterTahun }}">
                        <input type="hidden" name="bulan" value="{{ $filterBulan }}">
                        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <span>Pilih Tanggal:</span>
                            <input type="date" name="tanggal" value="{{ $filterTanggal }}" onchange="this.form.submit()"
                                class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-800 bg-white shadow-sm focus:ring-2 focus:ring-brand-500">
                        </label>
                        <span class="text-xs text-slate-400">|</span>
                        <span class="text-xs font-bold text-slate-600">
                            {{ $dailyStats['tanggal'] }}
                        </span>
                    </form>

                    <a href="{{ route('admin.rekap.cetak', ['tipe' => 'harian', 'tanggal' => $filterTanggal]) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-sm self-start sm:self-auto">
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Cetak Dokumen Rekap Harian Ini</span>
                    </a>
                </div>

                {{-- 4 Mini Stat Cards for Selected Date --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-4 rounded-2xl border border-slate-200 bg-white">
                        <p class="text-[11px] font-bold text-slate-500 uppercase">Total Pengaduan</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $dailyStats['total'] }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Laporan masuk pada tanggal ini</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-rose-100 bg-rose-50/40">
                        <p class="text-[11px] font-bold text-rose-600 uppercase">Kasus Laka</p>
                        <p class="text-2xl font-extrabold text-rose-600 mt-1">{{ $dailyStats['count_laka'] }}</p>
                        <p class="text-[11px] text-rose-400 mt-0.5">Kejadian kecelakaan</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-amber-100 bg-amber-50/40">
                        <p class="text-[11px] font-bold text-amber-600 uppercase">Pengaduan STNK</p>
                        <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $dailyStats['count_stnk'] }}</p>
                        <p class="text-[11px] text-amber-500 mt-0.5">Permohonan surat hilang</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-emerald-100 bg-emerald-50/40">
                        <p class="text-[11px] font-bold text-emerald-600 uppercase">Tuntas / Selesai</p>
                        <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $dailyStats['selesai'] }}</p>
                        <p class="text-[11px] text-emerald-500 mt-0.5">Status approved / selesai</p>
                    </div>
                </div>

                {{-- Tabel Rincian Pengaduan yang Masuk Pada Tanggal Ini --}}
                <div class="space-y-3">
                    <h4
                        class="text-xs font-extrabold uppercase tracking-wider text-slate-700 flex items-center justify-between">
                        <span>Rincian Laporan Tanggal: {{ $dailyStats['tanggal'] }}</span>
                        <span class="text-slate-400 font-semibold lowercase">({{ $pengaduanHariTerpilih->count() }}
                            data)</span>
                    </h4>

                    <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-100 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                                    <th class="py-3 px-4 w-12 text-center">No</th>
                                    <th class="py-3 px-4 w-20">Jam</th>
                                    <th class="py-3 px-4 w-28">Tipe</th>
                                    <th class="py-3 px-4">Judul / Kendaraan</th>
                                    <th class="py-3 px-4">Pelapor / Pemohon</th>
                                    <th class="py-3 px-4">Keterangan / Lokasi</th>
                                    <th class="py-3 px-4 w-28 text-center">Status</th>
                                    <th class="py-3 px-4 w-20 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($pengaduanHariTerpilih as $idx => $p)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-2.5 px-4 text-center font-medium text-slate-400">{{ $loop->iteration }}
                                        </td>
                                        <td class="py-2.5 px-4 font-mono text-slate-600 text-[11px]">{{ $p['waktu'] }}</td>
                                        <td class="py-2.5 px-4">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase {{ $p['type'] === 'kecelakaan' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $p['type'] === 'kecelakaan' ? '🚨 Laka' : '📄 STNK' }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-4 font-semibold text-slate-900">
                                            {{ $p['judul'] }}
                                        </td>
                                        <td class="py-2.5 px-4 text-slate-700 font-medium">
                                            {{ $p['pelapor'] }}
                                        </td>
                                        <td class="py-2.5 px-4 text-slate-500 truncate max-w-xs text-[11px]">
                                            {{ $p['detail'] }}
                                        </td>
                                        <td class="py-2.5 px-4 text-center">
                                            <span
                                                class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ in_array($p['status_raw'], ['selesai', 'approved']) ? 'bg-emerald-100 text-emerald-800' : (in_array($p['status_raw'], ['baru', 'diajukan']) ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700') }}">
                                                {{ $p['status'] }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-4 text-center">
                                            <a href="{{ $p['url'] }}"
                                                class="inline-block px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-[11px] font-bold transition">
                                                Buka &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8 text-center text-slate-400 italic">
                                            Tidak ada laporan pengaduan pada tanggal {{ $dailyStats['tanggal'] }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── TAB 2: REKAPITULASI BULANAN ── --}}
            <div id="tab-content-bulanan" class="hidden p-6 space-y-6">

                {{-- Filter Bulan & Tahun --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-3">
                        <input type="hidden" name="tanggal" value="{{ $filterTanggal }}">
                        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <span>Bulan:</span>
                            <select name="bulan" onchange="this.form.submit()"
                                class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-800 bg-white shadow-sm focus:ring-2 focus:ring-brand-500">
                                @for($m = 1; $m <= 12; $m++)
                                    @php $mName = \Carbon\Carbon::createFromDate($filterTahun, $m, 1)->translatedFormat('F'); @endphp
                                    <option value="{{ $m }}" {{ $filterBulan == $m ? 'selected' : '' }}>{{ $mName }}</option>
                                @endfor
                            </select>
                        </label>

                        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <span>Tahun:</span>
                            <select name="tahun" onchange="this.form.submit()"
                                class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-800 bg-white shadow-sm focus:ring-2 focus:ring-brand-500">
                                @for($y = date('Y'); $y >= date('Y') - 4; $y--)
                                    <option value="{{ $y }}" {{ $filterTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </label>
                    </form>

                    <a href="{{ route('admin.rekap.cetak', ['tipe' => 'bulanan', 'bulan' => $filterBulan, 'tahun' => $filterTahun]) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-sm self-start sm:self-auto">
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Cetak Dokumen Rekap Bulan Ini</span>
                    </a>
                </div>

                {{-- 4 Mini Stat Cards for Selected Month --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-4 rounded-2xl border border-slate-200 bg-white">
                        <p class="text-[11px] font-bold text-slate-500 uppercase">Total Bulan
                            {{ $selectedMonthData['month_name'] }}</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $selectedMonthData['total'] }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Semua pengaduan masuk</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-rose-100 bg-rose-50/40">
                        <p class="text-[11px] font-bold text-rose-600 uppercase">Kasus Laka</p>
                        <p class="text-2xl font-extrabold text-rose-600 mt-1">{{ $selectedMonthData['count_laka'] }}</p>
                        <p class="text-[11px] text-rose-400 mt-0.5">Kejadian kecelakaan</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-amber-100 bg-amber-50/40">
                        <p class="text-[11px] font-bold text-amber-600 uppercase">Pengaduan STNK</p>
                        <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $selectedMonthData['count_stnk'] }}</p>
                        <p class="text-[11px] text-amber-500 mt-0.5">Surat hilang STNK</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-emerald-100 bg-emerald-50/40">
                        <p class="text-[11px] font-bold text-emerald-600 uppercase">Penyelesaian (%)</p>
                        <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $selectedMonthData['persentase'] }}%</p>
                        <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">{{ $selectedMonthData['selesai'] }}
                            dari {{ $selectedMonthData['total'] }} selesai</p>
                    </div>
                </div>

                {{-- Tabel Rekapitulasi 12 Bulan dalam Setahun --}}
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Tabel Rekapitulasi Tahunan (Tahun {{ $filterTahun }})
                    </h4>

                    <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-100 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                                    <th class="py-3 px-4 w-12 text-center">No</th>
                                    <th class="py-3 px-4">Bulan</th>
                                    <th class="py-3 px-4 text-center">Kasus Laka</th>
                                    <th class="py-3 px-4 text-center">Pengaduan STNK</th>
                                    <th class="py-3 px-4 text-center">Total Masuk</th>
                                    <th class="py-3 px-4 text-center">Ditangani/Selesai</th>
                                    <th class="py-3 px-4 text-center">% Efektivitas</th>
                                    <th class="py-3 px-4 text-center w-28">Cetak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($monthlyRecap as $mr)
                                    <tr
                                        class="hover:bg-slate-50/80 transition {{ $mr['month_num'] == $filterBulan ? 'bg-amber-50/30' : '' }}">
                                        <td class="py-2.5 px-4 text-center font-medium text-slate-400">{{ $mr['month_num'] }}
                                        </td>
                                        <td class="py-2.5 px-4 font-bold text-slate-900">
                                            {{ $mr['month_name'] }}
                                            @if($mr['month_num'] == date('n') && $filterTahun == date('Y'))
                                                <span
                                                    class="ml-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-blue-100 text-blue-800 uppercase">Bulan
                                                    Ini</span>
                                            @endif
                                        </td>
                                        <td class="py-2.5 px-4 text-center font-extrabold text-rose-600">{{ $mr['count_laka'] }}
                                        </td>
                                        <td class="py-2.5 px-4 text-center font-extrabold text-amber-600">
                                            {{ $mr['count_stnk'] }}</td>
                                        <td class="py-2.5 px-4 text-center font-extrabold text-slate-900">{{ $mr['total'] }}
                                        </td>
                                        <td class="py-2.5 px-4 text-center font-extrabold text-emerald-600">{{ $mr['selesai'] }}
                                        </td>
                                        <td class="py-2.5 px-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <div class="w-12 bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                                    <div class="bg-emerald-500 h-1.5 rounded-full"
                                                        style="width: {{ $mr['persentase'] }}%"></div>
                                                </div>
                                                <span
                                                    class="font-bold text-[11px] text-slate-700">{{ $mr['persentase'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="py-2.5 px-4 text-center">
                                            <a href="{{ route('admin.rekap.cetak', ['tipe' => 'bulanan', 'bulan' => $mr['month_num'], 'tahun' => $filterTahun]) }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg border border-slate-200 hover:bg-slate-100 text-[11px] font-semibold text-slate-700 transition">
                                                <span>🖨️ Cetak</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        {{-- ── 6. Dua Kolom Feed Pengaduan Terbaru untuk Petugas ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Panel STNK Masuk --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                        <h2 class="font-bold text-slate-800 text-sm">Pengaduan STNK Terbaru</h2>
                    </div>
                    <a href="{{ route('admin.stnk.index') }}"
                        class="text-xs font-semibold text-brand-600 hover:text-brand-700">
                        Buka Semua &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse($stnkTerbaru as $item)
                        <a href="{{ route('admin.stnk.show', $item) }}"
                            class="group p-3.5 rounded-2xl border border-slate-100 hover:border-brand-200 hover:bg-slate-50/80 transition duration-150 flex items-center justify-between gap-3">
                            <div class="min-w-0 space-y-1">
                                <div class="flex items-center gap-2">
                                    @if($item->plat_nomor)
                                        <span class="px-2 py-0.5 bg-slate-900 text-white rounded text-[11px] font-mono font-bold">
                                            {{ $item->plat_nomor }}
                                        </span>
                                    @endif
                                    <p
                                        class="font-semibold text-xs sm:text-sm text-slate-900 group-hover:text-brand-600 transition truncate">
                                        {{ $item->merk_tipe ?: $item->jenis_kendaraan }}
                                    </p>
                                </div>
                                <p class="text-[11px] text-slate-400 truncate">
                                    Pemohon: <span
                                        class="font-medium text-slate-700">{{ $item->nama_pemilik ?: $item->nama_pemohon }}</span>
                                    · {{ $item->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full text-[11px] font-semibold shrink-0 {{ $item->statusColor() }}">
                                {{ $item->statusLabel() }}
                            </span>
                        </a>
                    @empty
                        <p class="py-8 text-center text-xs text-slate-400">Belum ada pengaduan STNK masuk.</p>
                    @endforelse
                </div>
            </div>

            {{-- Panel Laporan Kecelakaan Masuk --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                        <h2 class="font-bold text-slate-800 text-sm">Laporan Kecelakaan Terbaru</h2>
                    </div>
                    <a href="{{ route('admin.kecelakaan.index') }}"
                        class="text-xs font-semibold text-rose-600 hover:text-rose-700">
                        Buka Semua &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse($kecelakaanTerbaru as $item)
                        <a href="{{ route('admin.kecelakaan.show', $item) }}"
                            class="group p-3.5 rounded-2xl border border-slate-100 hover:border-rose-200 hover:bg-slate-50/80 transition duration-150 flex items-center justify-between gap-3">
                            <div class="min-w-0 space-y-1">
                                <p
                                    class="font-semibold text-xs sm:text-sm text-slate-900 group-hover:text-rose-600 transition truncate">
                                    {{ $item->judul }}
                                </p>
                                <p class="text-[11px] text-slate-400 truncate">
                                    Pelapor: <span class="font-medium text-slate-700">{{ $item->user->name }}</span>
                                    · {{ $item->created_at->diffForHumans() }}
                                    @if($item->nama_lokasi)
                                        · 📍 {{ Str::limit($item->nama_lokasi, 30) }}
                                    @endif
                                </p>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full text-[11px] font-semibold shrink-0 {{ $item->statusColor() }}">
                                {{ $item->statusLabel() }}
                            </span>
                        </a>
                    @empty
                        <p class="py-8 text-center text-xs text-slate-400">Belum ada laporan kecelakaan masuk.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    {{-- ── 7. Chart.js & Inisialisasi Script Grafik ── --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#64748b';

            // ── Data Grafik dari Backend ──
            const daysLabels = @json($chartDaysLabels);
            const lakaPerHari = @json($chartLakaPerHari);
            const stnkPerHari = @json($chartStnkPerHari);
            const totalPerHari = @json($chartTotalPerHari);

            // ── 1. Inisialisasi Line Chart Tren Harian (Laka & STNK) ──
            const ctxDaily = document.getElementById('dailyTrendChart').getContext('2d');

            // Gradient fills
            const gradLaka = ctxDaily.createLinearGradient(0, 0, 0, 300);
            gradLaka.addColorStop(0, 'rgba(244, 63, 94, 0.35)');
            gradLaka.addColorStop(1, 'rgba(244, 63, 94, 0.00)');

            const gradStnk = ctxDaily.createLinearGradient(0, 0, 0, 300);
            gradStnk.addColorStop(0, 'rgba(245, 158, 11, 0.25)');
            gradStnk.addColorStop(1, 'rgba(245, 158, 11, 0.00)');

            const datasetLaka = {
                label: 'Kasus Kecelakaan (Laka)',
                data: lakaPerHari,
                borderColor: '#e11d48',
                backgroundColor: gradLaka,
                borderWidth: 2.5,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#e11d48',
                pointRadius: 4,
                pointHoverRadius: 6,
            };

            const datasetStnk = {
                label: 'Pengaduan STNK',
                data: stnkPerHari,
                borderColor: '#d97706',
                backgroundColor: gradStnk,
                borderWidth: 2,
                borderDash: [4, 4],
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#d97706',
                pointRadius: 3,
                pointHoverRadius: 5,
            };

            window.dailyChart = new Chart(ctxDaily, {
                type: 'line',
                data: {
                    labels: daysLabels,
                    datasets: [datasetLaka, datasetStnk]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 12,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Mode Switcher untuk Line Chart
            window.setChartMode = function (mode) {
                const btnAll = document.getElementById('btn-chart-all');
                const btnLaka = document.getElementById('btn-chart-laka');
                const btnStnk = document.getElementById('btn-chart-stnk');

                [btnAll, btnLaka, btnStnk].forEach(b => {
                    b.className = 'px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-800 transition';
                });

                if (mode === 'laka') {
                    btnLaka.className = 'px-2.5 py-1 rounded-lg bg-white shadow-sm text-rose-600 font-extrabold transition';
                    window.dailyChart.data.datasets = [datasetLaka];
                } else if (mode === 'stnk') {
                    btnStnk.className = 'px-2.5 py-1 rounded-lg bg-white shadow-sm text-amber-600 font-extrabold transition';
                    window.dailyChart.data.datasets = [datasetStnk];
                } else {
                    btnAll.className = 'px-2.5 py-1 rounded-lg bg-white shadow-sm text-slate-800 font-extrabold transition';
                    window.dailyChart.data.datasets = [datasetLaka, datasetStnk];
                }
                window.dailyChart.update();
            };

            // ── 2. Inisialisasi Donut Chart Komposisi Hari Ini ──
            const ctxComp = document.getElementById('todayCompositionChart').getContext('2d');
            const lakaToday = {{ $kecelakaanHariIni }};
            const stnkToday = {{ $stnkHariIni }};
            const hasDataToday = (lakaToday + stnkToday) > 0;

            new Chart(ctxComp, {
                type: 'doughnut',
                data: {
                    labels: hasDataToday ? ['Kasus Kecelakaan', 'Pengaduan STNK'] : ['Belum Ada Laporan'],
                    datasets: [{
                        data: hasDataToday ? [lakaToday, stnkToday] : [1],
                        backgroundColor: hasDataToday ? ['#f43f5e', '#f59e0b'] : ['#e2e8f0'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: hasDataToday,
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 10
                        }
                    }
                }
            });

            // ── 3. Inisialisasi Bar Chart Bulanan ──
            const ctxMonthly = document.getElementById('monthlyBarChart').getContext('2d');
            const monthLabels = @json($chartMonthLabels);
            const monthLaka = @json($chartMonthLaka);
            const monthStnk = @json($chartMonthStnk);

            new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        {
                            label: 'Kasus Kecelakaan (Laka)',
                            data: monthLaka,
                            backgroundColor: '#f43f5e',
                            borderRadius: 6,
                            barPercentage: 0.7,
                        },
                        {
                            label: 'Pengaduan STNK',
                            data: monthStnk,
                            backgroundColor: '#f59e0b',
                            borderRadius: 6,
                            barPercentage: 0.7,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 12,
                                font: { size: 11, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 12,
                            cornerRadius: 12
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });

        // ── Tab Switcher Rekapitulasi (Harian / Bulanan) ──
        function switchReportTab(tab) {
            const btnHarian = document.getElementById('tab-btn-harian');
            const btnBulanan = document.getElementById('tab-btn-bulanan');
            const contentHarian = document.getElementById('tab-content-harian');
            const contentBulanan = document.getElementById('tab-content-bulanan');

            if (tab === 'bulanan') {
                btnBulanan.className = 'px-4 py-2 rounded-xl bg-white text-slate-900 shadow-sm transition';
                btnHarian.className = 'px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition';
                contentBulanan.classList.remove('hidden');
                contentHarian.classList.add('hidden');
            } else {
                btnHarian.className = 'px-4 py-2 rounded-xl bg-white text-slate-900 shadow-sm transition';
                btnBulanan.className = 'px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition';
                contentHarian.classList.remove('hidden');
                contentBulanan.classList.add('hidden');
            }
        }
    </script>
@endsection