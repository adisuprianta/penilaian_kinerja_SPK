<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karyawan')->insert([
            'nama_karyawan' => "adi",
            'id_pangkat'=>"2",
            'email' => 'adisuprianta@gmai.com',
            'no_hp' => '081936124448',
            'jenis_kelamin'=> 'L',
            'id_perusahaan'=>'1',
            'alamat'=>'surabaya',
            'tanggal_lahir'=> '2001-01-01',
            'created_at' => (new DateTime()),
            'updated_at' => (new DateTime()),

        ]);
    }
}
