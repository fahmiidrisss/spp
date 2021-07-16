<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->string('nis');
            $table->integer('total_bayar');
            $table->integer('spp');
            $table->integer('infaq');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->string('status_transaksi')->nullable();
            $table->integer('id_admin');
            $table->date('tanggal_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
