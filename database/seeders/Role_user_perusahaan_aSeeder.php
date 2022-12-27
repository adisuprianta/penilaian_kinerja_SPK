<?php

namespace Database\Seeders;

use App\Models\role_user_perusahaan;
use DateTime;
use Illuminate\Database\Seeder;

class Role_user_perusahaan_aSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        role_user_perusahaan::insert([[
            'id_perusahaan' =>1,
            'user_id'=>2,
            'created_at' => (new DateTime()),
            'updated_at' => (new datetime()),
        ],
        [
            'id_perusahaan' =>1,
            'user_id'=>3,
            'created_at' => (new DateTime()),
              'updated_at' => (new datetime()),
        ]
        ]);
    }
}
