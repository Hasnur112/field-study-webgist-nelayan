<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanNelayan extends Model
{
    protected $fillable = ['nama_pelapor', 'latitude', 'longitude', 'kategori_zona', 'keterangan'];
}
