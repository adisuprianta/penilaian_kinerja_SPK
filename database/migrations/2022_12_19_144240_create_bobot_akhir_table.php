<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBobotAkhirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bobot_akhir', function (Blueprint $table) {
            $table->increments('id_bobot_akhir');
            $table->unsignedInteger('id_karyawan');
            $table->unsignedBigInteger('id_user');
            $table->decimal('bobot_akhir',18,4);
            $table->date('tanggal_bobot');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')
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
        Schema::dropIfExists('bobot_akhir');
    }
}
