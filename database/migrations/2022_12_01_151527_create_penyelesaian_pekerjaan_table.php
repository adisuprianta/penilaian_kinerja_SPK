<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyelesaianPekerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyelesaian_pekerjaan', function (Blueprint $table) {
            $table->increments('id_penyelesaian_pekerjaan');
            $table->unsignedinteger('id_karyawan');
            $table->unsignedinteger('id_pekerjaan');
            $table->date('tanggal_kerja');
            $table->char('status',1);
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')
            ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('penyelesaian_pekerjaan');
    }
}
