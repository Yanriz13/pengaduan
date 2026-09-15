<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KecelakaanController as AdminKecelakaanController;
use App\Http\Controllers\Admin\StnkController as AdminStnkController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\KecelakaanController as UserKecelakaanController;
use App\Http\Controllers\User\StnkController as UserStnkController;
use App\Models\StnkPersyaratanBerkas;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect(auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard'))
        : redirect()->route('login');
});

// Guest / Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

// Area User
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/stnk', [UserStnkController::class, 'index'])->name('stnk.index');
    Route::get('/stnk/create', [UserStnkController::class, 'create'])->name('stnk.create');
    Route::post('/stnk', [UserStnkController::class, 'store'])->name('stnk.store');
    Route::get('/stnk/{stnk}', [UserStnkController::class, 'show'])->name('stnk.show');
    Route::post('/stnk/{stnk}/upload-berkas', [UserStnkController::class, 'uploadBerkas'])->name('stnk.upload-berkas');
    Route::post('/stnk/{stnk}/upload-berkas/{berkas}', [UserStnkController::class, 'uploadBerkasItem'])->name('stnk.upload-berkas-item');

    Route::get('/kecelakaan', [UserKecelakaanController::class, 'index'])->name('kecelakaan.index');
    Route::get('/kecelakaan/create', [UserKecelakaanController::class, 'create'])->name('kecelakaan.create');
    Route::post('/kecelakaan', [UserKecelakaanController::class, 'store'])->name('kecelakaan.store');
    Route::get('/kecelakaan/{kecelakaan}', [UserKecelakaanController::class, 'show'])->name('kecelakaan.show');
    Route::post('/kecelakaan/{kecelakaan}/pesan', [UserKecelakaanController::class, 'storeMessage'])->name('kecelakaan.pesan');
});

// Area Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekap/cetak', [AdminDashboardController::class, 'cetakReport'])->name('rekap.cetak');

    Route::get('/stnk', [AdminStnkController::class, 'index'])->name('stnk.index');
    Route::get('/stnk/{stnk}', [AdminStnkController::class, 'show'])->name('stnk.show');
    Route::post('/stnk/{stnk}/kirim-contoh-berkas', [AdminStnkController::class, 'kirimContohBerkas'])->name('stnk.kirim-contoh-berkas');
    Route::post('/stnk/{stnk}/persyaratan', [AdminStnkController::class, 'storePersyaratan'])->name('stnk.persyaratan.store');
    Route::delete('/stnk/{stnk}/persyaratan/{berkas}', [AdminStnkController::class, 'destroyPersyaratan'])->name('stnk.persyaratan.destroy');
    Route::post('/stnk/{stnk}/kirim-persyaratan', [AdminStnkController::class, 'kirimPersyaratan'])->name('stnk.kirim-persyaratan');
    Route::post('/stnk/{stnk}/approve', [AdminStnkController::class, 'approve'])->name('stnk.approve');
    Route::post('/stnk/{stnk}/reject', [AdminStnkController::class, 'reject'])->name('stnk.reject');
    Route::post('/stnk/{stnk}/upload-dokumen-akhir', [AdminStnkController::class, 'uploadDokumenAkhir'])->name('stnk.upload-dokumen-akhir');

    Route::get('/kecelakaan', [AdminKecelakaanController::class, 'index'])->name('kecelakaan.index');
    Route::get('/kecelakaan/{kecelakaan}', [AdminKecelakaanController::class, 'show'])->name('kecelakaan.show');
    Route::post('/kecelakaan/{kecelakaan}/pesan', [AdminKecelakaanController::class, 'storeMessage'])->name('kecelakaan.pesan');
    Route::post('/kecelakaan/{kecelakaan}/status', [AdminKecelakaanController::class, 'updateStatus'])->name('kecelakaan.status');

    // Cek notifikasi pengaduan baru / belum ditangani secara real-time
    Route::get('/notifications/check', function () {
        $countStnk = \App\Models\PengaduanStnk::where('status', 'diajukan')->count();
        $countKecelakaan = \App\Models\PengaduanKecelakaan::where('status', 'baru')->count();
        $total = $countStnk + $countKecelakaan;

        $items = [];
        foreach (\App\Models\PengaduanKecelakaan::with('user')->where('status', 'baru')->latest()->take(4)->get() as $item) {
            $items[] = [
                'type' => 'kecelakaan',
                'title' => $item->judul,
                'user' => $item->user->name ?? 'Warga',
                'time' => $item->created_at->diffForHumans(),
                'location' => $item->nama_lokasi,
                'url' => route('admin.kecelakaan.show', $item),
            ];
        }
        foreach (\App\Models\PengaduanStnk::with('user')->where('status', 'diajukan')->latest()->take(4)->get() as $item) {
            $items[] = [
                'type' => 'stnk',
                'title' => $item->merk_tipe ?: ($item->jenis_kendaraan ?: 'Pengaduan STNK'),
                'plat' => $item->plat_nomor,
                'user' => $item->nama_pemilik ?: ($item->nama_pemohon ?: ($item->user->name ?? 'Warga')),
                'time' => $item->created_at->diffForHumans(),
                'url' => route('admin.stnk.show', $item),
            ];
        }

        return response()->json([
            'total' => $total,
            'count_stnk' => $countStnk,
            'count_kecelakaan' => $countKecelakaan,
            'items' => $items,
        ]);
    })->name('notifications.check');
});
