<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_stok_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 50);
            $table->foreignId('barang_id')->constrained('tb_barang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pemasok_id')->nullable()->constrained('tb_pemasok')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('tipe_transaksi', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->enum('status_transaksi', ['Disetujui', 'Menunggu'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_stok_transaksi');
    }
};
