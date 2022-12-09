<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerjaanKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaan_karyawan', function (Blueprint $table) {
            $table->increments('id_pekerjaan');
            $table->unsignedinteger('id_karyawan');
            $table->string("nama_pekerjaan");
            $table->timestamps();
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan_karyawan');
    }
}
