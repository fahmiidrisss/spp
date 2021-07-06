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
            $table->float('total_transfer');
            $table->float('spp');
            $table->float('infaq');
            $table->string('status_transfer');
            $table->integer('id_admin');
            $table->integer('id_kode');
            $table->timestamp('tanggal_transfer');
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
