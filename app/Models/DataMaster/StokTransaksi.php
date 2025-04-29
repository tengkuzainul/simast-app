<?php

namespace App\Models\DataMaster;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StokTransaksi extends Model
{
    protected $table = 'tb_stok_transaksi';

    protected $guarded = ['id'];

    protected $fillable = [
        'kode_transaksi',
        'barang_id',
        'pemasok_id',
        'user_id',
        'tipe_transaksi',
        'jumlah',
        'status_transaksi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
