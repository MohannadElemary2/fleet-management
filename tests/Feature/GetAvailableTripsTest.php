<?php

namespace Tests\Feature;

use App\Enums\SeatNumbers;
use App\Models\City;
use App\Models\Path;
use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetAvailableTripsTest extends TestCase
{
    const ROUTE = 'trips.getAvailable';
    public $mockConsoleOutput = false;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->prepareDatabase();
    }

    /**
     * @test
     */
    public function will_fail_if_not_authenticated_user()
    {
        $response = $this->json(
            'GET',
            route(self::ROUTE),
            []
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function will_fail_with_validation_errors_when_destination_city_is_missing()
    {
        $this->loginAsUser();

        $response = $this->json(
            'GET',
            route(self::ROUTE),
            [
                'start_city_id' => 'city',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'destination_city_id'
                ]
            );
    }

    /**
     * @test
     */
    public function will_fail_with_validation_errors_when_destination_and_start_city_are_equal()
    {
        $this->loginAsUser();

        $response = $this->json(
            'GET',
            route(self::ROUTE),
            [
                'start_city_id'         => 1,
                'destination_city_id'   => 1,
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'destination_city_id'
                ]
            );
    }

    /**
     * @test
     */
    public function will_get_empty_trips_if_no_available_seats()
    {
        $this->loginAsUser();

        $cities = $this->prepareTestData();

        $response = $this->json(
            'GET',
            route(self::ROUTE),
            [
                'start_city_id'         => $cities[0]->id,
                'destination_city_id'   => $cities[2]->id,
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEmpty($response->json()['data']);
    }

    /**
     * @test
     */
    public function will_get_trip_if_has_available_seats()
    {
        $this->loginAsUser();

        $cities = $this->prepareTestData(11);

        $response = $this->json(
            'GET',
            route(self::ROUTE),
            [
                'start_city_id'         => $cities[0]->id,
                'destination_city_id'   => $cities[2]->id,
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotEmpty($response->json()['data']);
        $this->assertCount(1, $response->json()['data']);
    }

    private function prepareTestData($reservationCount = 12)
    {
        $cities = City::factory()->count(3)->create();

        $trip  = Trip::factory()->create();

        Path::factory()->create([
            'trip_id' => $trip->id,
            'start_city_id' => $cities[0]->id,
            'destination_city_id' => $cities[1]->id,
            'order' => 1,
        ]);
        Path::factory()->create([
            'trip_id' => $trip->id,
            'start_city_id' => $cities[1]->id,
            'destination_city_id' => $cities[2]->id,
            'order' => 2,
        ]);

        $seats = SeatNumbers::getValues();

        foreach ($seats as $key => $seat) {
            if ($key == $reservationCount) {
                break;
            }

            Reservation::factory()->create([
                'trip_id'       => $trip->id,
                'seat_number'   => $seat,
            ]);
        }

        return $cities;
    }
}
