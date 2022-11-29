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
            $table->string('nama_karyawan',30);
            $table->string('email',100);
            $table->string('no_Hp',13);
            $table->char('jenis_kelamin',1);
            $table->string('alamat',50);
            $table->date('tanggal_kerja');
            $table->string('pendidikan',20);
            $table->date('tanggal_Lahir');
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
