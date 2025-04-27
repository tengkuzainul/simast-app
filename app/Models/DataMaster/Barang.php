<?php

namespace App\Models\DataMaster;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tb_barang';

    protected $guarded = ['id'];

    protected $fillable = [
        'kode_barang',
        'foto_barang',
        'nama_barang',
        'kategori_id',
        'min_stok',
        'stok_final',
        'harga_beli',
        'harga_jual',
        'deskripsi'
    ];

    public function stokTransaksi()
    {
        return $this->hasMany(StokTransaksi::class, 'barang_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
