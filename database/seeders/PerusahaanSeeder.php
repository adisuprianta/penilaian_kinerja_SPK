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
        Perusahaan::insert([[
            'nama_perusahaan'=>'BCA',
            'alamat_perusahaan'=>'surabaya, wiyung',
            'kota'=>'surabaya',
            'email_perusahaan'=>'officialbca@gmail.com',
            'nomor_perusahaan'=>'000000000000',
        ],
        [
            'nama_perusahaan'=>'BNI',
            'alamat_perusahaan'=>'denpasar,bali ',
            'kota'=>'denpasar',
            'email_perusahaan'=>'officialbni@gmail.com',
            'nomor_perusahaan'=>'000000000000',      
        ]]);
    }
}
