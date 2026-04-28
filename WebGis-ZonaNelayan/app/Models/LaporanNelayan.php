<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanNelayan extends Model
{
    protected $fillable = ['user_id', 'latitude', 'longitude', 'kategori_zona', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
