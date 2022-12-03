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
            $table->unsignedInteger('id_pangkat');
            $table->string('nama_karyawan',30);
            $table->string('email',100);
            $table->string('no_hp',13);
            $table->char('jenis_kelamin',1);
            $table->string('alamat',200);
            // $table->date('tanggal_kerja');
            $table->date('tanggal_lahir');
            // $table->string('status',200);
            // $table->string('nama_berkas_kontrak',200);
            $table->timestamps();
            $table->foreign('id_pangkat')->references('id_pangkat_karyawan')->on('pangkat_karyawan')
            ->onUpdate('cascade')->onDelete('cascade');
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
