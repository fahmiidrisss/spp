<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_kode';

    protected $fillable = [
        'kode_unik',
        'status_kode'
    ];
}
