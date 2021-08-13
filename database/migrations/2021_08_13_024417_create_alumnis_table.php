<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->string('nis')->unique();
            $table->string('nama_santri', 100);
            $table->date('tanggal_lahir');
            $table->string('alamat', 100);
            $table->string('no_hp', 13);
            $table->string('jenis_kelamin', 2);
            $table->string('nama_wali', 50);
            $table->integer('subsidi');
            $table->integer('jumlah_tunggakan');
            $table->integer('id_kelas');
            $table->integer('tahun_keluar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnis');
    }
}
