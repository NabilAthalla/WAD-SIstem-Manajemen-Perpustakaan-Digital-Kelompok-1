<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    private function rules(?int $id = null): array
    {
        return [
            'judul'       => 'required|string|max:255',
            'isbn'        => 'required|string|max:20|unique:bukus,isbn,' . $id,
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'required|string|max:255',
            'tahun'       => 'required|integer|min:1000|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'cover'       => 'nullable|image|max:2048',
            'deskripsi'      => 'nullable|string',
            'jumlah_halaman' => 'nullable|integer|min:1',
        ];
    }

    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->q, function ($query, $s) {
                $query->where(function ($w) use ($s) {
                    $w->where('judul', 'like', "%{$s}%")
                      ->orWhere('penulis', 'like', "%{$s}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('buku.create', [
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', [
            'buku'      => $buku,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate($this->rules($buku->id));

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}