<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilai_karyawan', function (Blueprint $table) {
            $table->increments('id_penilai_karyawan');
            $table->unsignedinteger('id_karyawan');
            $table->unsignedBiginteger('id_user');
            $table->date('tanggal_penilaian');
            $table->foreign('id_user')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            // ini di hapus dimasukan ke tabel nilai saja baik nilai kriteria utama atau nilai sub kriteria
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilai_karyawan');
    }
}
