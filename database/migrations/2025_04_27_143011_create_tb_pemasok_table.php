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
        Schema::create('tb_pemasok', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemasok', 50)->unique();
            $table->string('nama_pemasok', 100);
            $table->string('alamat', 255);
            $table->string('telepon', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pemasok');
    }
};
