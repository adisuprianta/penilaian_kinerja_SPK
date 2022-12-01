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
            $table->unsignedinteger('id_karyawan');
            $table->unsignedinteger('id_pekerjaan');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['id_pekerjaan', 'id_karyawan']);
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
