<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Notifikasi extends Model
{
    protected $table = 'tb_notifikasi';

    protected $fillable = [
        'title',
        'message',
        'status',
        'target_role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
