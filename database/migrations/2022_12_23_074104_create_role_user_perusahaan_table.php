<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserPerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user_perusahaan', function (Blueprint $table) {
            $table->unsignedInteger('id_perusahaan');
            $table->unsignedBigInteger('user_id');
            

            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan_partner')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id','id_perusahaan' ]);
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
        Schema::dropIfExists('role_user_perusahaan');
    }
}
