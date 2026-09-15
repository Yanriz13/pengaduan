<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanStnk extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 1. Data Identitas Pemilik Kendaraan
        'nama_pemilik',
        'nama_pemohon',
        'nik',
        'alamat',
        'no_hp',
        // 2. Data / Spesifikasi Kendaraan Bermotor
        'plat_nomor',
        'merk_tipe',
        'jenis_model',
        'jenis_kendaraan',
        'tahun_pembuatan',
        'warna',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_bpkb',
        // Pengelolaan & status
        'deskripsi',
        'status',
        'contoh_berkas_path',
        'berkas_user_path',
        'catatan_admin',
        'nama_dokumen_akhir',
        'dokumen_akhir_path',
    ];

    public function getJudulKendaraanAttribute(): string
    {
        if ($this->plat_nomor && $this->merk_tipe) {
            return "{$this->plat_nomor} - {$this->merk_tipe}";
        }

        return $this->merk_tipe ?: ($this->jenis_kendaraan ?: 'Pengaduan STNK');
    }

    public function getNamaPemilikTampilAttribute(): string
    {
        return $this->nama_pemilik ?: ($this->nama_pemohon ?: ($this->user->name ?? '-'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function persyaratanBerkas()
    {
        return $this->hasMany(StnkPersyaratanBerkas::class, 'pengaduan_stnk_id');
    }

    /**
     * Cek apakah semua berkas wajib sudah diupload oleh user.
     */
    public function semuaBerkasWajibSudahDiupload(): bool
    {
        return $this->persyaratanBerkas()
            ->where('is_required', true)
            ->whereNull('berkas_user_path')
            ->doesntExist();
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'diajukan' => 'Menunggu Tinjauan Admin',
            'menunggu_berkas' => 'Menunggu Upload Berkas dari Anda',
            'diproses' => 'Sedang Diproses',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'diajukan' => 'bg-gray-100 text-gray-700',
            'menunggu_berkas' => 'bg-amber-100 text-amber-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
