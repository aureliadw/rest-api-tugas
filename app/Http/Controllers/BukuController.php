<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        return Buku::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isbn' => 'required|unique:bukus',
            'stok' => 'required|integer|min:0',
        ]);

        return Buku::create($request->all());
    }

    public function show($id)
    {
        return Buku::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'isbn' => 'required|unique:bukus,isbn,' . $id,
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update($request->all());

        return $buku;
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
