<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_transfer';

    protected $fillable = [
        'nis',
        'total_transfer',
        'spp',
        'infaq',
        'status_transfer',
        'id_admin',
        'id_kode',
        'updated_at',
        'created_at',
        'gambar'
    ];
}
