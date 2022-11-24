<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id_karyawan');
            $table->string('Nama_karyawan',30);
            $table->string('Email',100);
            $table->string('No_Hp',13);
            $table->char('jekel',1);
            $table->string('Alamat',50);
            $table->date('Tanggal_kerja');
            $table->string('Pendidikan',20);
            $table->date('Tanggal_Lahir');
            $table->string('status',200);
            $table->string('nama_berkas',200);
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
        Schema::dropIfExists('karyawan');
    }
}
