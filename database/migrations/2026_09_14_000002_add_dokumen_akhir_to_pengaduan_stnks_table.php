<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduan_stnks', function (Blueprint $table) {
            // Nama/label dokumen akhir, contoh: "Surat Keterangan Kehilangan STNK"
            $table->string('nama_dokumen_akhir')->nullable()->after('catatan_admin');
            // Path file dokumen akhir yang dikirim admin setelah approve
            $table->string('dokumen_akhir_path')->nullable()->after('nama_dokumen_akhir');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan_stnks', function (Blueprint $table) {
            $table->dropColumn(['nama_dokumen_akhir', 'dokumen_akhir_path']);
        });
    }
};
