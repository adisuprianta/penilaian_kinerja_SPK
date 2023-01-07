<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaanPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan_partner', function (Blueprint $table) {
            $table->increments('id_perusahaan');
            $table->string('nama_perusahaan');
            $table->string('kota');
            $table->string('email_perusahaan')->unique();
            $table->string('alamat_perusahaan');
            $table->string('nomor_perusahaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaan_partner');
    }
}
