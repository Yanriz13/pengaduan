<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stnk_persyaratan_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_stnk_id')->constrained('pengaduan_stnks')->cascadeOnDelete();
            $table->string('label');           // e.g. "KTP", "Kartu Keluarga", "BPKB"
            $table->text('keterangan')->nullable(); // penjelasan opsional
            $table->boolean('is_required')->default(true);
            $table->string('berkas_user_path')->nullable(); // path file yang diupload user
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stnk_persyaratan_berkas');
    }
};
