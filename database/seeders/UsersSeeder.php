<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'mohannad@robusta.com',
        ], [
            'name'     => 'Mohannad',
            'email'    => 'mohannad@robusta.com',
            'password' => '12345678',
        ]);
    }
}
