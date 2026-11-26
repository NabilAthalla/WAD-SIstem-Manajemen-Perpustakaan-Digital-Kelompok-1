<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherApiController extends Controller
{
    // GET /api/publishers
    // Contoh filter: /api/publishers?wilayah=Jawa Barat
    public function index(Request $request)
    {
        $query = Publisher::query();

        // Jika ada ?wilayah=..., tampilkan hanya penerbit dari wilayah itu
        if ($request->filled('wilayah')) {
            $query->where('wilayah_asal', $request->wilayah);
        }

        $publishers = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar penerbit',
            'total'   => $publishers->count(),
            'data'    => $publishers,
        ]);
    }

    // GET /api/publishers/{id}
    public function show($id)
    {
        $publisher = Publisher::find($id);

        // Jika id tidak ada, kembalikan JSON error dengan kode HTTP 404
        if (!$publisher) {
            return response()->json([
                'success' => false,
                'message' => 'Penerbit tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail penerbit',
            'data'    => $publisher,
        ]);
    }
}
