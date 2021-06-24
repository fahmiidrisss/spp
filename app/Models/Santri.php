<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'nis';

    protected $fillable = [
        'nis',
        'nama_santri',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'nama_wali',
        'jenis_kelamin',
        'subsidi',
        'jumlah_tunggakan',
        'id_kelas'
    ];
}
