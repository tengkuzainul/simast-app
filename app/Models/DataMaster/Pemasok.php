<?php

namespace App\Models\DataMaster;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'tb_pemasok';

    protected $guarded = ['id'];

    protected $fillable = [
        'kode_pemasok',
        'nama_pemasok',
        'alamat',
        'telepon',
    ];
}
