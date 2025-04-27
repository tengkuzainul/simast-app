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
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('tb_kategori')->onDelete('cascade')->onUpdate('cascade');
            $table->string('kode_barang', 50)->unique();
            $table->string('foto_barang')->nullable();
            $table->string('nama_barang', 255);
            $table->string('satuan');
            $table->integer('stok_final')->default(0);
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
    }
};
