<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PangkatSeeder::class);
        $this->call(PerusahaanSeeder::class);
        $this->call(KaryawanSeeder::class);
        $this->call(Role_user_perusahaan_aSeeder::class);
    }
}
