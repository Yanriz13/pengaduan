<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanKecelakaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'judul', 'deskripsi', 'latitude', 'longitude', 'nama_lokasi', 'foto_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(KecelakaanMessage::class)->orderBy('created_at');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'diproses' => 'Sedang Ditangani',
            'selesai' => 'Selesai',
            default => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'baru' => 'bg-amber-100 text-amber-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'selesai' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return null;
    }
}
