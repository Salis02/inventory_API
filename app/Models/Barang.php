<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'stok',
        'lokasi_rak'
    ];
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
