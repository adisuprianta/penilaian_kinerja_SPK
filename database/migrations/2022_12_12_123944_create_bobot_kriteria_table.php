<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBobotKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->increments('id_bobot_kriteria');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_nilai_kriteria');
            $table->decimal('bobot_kriteria',18,4);
            $table->date('tanggal_bobot');
            $table->foreign('id_nilai_kriteria')->references('id_nilai_kriteria')->on('nilai_kriteria')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')
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
        Schema::dropIfExists('bobot_kriteria');
    }
}
