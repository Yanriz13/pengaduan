<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaduanKecelakaan;
use App\Models\PengaduanStnk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Metrik Keseluruhan (Active & Queue)
        $stnkBaru = PengaduanStnk::where('status', 'diajukan')->count();
        $stnkProses = PengaduanStnk::whereIn('status', ['menunggu_berkas', 'diproses'])->count();
        $stnkSelesaiTotal = PengaduanStnk::whereIn('status', ['approved', 'selesai'])->count();
        $kecelakaanBaru = PengaduanKecelakaan::where('status', 'baru')->count();
        $kecelakaanProses = PengaduanKecelakaan::where('status', 'diproses')->count();
        $kecelakaanSelesaiTotal = PengaduanKecelakaan::where('status', 'selesai')->count();

        // 2. Metrik Pengaduan Hari Ini
        $today = Carbon::today();
        $stnkHariIni = PengaduanStnk::whereDate('created_at', $today)->count();
        $kecelakaanHariIni = PengaduanKecelakaan::whereDate('created_at', $today)->count();
        $totalHariIni = $stnkHariIni + $kecelakaanHariIni;

        $stnkSelesaiHariIni = PengaduanStnk::whereDate('updated_at', $today)->whereIn('status', ['approved', 'selesai'])->count();
        $kecelakaanSelesaiHariIni = PengaduanKecelakaan::whereDate('updated_at', $today)->where('status', 'selesai')->count();
        $selesaiHariIni = $stnkSelesaiHariIni + $kecelakaanSelesaiHariIni;

        // 3. Tren Harian (14 Hari Terakhir) - Khusus Grafik Laka Per Hari & Komparasi STNK
        $startDate14 = Carbon::today()->subDays(13)->startOfDay();
        $endDate14 = Carbon::today()->endOfDay();

        $laka14 = PengaduanKecelakaan::whereBetween('created_at', [$startDate14, $endDate14])->get();
        $stnk14 = PengaduanStnk::whereBetween('created_at', [$startDate14, $endDate14])->get();

        $chartDaysLabels = [];
        $chartLakaPerHari = [];
        $chartStnkPerHari = [];
        $chartTotalPerHari = [];

        for ($i = 13; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i);
            $dKey = $d->format('Y-m-d');
            $dLabel = $d->translatedFormat('d M');

            $countL = $laka14->filter(fn($item) => $item->created_at->format('Y-m-d') === $dKey)->count();
            $countS = $stnk14->filter(fn($item) => $item->created_at->format('Y-m-d') === $dKey)->count();

            $chartDaysLabels[] = $dLabel;
            $chartLakaPerHari[] = $countL;
            $chartStnkPerHari[] = $countS;
            $chartTotalPerHari[] = $countL + $countS;
        }

        // 4. Komposisi Hari Ini (untuk Pie / Donut Chart)
        $lakaHariIniBaru = PengaduanKecelakaan::whereDate('created_at', $today)->where('status', 'baru')->count();
        $lakaHariIniProses = PengaduanKecelakaan::whereDate('created_at', $today)->where('status', 'diproses')->count();
        $lakaHariIniSelesai = PengaduanKecelakaan::whereDate('created_at', $today)->where('status', 'selesai')->count();

        $stnkHariIniBaru = PengaduanStnk::whereDate('created_at', $today)->where('status', 'diajukan')->count();
        $stnkHariIniProses = PengaduanStnk::whereDate('created_at', $today)->whereIn('status', ['menunggu_berkas', 'diproses'])->count();
        $stnkHariIniSelesai = PengaduanStnk::whereDate('created_at', $today)->whereIn('status', ['approved', 'selesai'])->count();

        // 5. Rekapitulasi Harian (Bisa Difilter Berdasarkan Tanggal)
        $filterTanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $dateCarbon = Carbon::parse($filterTanggal);

        $lakaOnDate = PengaduanKecelakaan::with('user')->whereDate('created_at', $filterTanggal)->latest()->get();
        $stnkOnDate = PengaduanStnk::with('user')->whereDate('created_at', $filterTanggal)->latest()->get();

        // Gabungkan data pengaduan pada hari tersebut untuk tabel rincian
        $pengaduanHariTerpilih = collect();
        foreach ($lakaOnDate as $laka) {
            $pengaduanHariTerpilih->push([
                'id'         => $laka->id,
                'type'       => 'kecelakaan',
                'badge'      => 'Kecelakaan',
                'judul'      => $laka->judul,
                'detail'     => $laka->nama_lokasi ?: 'Titik GPS terlampir',
                'pelapor'    => $laka->user->name ?? 'Warga',
                'waktu'      => $laka->created_at->format('H:i'),
                'created_at' => $laka->created_at,
                'status'     => $laka->statusLabel(),
                'status_raw' => $laka->status,
                'url'        => route('admin.kecelakaan.show', $laka),
            ]);
        }
        foreach ($stnkOnDate as $stnk) {
            $pengaduanHariTerpilih->push([
                'id'         => $stnk->id,
                'type'       => 'stnk',
                'badge'      => 'STNK',
                'judul'      => ($stnk->plat_nomor ? '['.$stnk->plat_nomor.'] ' : '') . ($stnk->merk_tipe ?: ($stnk->jenis_kendaraan ?: 'Pengaduan STNK')),
                'detail'     => 'Pemilik: ' . ($stnk->nama_pemilik ?: ($stnk->nama_pemohon ?: ($stnk->user->name ?? '-'))),
                'pelapor'    => $stnk->user->name ?? 'Warga',
                'waktu'      => $stnk->created_at->format('H:i'),
                'created_at' => $stnk->created_at,
                'status'     => $stnk->statusLabel(),
                'status_raw' => $stnk->status,
                'url'        => route('admin.stnk.show', $stnk),
            ]);
        }
        $pengaduanHariTerpilih = $pengaduanHariTerpilih->sortByDesc('created_at');

        $dailyStats = [
            'tanggal'          => $dateCarbon->translatedFormat('l, d F Y'),
            'tanggal_raw'      => $filterTanggal,
            'total'            => $lakaOnDate->count() + $stnkOnDate->count(),
            'count_laka'       => $lakaOnDate->count(),
            'count_stnk'       => $stnkOnDate->count(),
            'selesai'          => $lakaOnDate->where('status', 'selesai')->count() + $stnkOnDate->whereIn('status', ['approved', 'selesai'])->count(),
            'laka_baru'        => $lakaOnDate->where('status', 'baru')->count(),
            'laka_proses'      => $lakaOnDate->where('status', 'diproses')->count(),
            'laka_selesai'     => $lakaOnDate->where('status', 'selesai')->count(),
            'stnk_baru'        => $stnkOnDate->where('status', 'diajukan')->count(),
            'stnk_proses'      => $stnkOnDate->whereIn('status', ['menunggu_berkas', 'diproses'])->count(),
            'stnk_selesai'     => $stnkOnDate->whereIn('status', ['approved', 'selesai'])->count(),
        ];

        // 6. Rekapitulasi Bulanan (12 Bulan dalam Tahun Berjalan / Difilter)
        $filterTahun = (int) $request->get('tahun', Carbon::now()->year);
        $filterBulan = (int) $request->get('bulan', Carbon::now()->month);

        $lakaYear = PengaduanKecelakaan::whereYear('created_at', $filterTahun)->get();
        $stnkYear = PengaduanStnk::whereYear('created_at', $filterTahun)->get();

        $monthlyRecap = [];
        $chartMonthLabels = [];
        $chartMonthLaka = [];
        $chartMonthStnk = [];
        $chartMonthTotal = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthDate = Carbon::createFromDate($filterTahun, $m, 1);
            $monthName = $monthDate->translatedFormat('F');
            $monthShort = $monthDate->translatedFormat('M');

            $lakaM = $lakaYear->filter(fn($i) => (int)$i->created_at->format('m') === $m);
            $stnkM = $stnkYear->filter(fn($i) => (int)$i->created_at->format('m') === $m);

            $countLaka = $lakaM->count();
            $countStnk = $stnkM->count();
            $totalM = $countLaka + $countStnk;

            $selesaiLaka = $lakaM->where('status', 'selesai')->count();
            $selesaiStnk = $stnkM->whereIn('status', ['approved', 'selesai'])->count();
            $selesaiTotal = $selesaiLaka + $selesaiStnk;

            $persentase = $totalM > 0 ? round(($selesaiTotal / $totalM) * 100) : 0;

            $monthlyRecap[] = [
                'month_num'   => $m,
                'month_name'  => $monthName,
                'month_short' => $monthShort,
                'count_laka'  => $countLaka,
                'count_stnk'  => $countStnk,
                'total'       => $totalM,
                'selesai'     => $selesaiTotal,
                'persentase'  => $persentase,
            ];

            $chartMonthLabels[] = $monthShort;
            $chartMonthLaka[] = $countLaka;
            $chartMonthStnk[] = $countStnk;
            $chartMonthTotal[] = $totalM;
        }

        // Metrik bulan yang dipilih
        $selectedMonthDate = Carbon::createFromDate($filterTahun, $filterBulan, 1);
        $selectedMonthData = collect($monthlyRecap)->firstWhere('month_num', $filterBulan) ?? [
            'month_num'   => $filterBulan,
            'month_name'  => $selectedMonthDate->translatedFormat('F'),
            'month_short' => $selectedMonthDate->translatedFormat('M'),
            'count_laka'  => 0,
            'count_stnk'  => 0,
            'total'       => 0,
            'selesai'     => 0,
            'persentase'  => 0,
        ];

        // 7. Pengaduan Terbaru untuk Widget
        $stnkTerbaru = PengaduanStnk::with('user')->latest()->take(5)->get();
        $kecelakaanTerbaru = PengaduanKecelakaan::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stnkBaru', 'stnkProses', 'stnkSelesaiTotal',
            'kecelakaanBaru', 'kecelakaanProses', 'kecelakaanSelesaiTotal',
            'today', 'stnkHariIni', 'kecelakaanHariIni', 'totalHariIni', 'selesaiHariIni',
            'chartDaysLabels', 'chartLakaPerHari', 'chartStnkPerHari', 'chartTotalPerHari',
            'lakaHariIniBaru', 'lakaHariIniProses', 'lakaHariIniSelesai',
            'stnkHariIniBaru', 'stnkHariIniProses', 'stnkHariIniSelesai',
            'filterTanggal', 'dailyStats', 'pengaduanHariTerpilih',
            'filterTahun', 'filterBulan', 'monthlyRecap', 'selectedMonthData',
            'chartMonthLabels', 'chartMonthLaka', 'chartMonthStnk', 'chartMonthTotal',
            'stnkTerbaru', 'kecelakaanTerbaru'
        ));
    }

    public function cetakReport(Request $request)
    {
        $tipe = $request->get('tipe', 'harian'); // 'harian' atau 'bulanan'

        if ($tipe === 'bulanan') {
            $tahun = (int) $request->get('tahun', Carbon::now()->year);
            $bulan = (int) $request->get('bulan', Carbon::now()->month);
            $monthDate = Carbon::createFromDate($tahun, $bulan, 1);

            $lakaList = PengaduanKecelakaan::with('user')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->latest()
                ->get();

            $stnkList = PengaduanStnk::with('user')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->latest()
                ->get();

            $total = $lakaList->count() + $stnkList->count();
            $selesai = $lakaList->where('status', 'selesai')->count() + $stnkList->whereIn('status', ['approved', 'selesai'])->count();
            $diproses = $lakaList->where('status', 'diproses')->count() + $stnkList->whereIn('status', ['menunggu_berkas', 'diproses'])->count();
            $baru = $lakaList->where('status', 'baru')->count() + $stnkList->where('status', 'diajukan')->count();

            return view('admin.rekap-cetak', [
                'tipe'        => 'bulanan',
                'periode'     => $monthDate->translatedFormat('F Y'),
                'tanggal_doc' => Carbon::now()->translatedFormat('d F Y'),
                'total'       => $total,
                'count_laka'  => $lakaList->count(),
                'count_stnk'  => $stnkList->count(),
                'baru'        => $baru,
                'diproses'    => $diproses,
                'selesai'     => $selesai,
                'persentase'  => $total > 0 ? round(($selesai / $total) * 100) : 0,
                'lakaList'    => $lakaList,
                'stnkList'    => $stnkList,
            ]);
        }

        // Default: Harian
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $dateCarbon = Carbon::parse($tanggal);

        $lakaList = PengaduanKecelakaan::with('user')
            ->whereDate('created_at', $tanggal)
            ->latest()
            ->get();

        $stnkList = PengaduanStnk::with('user')
            ->whereDate('created_at', $tanggal)
            ->latest()
            ->get();

        $total = $lakaList->count() + $stnkList->count();
        $selesai = $lakaList->where('status', 'selesai')->count() + $stnkList->whereIn('status', ['approved', 'selesai'])->count();
        $diproses = $lakaList->where('status', 'diproses')->count() + $stnkList->whereIn('status', ['menunggu_berkas', 'diproses'])->count();
        $baru = $lakaList->where('status', 'baru')->count() + $stnkList->where('status', 'diajukan')->count();

        return view('admin.rekap-cetak', [
            'tipe'        => 'harian',
            'periode'     => $dateCarbon->translatedFormat('l, d F Y'),
            'tanggal_doc' => Carbon::now()->translatedFormat('d F Y'),
            'total'       => $total,
            'count_laka'  => $lakaList->count(),
            'count_stnk'  => $stnkList->count(),
            'baru'        => $baru,
            'diproses'    => $diproses,
            'selesai'     => $selesai,
            'persentase'  => $total > 0 ? round(($selesai / $total) * 100) : 0,
            'lakaList'    => $lakaList,
            'stnkList'    => $stnkList,
        ]);
    }
}
