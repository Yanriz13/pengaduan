<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduan_stnks', function (Blueprint $table) {
            // 1. Data Identitas Pemilik Kendaraan
            $table->string('nama_pemilik')->nullable()->after('user_id');
            $table->string('nik', 30)->nullable()->after('nama_pemilik');
            $table->text('alamat')->nullable()->after('nik');
            $table->string('no_hp', 30)->nullable()->after('alamat');

            // 2. Data / Spesifikasi Kendaraan Bermotor
            $table->string('plat_nomor', 30)->nullable()->after('no_hp');
            $table->string('merk_tipe')->nullable()->after('plat_nomor');
            $table->string('jenis_model')->nullable()->after('merk_tipe');
            $table->string('tahun_pembuatan', 10)->nullable()->after('jenis_model');
            $table->string('warna', 50)->nullable()->after('tahun_pembuatan');
            $table->string('nomor_bpkb', 50)->nullable()->after('nomor_mesin');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan_stnks', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pemilik',
                'nik',
                'alamat',
                'no_hp',
                'plat_nomor',
                'merk_tipe',
                'jenis_model',
                'tahun_pembuatan',
                'warna',
                'nomor_bpkb',
            ]);
        });
    }
};
