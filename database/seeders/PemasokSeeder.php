<?php

namespace Database\Seeders;

use App\Models\DataMaster\Pemasok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemasoks = [
            ['nama_pemasok' => 'Pemasok A', 'alamat' => 'Alamat A', 'telepon' => '123456789'],
            ['nama_pemasok' => 'Pemasok B', 'alamat' => 'Alamat B', 'telepon' => '987654321'],
            ['nama_pemasok' => 'Pemasok C', 'alamat' => 'Alamat C', 'telepon' => '456789123'],
        ];

        foreach ($pemasoks as $pemasok) {
            Pemasok::create([
                'kode_pemasok' => $this->generateKodePemasok(),
                'nama_pemasok' => $pemasok['nama_pemasok'],
                'alamat' => $pemasok['alamat'],
                'telepon' => $pemasok['telepon'],
            ]);
        }
    }

    protected function generateKodePemasok()
    {
        $lastPemasok = Pemasok::orderBy('kode_pemasok', 'desc')->first();
        if ($lastPemasok) {
            $lastKode = (int) substr($lastPemasok->kode_pemasok, 3);
            $newKode = $lastKode + 1;
            return 'SUP' . str_pad($newKode, 3, '0', STR_PAD_LEFT);
        }
        return 'SUP001';
    }
}
