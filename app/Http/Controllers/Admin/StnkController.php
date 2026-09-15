<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaduanStnk;
use App\Models\StnkPersyaratanBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StnkController extends Controller
{
    public function index(Request $request)
    {
        $items = PengaduanStnk::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.stnk.index', compact('items'));
    }

    public function show(PengaduanStnk $stnk)
    {
        $stnk->load(['user', 'persyaratanBerkas']);

        return view('admin.stnk.show', ['item' => $stnk]);
    }

    /**
     * Tambah satu item persyaratan berkas.
     */
    public function storePersyaratan(Request $request, PengaduanStnk $stnk)
    {
        $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'is_required' => ['nullable', 'boolean'],
        ]);

        $stnk->persyaratanBerkas()->create([
            'label' => $request->label,
            'keterangan' => $request->keterangan,
            'is_required' => $request->boolean('is_required', true),
        ]);

        return back()->with('status', 'Persyaratan berkas berhasil ditambahkan.');
    }

    /**
     * Hapus satu item persyaratan berkas.
     */
    public function destroyPersyaratan(Request $request, PengaduanStnk $stnk, StnkPersyaratanBerkas $berkas)
    {
        abort_unless($berkas->pengaduan_stnk_id === $stnk->id, 403);

        if ($berkas->berkas_user_path) {
            Storage::disk('public')->delete($berkas->berkas_user_path);
        }

        $berkas->delete();

        return back()->with('status', 'Persyaratan berkas dihapus.');
    }

    /**
     * Finalisasi dan kirim daftar persyaratan ke user.
     * Status berubah ke menunggu_berkas.
     */
    public function kirimPersyaratan(Request $request, PengaduanStnk $stnk)
    {
        abort_if($stnk->persyaratanBerkas()->count() === 0, 422, 'Tambahkan minimal satu persyaratan berkas sebelum mengirim.');

        $request->validate([
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $stnk->update([
            'status' => 'menunggu_berkas',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('status', 'Persyaratan berkas berhasil dikirim ke pemohon. Status diubah ke Menunggu Berkas.');
    }

    public function approve(PengaduanStnk $stnk)
    {
        $stnk->load('persyaratanBerkas');

        // Cek apakah pakai sistem baru
        if ($stnk->persyaratanBerkas->count() > 0) {
            abort_unless($stnk->semuaBerkasWajibSudahDiupload(), 422, 'Masih ada berkas wajib yang belum diunggah oleh user.');
        } else {
            // fallback sistem lama
            abort_unless($stnk->berkas_user_path, 422, 'User belum mengunggah berkas.');
        }

        $stnk->update(['status' => 'approved']);

        return back()->with('status', 'Pengaduan STNK disetujui. Silakan upload dokumen akhir untuk pemohon.');
    }

    /**
     * Admin mengupload dokumen akhir (surat persetujuan, surat kehilangan, dll)
     * setelah pengaduan berstatus approved.
     */
    public function uploadDokumenAkhir(Request $request, PengaduanStnk $stnk)
    {
        abort_unless($stnk->status === 'approved', 422, 'Dokumen akhir hanya bisa dikirim setelah pengaduan disetujui.');

        $request->validate([
            'dokumen_akhir' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'nama_dokumen_akhir' => ['required', 'string', 'max:255'],
        ]);

        // Hapus file lama jika ada
        if ($stnk->dokumen_akhir_path) {
            Storage::disk('public')->delete($stnk->dokumen_akhir_path);
        }

        $path = $request->file('dokumen_akhir')->store('berkas/dokumen-akhir', 'public');

        $stnk->update([
            'dokumen_akhir_path' => $path,
            'nama_dokumen_akhir' => $request->nama_dokumen_akhir,
        ]);

        return back()->with('status', 'Dokumen akhir berhasil dikirim ke pemohon.');
    }

    public function reject(Request $request, PengaduanStnk $stnk)
    {
        $request->validate([
            'catatan_admin' => ['required', 'string'],
        ]);

        $stnk->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('status', 'Pengaduan STNK ditolak, berkas belum sesuai.');
    }

    // ───────── Legacy method (tetap ada untuk backward compat) ─────────
    public function kirimContohBerkas(Request $request, PengaduanStnk $stnk)
    {
        $request->validate([
            'contoh_berkas' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        if ($stnk->contoh_berkas_path) {
            Storage::disk('public')->delete($stnk->contoh_berkas_path);
        }

        $path = $request->file('contoh_berkas')->store('berkas/contoh', 'public');

        $stnk->update([
            'contoh_berkas_path' => $path,
            'catatan_admin' => $request->catatan_admin,
            'status' => 'menunggu_berkas',
        ]);

        return back()->with('status', 'Contoh formulir/berkas berhasil dikirim ke pemohon.');
    }
}
