<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_transfer';
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'total_transfer',
        'spp',
        'infaq',
        'status_transfer',
        'id_kode',
        'tanggal_transfer',
        'gambar'
    ];
}
