<?php

namespace Database\Seeders;

use App\Models\Pangkat_karyawan;
use Illuminate\Database\Seeder;
use DateTime;
class PangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pangkat_karyawan::insert([
        [
            'nama_pangkat' => 'Team Leader',
            'created_at' => (new DateTime()),
            'updated_at' => (new datetime()),
        ],
        [
            'nama_pangkat' => 'Karyawan',
            'created_at' => (new DateTime()),
            'updated_at' => (new datetime()),
        ]
        ]);
    }
}
