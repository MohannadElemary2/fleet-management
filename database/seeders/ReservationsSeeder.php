<?php

namespace Database\Seeders;

use App\Enums\SeatNumbers;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Reservation::firstOrCreate([
            'trip_id' => 1,
            'user_id' => 1,
            'path_order_start'      => 2,
            'path_order_end'        => 3,
        ], [
            'seat_number'           => SeatNumbers::FIRST_SEAT,
        ]);

        Reservation::firstOrCreate([
            'trip_id' => 1,
            'user_id' => 1,
            'path_order_start'      => 3,
            'path_order_end'        => 4,
        ], [
            'seat_number'           => SeatNumbers::TENTH_SEAT,
        ]);
    }
}
