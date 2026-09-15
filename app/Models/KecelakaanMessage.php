<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecelakaanMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_kecelakaan_id', 'user_id', 'pesan', 'foto_path', 'latitude', 'longitude', 'nama_lokasi',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(PengaduanKecelakaan::class, 'pengaduan_kecelakaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return null;
    }
}
