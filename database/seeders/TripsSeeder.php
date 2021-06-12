<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Path;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Get Cities IDs for trip 1
        $cairoCity = City::where('name', 'Cairo')->first();
        $faiyumCity = City::where('name', 'Faiyum')->first();
        $minyaCity = City::where('name', 'Minya')->first();
        $asyutCity = City::where('name', 'Asyut')->first();

        // Get Cities IDs for trip 2
        $damiettaCity = City::where('name', 'Damietta')->first();
        $beheiraCity = City::where('name', 'Beheira')->first();
        $alexandriaCity = City::where('name', 'Alexandria')->first();


        // Create the trips
        $trip1 = Trip::firstOrCreate(['name' => 'Cairo-Asyut']);
        $trip2 = Trip::firstOrCreate(['name' => 'Cairo-Alexandria']);

        // Create the trips paths
        $trip1Paths = [
            [
                'trip_id'                   => $trip1->id,
                'order'                     => 1,
                'start_city_id'             => $cairoCity->id,
                'destination_city_id'       => $faiyumCity->id,
            ],
            [
                'trip_id'                   => $trip1->id,
                'order'                     => 2,
                'start_city_id'             => $faiyumCity->id,
                'destination_city_id'       => $minyaCity->id,
            ],
            [
                'trip_id'                   => $trip1->id,
                'order'                     => 3,
                'start_city_id'             => $minyaCity->id,
                'destination_city_id'       => $asyutCity->id,
            ],
            [
                'trip_id'                   => $trip1->id,
                'order'                     => 4,
                'start_city_id'             => $asyutCity->id,
                'destination_city_id'       => $alexandriaCity->id,
            ],

        ];

        $trip2Paths = [
            [
                'trip_id'                   => $trip2->id,
                'order'                     => 1,
                'start_city_id'             => $cairoCity->id,
                'destination_city_id'       => $damiettaCity->id,
            ],
            [
                'trip_id'                   => $trip2->id,
                'order'                     => 2,
                'start_city_id'             => $damiettaCity->id,
                'destination_city_id'       => $beheiraCity->id,
            ],
            [
                'trip_id'                   => $trip2->id,
                'order'                     => 3,
                'start_city_id'             => $beheiraCity->id,
                'destination_city_id'       => $alexandriaCity->id,
            ]
        ];

        foreach ($trip1Paths as $path) {
            $this->createTripPathInDatabase($path);
        }

        foreach ($trip2Paths as $path) {
            $this->createTripPathInDatabase($path);
        }
    }

    /**
     * Create Predefined Trips Paths
     *
     * @param array $path
     * @return void
     * @author Mohannad Elemary
     */
    private function createTripPathInDatabase($path)
    {
        Path::firstOrCreate(
            [
                'trip_id'   => $path['trip_id'],
                'order'     => $path['order']
            ],
            [
                'start_city_id'         => $path['start_city_id'],
                'destination_city_id'   => $path['destination_city_id']
            ]
        );
    }
}
