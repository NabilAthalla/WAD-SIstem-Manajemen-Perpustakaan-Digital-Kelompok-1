<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuApiController extends Controller
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
            ->paginate(10);

        return BukuResource::collection($bukus);
    }

    public function show(Buku $buku)
    {
        return new BukuResource($buku->load('kategori'));
    }

    public function store(Request $request)
    {
        $buku = Buku::create($request->validate($this->rules()));

        return (new BukuResource($buku->load('kategori')))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Buku $buku)
    {
        $buku->update($request->validate($this->rules($buku->id)));

        return new BukuResource($buku->load('kategori'));
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.']);
    }
}