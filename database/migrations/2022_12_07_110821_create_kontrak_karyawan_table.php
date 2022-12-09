<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrakKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrak_karyawan', function (Blueprint $table) {
            $table->increments('id_kontrak');
            $table->unsignedinteger('id_karyawan');
            $table->date('tanggal_masuk');
            $table->date('tanggal_kerja');
            $table->string('Berkas_kontrak');
            $table->char('status',1);
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('kontrak_karyawan');
    }
}
