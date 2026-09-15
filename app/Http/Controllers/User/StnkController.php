<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PengaduanStnk;
use App\Models\StnkPersyaratanBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StnkController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()->pengaduanStnks()->latest()->paginate(10);

        return view('user.stnk.index', compact('items'));
    }

    public function create()
    {
        return view('user.stnk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // 1. Data Identitas Pemilik Kendaraan
            'nama_pemilik'    => ['required', 'string', 'max:255'],
            'nik'             => ['required', 'string', 'max:30'],
            'alamat'          => ['required', 'string'],
            'no_hp'           => ['required', 'string', 'max:30'],

            // 2. Data / Spesifikasi Kendaraan Bermotor
            'plat_nomor'      => ['required', 'string', 'max:30'],
            'merk_tipe'       => ['required', 'string', 'max:255'],
            'jenis_model'     => ['required', 'string', 'max:255'],
            'tahun_pembuatan' => ['required', 'string', 'max:10'],
            'warna'           => ['required', 'string', 'max:100'],
            'nomor_rangka'    => ['nullable', 'string', 'max:100'],
            'nomor_mesin'     => ['nullable', 'string', 'max:100'],
            'nomor_bpkb'      => ['nullable', 'string', 'max:100'],

            // Keterangan / Kronologi
            'deskripsi'       => ['nullable', 'string'],
        ], [
            'nama_pemilik.required'    => 'Nama pemilik kendaraan wajib diisi (sesuai KTP/BPKB).',
            'nik.required'             => 'NIK / Nomor KTP pemilik wajib diisi.',
            'alamat.required'          => 'Alamat lengkap wajib diisi sesuai KTP.',
            'no_hp.required'           => 'Nomor telepon/HP aktif wajib diisi.',
            'plat_nomor.required'      => 'Nomor Polisi (Plat Nomor) wajib diisi.',
            'merk_tipe.required'       => 'Merk dan tipe kendaraan wajib diisi.',
            'jenis_model.required'     => 'Jenis dan model kendaraan wajib diisi.',
            'tahun_pembuatan.required' => 'Tahun pembuatan kendaraan wajib diisi.',
            'warna.required'           => 'Warna kendaraan wajib diisi.',
        ]);

        $data['nama_pemohon']    = $data['nama_pemilik'];
        $data['jenis_kendaraan'] = "{$data['merk_tipe']} ({$data['plat_nomor']})";
        $data['user_id']         = $request->user()->id;
        $data['status']          = 'diajukan';

        $pengaduan = PengaduanStnk::create($data);

        return redirect()->route('user.stnk.show', $pengaduan)
            ->with('status', 'Pengaduan pembuatan STNK berhasil diajukan.');
    }

    public function show(Request $request, PengaduanStnk $stnk)
    {
        $this->authorizeOwner($request, $stnk);
        $stnk->load('persyaratanBerkas');

        return view('user.stnk.show', ['item' => $stnk]);
    }

    /**
     * Upload berkas per item persyaratan (sistem baru).
     */
    public function uploadBerkasItem(Request $request, PengaduanStnk $stnk, StnkPersyaratanBerkas $berkas)
    {
        $this->authorizeOwner($request, $stnk);
        abort_unless($berkas->pengaduan_stnk_id === $stnk->id, 403);
        abort_unless(in_array($stnk->status, ['menunggu_berkas', 'rejected']), 403, 'Status pengaduan tidak mengizinkan upload berkas.');

        $request->validate([
            'berkas_item' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        // Hapus file lama jika ada
        if ($berkas->berkas_user_path) {
            Storage::disk('public')->delete($berkas->berkas_user_path);
        }

        $path = $request->file('berkas_item')->store('berkas/user', 'public');
        $berkas->update(['berkas_user_path' => $path]);

        // Jika semua berkas wajib sudah diupload, set status diproses
        $stnk->refresh();
        if ($stnk->semuaBerkasWajibSudahDiupload()) {
            $stnk->update(['status' => 'diproses']);
        } elseif ($stnk->status !== 'menunggu_berkas') {
            $stnk->update(['status' => 'menunggu_berkas']);
        }

        return back()->with('status', 'Berkas "' . $berkas->label . '" berhasil diunggah.');
    }

    /**
     * Upload berkas (legacy - satu file, sistem lama).
     */
    public function uploadBerkas(Request $request, PengaduanStnk $stnk)
    {
        $this->authorizeOwner($request, $stnk);

        $request->validate([
            'berkas_user' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($stnk->berkas_user_path) {
            Storage::disk('public')->delete($stnk->berkas_user_path);
        }

        $path = $request->file('berkas_user')->store('berkas/user', 'public');

        $stnk->update([
            'berkas_user_path' => $path,
            'status'           => 'diproses',
        ]);

        return back()->with('status', 'Berkas berhasil diunggah. Menunggu verifikasi admin.');
    }

    private function authorizeOwner(Request $request, PengaduanStnk $stnk): void
    {
        abort_unless($stnk->user_id === $request->user()->id, 403);
    }
}
