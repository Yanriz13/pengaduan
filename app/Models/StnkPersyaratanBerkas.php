<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StnkPersyaratanBerkas extends Model
{
    use HasFactory;

    protected $table = 'stnk_persyaratan_berkas';

    protected $fillable = [
        'pengaduan_stnk_id',
        'label',
        'keterangan',
        'is_required',
        'berkas_user_path',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function pengaduanStnk()
    {
        return $this->belongsTo(PengaduanStnk::class, 'pengaduan_stnk_id');
    }

    public function sudahDiupload(): bool
    {
        return !is_null($this->berkas_user_path);
    }
}
