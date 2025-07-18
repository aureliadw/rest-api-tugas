<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('bukus');
            $table->foreignId('peminjam_id')->constrained('peminjams');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); // diisi saat pengembalian
            $table->string('status_pengembalian')->nullable(); // "tepat waktu" / "terlambat"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjamans');
    }
};
