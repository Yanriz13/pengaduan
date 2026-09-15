<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KecelakaanMessage;
use App\Models\PengaduanKecelakaan;
use Illuminate\Http\Request;

class KecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()->pengaduanKecelakaans()->latest()->paginate(10);

        return view('user.kecelakaan.index', compact('items'));
    }

    public function create()
    {
        return view('user.kecelakaan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'       => ['required', 'string', 'max:255'],
            'deskripsi'   => ['nullable', 'string'],
            'latitude'    => ['required', 'numeric'],
            'longitude'   => ['required', 'numeric'],
            'nama_lokasi' => ['nullable', 'string', 'max:500'],
            'foto'        => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('kecelakaan', 'public');
        }

        $data['user_id'] = $request->user()->id;
        $data['status']  = 'baru';

        $pengaduan = PengaduanKecelakaan::create($data);

        // pesan pembuka otomatis masuk ke thread chat
        KecelakaanMessage::create([
            'pengaduan_kecelakaan_id' => $pengaduan->id,
            'user_id'                 => $request->user()->id,
            'pesan'                   => $data['deskripsi'] ?? 'Laporan kecelakaan telah dikirim.',
            'foto_path'               => $data['foto_path'] ?? null,
            'latitude'                => $data['latitude'],
            'longitude'               => $data['longitude'],
            'nama_lokasi'             => $data['nama_lokasi'] ?? null,
        ]);

        return redirect()->route('user.kecelakaan.show', $pengaduan)
            ->with('status', 'Laporan kecelakaan berhasil dikirim.');
    }

    public function show(Request $request, PengaduanKecelakaan $kecelakaan)
    {
        $this->authorizeOwner($request, $kecelakaan);
        $kecelakaan->load('messages.user');

        return view('user.kecelakaan.show', ['item' => $kecelakaan]);
    }

    public function storeMessage(Request $request, PengaduanKecelakaan $kecelakaan)
    {
        $this->authorizeOwner($request, $kecelakaan);

        $data = $request->validate([
            'pesan'       => ['nullable', 'string'],
            'foto'        => ['nullable', 'image', 'max:5120'],
            'latitude'    => ['nullable', 'numeric'],
            'longitude'   => ['nullable', 'numeric'],
            'nama_lokasi' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($data['pesan']) && ! $request->hasFile('foto') && empty($data['latitude'])) {
            return back()->withErrors(['pesan' => 'Isi pesan, titik koordinat, atau foto terlebih dahulu.']);
        }

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('kecelakaan', 'public');
        }

        KecelakaanMessage::create([
            'pengaduan_kecelakaan_id' => $kecelakaan->id,
            'user_id'                 => $request->user()->id,
            'pesan'                   => $data['pesan'] ?? null,
            'foto_path'               => $data['foto_path'] ?? null,
            'latitude'                => $data['latitude'] ?? null,
            'longitude'               => $data['longitude'] ?? null,
            'nama_lokasi'             => $data['nama_lokasi'] ?? null,
        ]);

        return back();
    }

    private function authorizeOwner(Request $request, PengaduanKecelakaan $kecelakaan): void
    {
        abort_unless($kecelakaan->user_id === $request->user()->id, 403);
    }
}
