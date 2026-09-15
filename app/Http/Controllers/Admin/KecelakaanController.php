<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KecelakaanMessage;
use App\Models\PengaduanKecelakaan;
use Illuminate\Http\Request;

class KecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $items = PengaduanKecelakaan::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.kecelakaan.index', compact('items'));
    }

    public function show(PengaduanKecelakaan $kecelakaan)
    {
        $kecelakaan->load('messages.user', 'user');

        return view('admin.kecelakaan.show', ['item' => $kecelakaan]);
    }

    public function storeMessage(Request $request, PengaduanKecelakaan $kecelakaan)
    {
        $data = $request->validate([
            'pesan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:5120'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'nama_lokasi' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($data['pesan']) && !$request->hasFile('foto') && empty($data['latitude'])) {
            return back()->withErrors(['pesan' => 'Isi balasan terlebih dahulu.']);
        }

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('kecelakaan', 'public');
        }

        KecelakaanMessage::create([
            'pengaduan_kecelakaan_id' => $kecelakaan->id,
            'user_id' => $request->user()->id,
            'pesan' => $data['pesan'] ?? null,
            'foto_path' => $data['foto_path'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'nama_lokasi' => $data['nama_lokasi'] ?? null,
        ]);

        if ($kecelakaan->status === 'baru') {
            $kecelakaan->update(['status' => 'diproses']);
        }

        return back();
    }

    public function updateStatus(Request $request, PengaduanKecelakaan $kecelakaan)
    {
        $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai'],
        ]);

        $kecelakaan->update(['status' => $request->status]);

        return back()->with('status', 'Status laporan diperbarui.');
    }
}
