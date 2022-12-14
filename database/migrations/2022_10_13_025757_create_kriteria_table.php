<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria_ahp', function (Blueprint $table) {
            $table->increments('id_kriteria');
            $table->unsignedInteger('id_pangkat');
            $table->string('nama_kriteria',20);
            $table->decimal('bobot_kriteria', 18,4);
            $table->integer('nilai_perbandingan_kriteria');
            $table->char('golongan',1);
            $table->timestamps();
            $table->foreign('id_pangkat')->references('id_pangkat_karyawan')->on('pangkat_karyawan')->onUpdate('cascade')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriteria');
    }
}
