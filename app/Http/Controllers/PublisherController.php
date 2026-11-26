<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // Aturan validasi dipakai di store dan update
    private array $rules = [
        'nama_penerbit' => 'required|string|max:100',
        'kontak_sales'  => 'required|string|max:50',
        'alamat'        => 'required|string',
        'wilayah_asal'  => 'required|string|max:50',
    ];

    // READ: daftar semua penerbit
    public function index()
    {
        $publishers = Publisher::latest()->get();
        return view('publishers.index', compact('publishers'));
    }

    // Tampilkan form tambah (pakai view form yang sama dengan edit)
    public function create()
    {
        return view('publishers.form');
    }

    // CREATE: simpan data baru
    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        Publisher::create($data);

        return redirect()->route('publishers.index')
            ->with('success', 'Penerbit berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit(Publisher $publisher)
    {
        return view('publishers.form', compact('publisher'));
    }

    // UPDATE: ubah data
    public function update(Request $request, Publisher $publisher)
    {
        $data = $request->validate($this->rules);
        $publisher->update($data);

        return redirect()->route('publishers.index')
            ->with('success', 'Penerbit berhasil diperbarui!');
    }

    // DELETE: hapus data
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('publishers.index')
            ->with('success', 'Penerbit berhasil dihapus!');
    }
}
