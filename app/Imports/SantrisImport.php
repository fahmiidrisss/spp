<?php

namespace App\Imports;

use App\Models\Santri;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class SantrisImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $user = new User([
        //     'username'      => $row[0],
        //     'role'          => "Santri",
        //     'password'      => Hash::make($row[0]."123"),
        // ]);
        // $user->save();

        return new Santri([
            'nis'           => $row[0],
            'nama_santri'   => $row[1],
            'tanggal_lahir' => $row[2],
            'alamat'        => $row[3],
            'no_hp'         => $row[4],
            'jenis_kelamin' => $row[5],
            'nama_wali'     => $row[6],
            'subsidi'       => $row[7],
            'jumlah_tunggakan'=> $row[8],
            'id_kelas'      => $row[9]
        ]);
    }
}
