<?php

namespace App\Models\DataMaster;

use Illuminate\Database\Eloquent\Model;

class StokTransaksi extends Model
{
    protected $table = 'tb_stok_transaksi';

    protected $guarded = ['id'];

    protected $fillable = [
        'barang_id',
        'tipe_transaksi',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
