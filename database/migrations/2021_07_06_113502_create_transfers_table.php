<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id_transfer');
            $table->string('nis');
            $table->integer('total_transfer');
            $table->integer('spp');
            $table->integer('infaq');
            $table->string('status_transfer')->nullable();
            $table->integer('id_admin');
            $table->integer('id_kode');
            $table->date('tanggal_transfer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
