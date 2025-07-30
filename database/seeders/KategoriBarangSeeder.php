<?php

namespace Database\Seeders;

use App\Models\DataMaster\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Kemeja Pria',
            'Kemeja Wanita',
            'Kaos Pria',
            'Kaos Wanita',
            'Celana Pria',
            'Celana Wanita',
            'Rok/Skirt',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori,
                'deskripsi' => 'Kelompok Barang Untuk ' . $kategori,
                'status' => true,
            ]);
        }
    }
}
