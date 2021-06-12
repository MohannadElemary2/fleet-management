<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        City::firstOrCreate(['name' => 'Alexandria']);
        City::firstOrCreate(['name' => 'Aswan']);
        City::firstOrCreate(['name' => 'Asyut']);
        City::firstOrCreate(['name' => 'Beheira']);
        City::firstOrCreate(['name' => 'Beni Suef']);
        City::firstOrCreate(['name' => 'Cairo']);
        City::firstOrCreate(['name' => 'Dakahlia']);
        City::firstOrCreate(['name' => 'Damietta']);
        City::firstOrCreate(['name' => 'Faiyum']);
        City::firstOrCreate(['name' => 'Gharbia']);
        City::firstOrCreate(['name' => 'Giza']);
        City::firstOrCreate(['name' => 'Ismailia']);
        City::firstOrCreate(['name' => 'Kafr El Sheikh']);
        City::firstOrCreate(['name' => 'Luxor']);
        City::firstOrCreate(['name' => 'Matruh']);
        City::firstOrCreate(['name' => 'Minya']);
        City::firstOrCreate(['name' => 'Monufia']);
        City::firstOrCreate(['name' => 'New Valley']);
        City::firstOrCreate(['name' => 'North Sinai']);
        City::firstOrCreate(['name' => 'Port Said']);
        City::firstOrCreate(['name' => 'Qalyubia']);
        City::firstOrCreate(['name' => 'Qena']);
        City::firstOrCreate(['name' => 'Red Sea']);
        City::firstOrCreate(['name' => 'Sharqia']);
        City::firstOrCreate(['name' => 'Sohag']);
        City::firstOrCreate(['name' => 'South Sinai']);
        City::firstOrCreate(['name' => 'Suez']);
    }
}
