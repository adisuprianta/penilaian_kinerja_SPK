<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_kriteria', function (Blueprint $table) {
            $table->increments('id_nilai_kriteria');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_karyawan');
            $table->unsignedInteger('id_kriteria');
            $table->integer('nilai_kriteria');
            $table->date('tanggal_nilai');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_kriteria')->references('id_kriteria')->on('kriteria_ahp')
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
        Schema::dropIfExists('nilai_kriteria');
    }
}
