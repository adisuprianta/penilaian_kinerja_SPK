<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiSubKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_sub_kriteria', function (Blueprint $table) {
            $table->increments('id_nilai_sub_kriteria');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_karyawan');
            $table->unsignedInteger('id_sub_kriteria');
            $table->integer('nilai_sub_kriteria');
            $table->date('tanggal_nilai');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_sub_kriteria')->references('id_sub_kriteria')->on('sub_kriteria_ahp')
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
        Schema::dropIfExists('nilai_sub_kriteria');
    }
}
