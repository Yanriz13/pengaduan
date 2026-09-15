<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan_stnks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_pemohon');
            $table->string('jenis_kendaraan');
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['diajukan', 'menunggu_berkas', 'diproses', 'approved', 'rejected'])
                ->default('diajukan');
            $table->string('contoh_berkas_path')->nullable();
            $table->string('berkas_user_path')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_stnks');
    }
};
