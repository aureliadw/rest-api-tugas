<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;

class PeminjamController extends Controller
{
    public function index()
    {
        return Peminjam::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_ktp' => 'required|unique:peminjams',
            'nama' => 'required',
            'email' => 'required|email|unique:peminjams'
        ]);

        return Peminjam::create($request->all());
    }

    public function show($id)
    {
        return Peminjam::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $peminjam = Peminjam::findOrFail($id);

        $request->validate([
            'nomor_ktp' => 'required|unique:peminjams,nomor_ktp,' . $id,
            'nama' => 'required',
            'email' => 'required|email|unique:peminjams,email,' . $id
        ]);

        $peminjam->update($request->all());

        return $peminjam;
    }

    public function destroy($id)
    {
        $peminjam = Peminjam::findOrFail($id);
        $peminjam->delete();

        return response()->json(['message' => 'Peminjam berhasil dihapus']);
    }
}
