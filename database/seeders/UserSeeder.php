<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DateTime;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'Admin',
              'email' => 'admin@gmail.com',
              'password' => Hash::make('admin'),
              'created_at' => (new DateTime()),
              'updated_at' => (new datetime()),
        ]);

        $user->attachRole("manajer");

    }
}
