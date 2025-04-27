<?php

namespace App\Models\DataMaster;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'tb_kategori';

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'id');
    }
}
