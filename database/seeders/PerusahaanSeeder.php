<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use Illuminate\Database\Seeder;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perusahaan::insert([
            'nama_perusahaan'=>'BCA',
            'alamat_perusahaan'=>'surabaya',
        ],
        [
            'nama_perusahaan'=>'BNI',
            'alamat_perusahaan'=>'surabaya',      
        ]);
    }
}
