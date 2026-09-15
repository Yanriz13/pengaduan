<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduan_kecelakaans', function (Blueprint $table) {
            $table->text('nama_lokasi')->nullable()->after('longitude');
        });

        Schema::table('kecelakaan_messages', function (Blueprint $table) {
            $table->text('nama_lokasi')->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan_kecelakaans', function (Blueprint $table) {
            $table->dropColumn('nama_lokasi');
        });
        Schema::table('kecelakaan_messages', function (Blueprint $table) {
            $table->dropColumn('nama_lokasi');
        });
    }
};
