<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Peminjam;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
        public function pinjam(Request $request)
    {
        $request->validate([
            'peminjam_id' => 'required|exists:peminjams,id',
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $peminjamId = $request->peminjam_id;
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < 1) {
            return response()->json(['message' => 'Stok buku tidak tersedia'], 400);
        }

        $aktif = Peminjaman::where('peminjam_id', $peminjamId)
            ->whereNull('tanggal_kembali')
            ->first();

        if ($aktif) {
            return response()->json(['message' => 'Peminjam masih memiliki buku yang belum dikembalikan'], 400);
        }

        $peminjaman = Peminjaman::create([
            'buku_id' => $buku->id,
            'peminjam_id' => $peminjamId,
            'tanggal_pinjam' => Carbon::now()->toDateString(),
        ]);

        $buku->decrement('stok');

        return response()->json(['message' => 'Peminjaman berhasil', 'data' => $peminjaman], 201);
    }

        public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->tanggal_kembali) {
            return response()->json(['message' => 'Buku sudah dikembalikan'], 400);
        }

        $tanggalPinjam = Carbon::parse($peminjaman->tanggal_pinjam);
        $tanggalKembali = Carbon::now();
        $selisihHari = $tanggalPinjam->diffInDays($tanggalKembali);

        $status = $selisihHari > 30 ? 'terlambat' : 'tepat waktu';

        $peminjaman->update([
            'tanggal_kembali' => $tanggalKembali->toDateString(),
            'status_pengembalian' => $status,
        ]);

        $buku = Buku::findOrFail($peminjaman->buku_id);
        $buku->increment('stok');

        return response()->json(['message' => 'Pengembalian berhasil', 'status' => $status]);
    }
}
