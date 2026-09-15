<?php

namespace Database\Seeders;

use App\Models\PengaduanStnk;
use App\Models\StnkPersyaratanBerkas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ── User ke-2 (jika belum ada) ──
        $user2 = User::firstOrCreate(
            ['email' => 'user2@pengaduan.test'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'user',
                'no_hp'    => '081234567890',
            ]
        );

        // ── Pastikan user 1 ada ──
        $user1 = User::firstOrCreate(
            ['email' => 'user@pengaduan.test'],
            [
                'name'     => 'Warga Contoh',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        // ══════════════════════════════════════════
        //  PENGADUAN USER 1 — berbagai status
        // ══════════════════════════════════════════

        // 1a. Baru diajukan
        PengaduanStnk::create([
            'user_id'         => $user1->id,
            'nama_pemilik'    => 'Warga Contoh',
            'nama_pemohon'    => 'Warga Contoh',
            'nik'             => '3201123456780001',
            'alamat'          => 'Jl. Pajajaran No. 45, RT 02/RW 05, Baranangsiang, Kota Bogor',
            'no_hp'           => '081234567891',
            'plat_nomor'      => 'F 2345 ABC',
            'merk_tipe'       => 'Honda Vario 125 CBS',
            'jenis_model'     => 'Sepeda Motor',
            'jenis_kendaraan' => 'Honda Vario 125 CBS (F 2345 ABC)',
            'tahun_pembuatan' => '2022',
            'warna'           => 'Hitam Doff',
            'nomor_rangka'    => 'MH1JF8119MK123456',
            'nomor_mesin'     => 'JF81E1123456',
            'nomor_bpkb'      => 'M-0987654-B',
            'deskripsi'       => 'STNK hilang saat bepergian ke pasar. Mohon diproses secepatnya.',
            'status'          => 'diajukan',
        ]);

        // 1b. Menunggu berkas — admin sudah set persyaratan
        $p1b = PengaduanStnk::create([
            'user_id'         => $user1->id,
            'nama_pemilik'    => 'Warga Contoh',
            'nama_pemohon'    => 'Warga Contoh',
            'nik'             => '3201123456780001',
            'alamat'          => 'Jl. Pajajaran No. 45, RT 02/RW 05, Baranangsiang, Kota Bogor',
            'no_hp'           => '081234567891',
            'plat_nomor'      => 'F 5678 XYZ',
            'merk_tipe'       => 'Toyota Avanza 1.3 G',
            'jenis_model'     => 'Minibus',
            'jenis_kendaraan' => 'Toyota Avanza 1.3 G (F 5678 XYZ)',
            'tahun_pembuatan' => '2020',
            'warna'           => 'Silver Metalik',
            'nomor_rangka'    => 'MHFM5EA2JBK456789',
            'nomor_mesin'     => 'DG172AA456789',
            'nomor_bpkb'      => 'N-1234567-C',
            'deskripsi'       => 'STNK hilang, sudah buat laporan polisi.',
            'status'          => 'menunggu_berkas',
            'catatan_admin'   => 'Mohon lampirkan dokumen sesuai persyaratan di bawah ini.',
        ]);

        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p1b->id,
            'label'             => 'KTP (Kartu Tanda Penduduk)',
            'keterangan'        => 'Scan warna, pastikan terbaca jelas',
            'is_required'       => true,
        ]);
        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p1b->id,
            'label'             => 'Kartu Keluarga (KK)',
            'keterangan'        => 'Scan warna halaman pertama',
            'is_required'       => true,
        ]);
        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p1b->id,
            'label'             => 'Surat Keterangan Kehilangan dari Polisi',
            'keterangan'        => 'Asli atau fotokopi legalisir',
            'is_required'       => true,
        ]);
        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p1b->id,
            'label'             => 'BPKB (Buku Pemilik Kendaraan Bermotor)',
            'keterangan'        => 'Fotokopi halaman depan dan belakang',
            'is_required'       => false,
        ]);

        // 1c. Diproses — user sudah upload semua
        $p1c = PengaduanStnk::create([
            'user_id'         => $user1->id,
            'nama_pemohon'    => 'Warga Contoh',
            'jenis_kendaraan' => 'Motor Yamaha NMAX',
            'nomor_rangka'    => 'MH3SG3210LK987654',
            'nomor_mesin'     => 'E3T3E1987654',
            'deskripsi'       => 'Perpanjangan STNK tahunan.',
            'status'          => 'diproses',
            'catatan_admin'   => 'Lengkapi berkas berikut untuk diproses.',
        ]);

        $berkas1c_1 = StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p1c->id,
            'label'             => 'KTP Pemilik',
            'keterangan'        => 'Foto asli warna',
            'is_required'       => true,
            'berkas_user_path'  => null, // simulasi sudah upload (null karena tidak ada file nyata)
        ]);

        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p1c->id,
            'label'             => 'STNK Lama',
            'keterangan'        => 'Fotokopi STNK tahun sebelumnya',
            'is_required'       => true,
            'berkas_user_path'  => null,
        ]);

        // ══════════════════════════════════════════
        //  PENGADUAN USER 2 — berbagai status
        // ══════════════════════════════════════════

        // 2a. Baru diajukan
        PengaduanStnk::create([
            'user_id'         => $user2->id,
            'nama_pemohon'    => 'Budi Santoso',
            'jenis_kendaraan' => 'Motor Suzuki GSX-R150',
            'nomor_rangka'    => 'MH8DF41ANMJ112233',
            'nomor_mesin'     => 'F41ANMJ112233',
            'deskripsi'       => 'STNK hilang, sudah lapor ke polsek setempat. Mohon bantuan pengurusan.',
            'status'          => 'diajukan',
        ]);

        // 2b. Menunggu berkas — dengan persyaratan berbeda
        $p2b = PengaduanStnk::create([
            'user_id'         => $user2->id,
            'nama_pemohon'    => 'Budi Santoso',
            'jenis_kendaraan' => 'Mobil Honda Civic',
            'nomor_rangka'    => 'MHRFC1850MP334455',
            'nomor_mesin'     => 'R18A1334455',
            'deskripsi'       => 'Penggantian STNK karena rusak berat.',
            'status'          => 'menunggu_berkas',
            'catatan_admin'   => 'Siapkan dokumen di bawah ini. Pastikan semua terbaca jelas.',
        ]);

        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p2b->id,
            'label'             => 'KTP (NIK Pemilik)',
            'keterangan'        => 'Scan KTP warna asli, semua data terbaca',
            'is_required'       => true,
        ]);
        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p2b->id,
            'label'             => 'Kartu Keluarga',
            'keterangan'        => 'Halaman pertama yang memuat NIK',
            'is_required'       => true,
        ]);
        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p2b->id,
            'label'             => 'BPKB Asli',
            'keterangan'        => 'Wajib asli, bukan fotokopi',
            'is_required'       => true,
        ]);
        StnkPersyaratanBerkas::create([
            'pengaduan_stnk_id' => $p2b->id,
            'label'             => 'Surat Keterangan Kehilangan Polisi',
            'keterangan'        => null,
            'is_required'       => false,
        ]);

        // 2c. Approved + dokumen akhir sudah dikirim (simulasi)
        PengaduanStnk::create([
            'user_id'             => $user2->id,
            'nama_pemohon'        => 'Budi Santoso',
            'jenis_kendaraan'     => 'Motor Honda Beat',
            'nomor_rangka'        => 'MH1JFD118EK556677',
            'nomor_mesin'         => 'JFD1E1556677',
            'deskripsi'           => 'Pengurusan STNK baru.',
            'status'              => 'approved',
            'catatan_admin'       => 'Berkas lengkap dan valid. Pengaduan disetujui.',
            'nama_dokumen_akhir'  => 'Surat Keterangan Penggantian STNK',
            // dokumen_akhir_path dikosongkan karena tidak ada file nyata
        ]);

        $this->command->info('✅ Demo seeder berhasil! Akun:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@pengaduan.test', 'password'],
                ['User 1', 'user@pengaduan.test', 'password'],
                ['User 2 (Baru)', 'user2@pengaduan.test', 'password'],
            ]
        );
    }
}
