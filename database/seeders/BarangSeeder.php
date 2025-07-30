<?php

namespace Database\Seeders;

use App\Models\DataMaster\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories from KategoriBarangSeeder

        $barangData = [
            // Kemeja Pria
            [
                'nama_barang' => 'Kemeja Lengan Panjang Formal',
                'kategori_id' => 1,
                'min_stok' => 5,
                'stok_final' => 25,
                'harga_beli' => 85000,
                'harga_jual' => 125000,
                'deskripsi' => 'Kemeja formal untuk pria dengan bahan katun berkualitas'
            ],
            [
                'nama_barang' => 'Kemeja Lengan Pendek Casual',
                'kategori_id' => 1,
                'min_stok' => 5,
                'stok_final' => 30,
                'harga_beli' => 75000,
                'harga_jual' => 110000,
                'deskripsi' => 'Kemeja casual untuk pria dengan motif modern'
            ],

            // Kemeja Wanita
            [
                'nama_barang' => 'Kemeja Wanita Formal',
                'kategori_id' => 2,
                'min_stok' => 5,
                'stok_final' => 20,
                'harga_beli' => 95000,
                'harga_jual' => 145000,
                'deskripsi' => 'Kemeja formal wanita untuk kegiatan kantor'
            ],
            [
                'nama_barang' => 'Blouse Wanita',
                'kategori_id' => 2,
                'min_stok' => 3,
                'stok_final' => 25,
                'harga_beli' => 90000,
                'harga_jual' => 135000,
                'deskripsi' => 'Blouse casual wanita dengan desain chic'
            ],

            // Kaos Pria
            [
                'nama_barang' => 'T-Shirt Katun Premium',
                'kategori_id' => 3,
                'min_stok' => 10,
                'stok_final' => 50,
                'harga_beli' => 45000,
                'harga_jual' => 75000,
                'deskripsi' => 'Kaos pria berbahan katun premium dengan berbagai warna'
            ],
            [
                'nama_barang' => 'Polo Shirt Pria',
                'kategori_id' => 3,
                'min_stok' => 8,
                'stok_final' => 35,
                'harga_beli' => 60000,
                'harga_jual' => 95000,
                'deskripsi' => 'Polo shirt pria dengan kualitas terbaik'
            ],

            // Kaos Wanita
            [
                'nama_barang' => 'Kaos V-Neck Wanita',
                'kategori_id' => 4,
                'min_stok' => 8,
                'stok_final' => 40,
                'harga_beli' => 40000,
                'harga_jual' => 69000,
                'deskripsi' => 'Kaos wanita dengan desain V-neck yang nyaman dipakai'
            ],
            [
                'nama_barang' => 'Crop Top Wanita',
                'kategori_id' => 4,
                'min_stok' => 5,
                'stok_final' => 30,
                'harga_beli' => 50000,
                'harga_jual' => 85000,
                'deskripsi' => 'Crop top trendy untuk wanita'
            ],

            // Celana Pria
            [
                'nama_barang' => 'Celana Chino Pria',
                'kategori_id' => 5,
                'min_stok' => 5,
                'stok_final' => 25,
                'harga_beli' => 120000,
                'harga_jual' => 180000,
                'deskripsi' => 'Celana chino pria dengan material nyaman'
            ],
            [
                'nama_barang' => 'Jeans Slim Fit Pria',
                'kategori_id' => 5,
                'min_stok' => 5,
                'stok_final' => 20,
                'harga_beli' => 150000,
                'harga_jual' => 225000,
                'deskripsi' => 'Jeans dengan potongan slim fit untuk pria'
            ],

            // Celana Wanita
            [
                'nama_barang' => 'Celana Kulot Wanita',
                'kategori_id' => 6,
                'min_stok' => 5,
                'stok_final' => 20,
                'harga_beli' => 110000,
                'harga_jual' => 165000,
                'deskripsi' => 'Celana kulot wanita dengan bahan flowy'
            ],
            [
                'nama_barang' => 'Skinny Jeans Wanita',
                'kategori_id' => 6,
                'min_stok' => 5,
                'stok_final' => 25,
                'harga_beli' => 135000,
                'harga_jual' => 199000,
                'deskripsi' => 'Jeans wanita dengan potongan skinny'
            ],

            // Rok/Skirt
            [
                'nama_barang' => 'Rok A-Line Midi',
                'kategori_id' => 7,
                'min_stok' => 5,
                'stok_final' => 18,
                'harga_beli' => 95000,
                'harga_jual' => 145000,
                'deskripsi' => 'Rok A-Line dengan panjang midi, cocok untuk acara formal'
            ],
            [
                'nama_barang' => 'Rok Plisket',
                'kategori_id' => 7,
                'min_stok' => 4,
                'stok_final' => 15,
                'harga_beli' => 105000,
                'harga_jual' => 155000,
                'deskripsi' => 'Rok plisket elegan untuk berbagai acara'
            ],
        ];

        foreach ($barangData as $data) {
            $kodeBarang = $this->generateKodeBarang();
            Barang::create([
                'kode_barang' => $kodeBarang,
                'foto_barang' => null, // Assuming no photo is provided in the seeder
                'nama_barang' => $data['nama_barang'],
                'kategori_id' => $data['kategori_id'],
                'min_stok' => $data['min_stok'],
                'stok_final' => $data['stok_final'],
                'harga_beli' => $data['harga_beli'],
                'harga_jual' => $data['harga_jual'],
                'deskripsi' => $data['deskripsi']
            ]);
        }
    }

    protected function generateKodeBarang(): string
    {
        // Generate a unique code based on timestamp and random number to avoid duplicates
        $timestamp = now()->format('YmdHis');
        $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $kodeBarang = 'BRG' . $timestamp . $random;

        // Check if code already exists and regenerate if needed
        while (Barang::where('kode_barang', $kodeBarang)->exists()) {
            $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $kodeBarang = 'BRG' . $timestamp . $random;
        }

        return $kodeBarang;
    }
}
