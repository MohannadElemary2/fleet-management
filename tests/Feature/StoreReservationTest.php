<?php

namespace Tests\Feature;

use App\Enums\SeatNumbers;
use App\Models\City;
use App\Models\Path;
use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreReservationTest extends TestCase
{
    const ROUTE = 'reservations.store';
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
            'POST',
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
            'POST',
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
    public function will_fail_with_validation_errors_seat_is_invalid()
    {
        $this->loginAsUser();

        $response = $this->json(
            'POST',
            route(self::ROUTE),
            [
                'start_city_id'         => 1,
                'destination_city_id'   => 2,
                'seat_number'           => 'invalid-seat',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'seat_number'
                ]
            );
    }

    /**
     * @test
     */
    public function will_fail_if_no_available_trips()
    {
        $this->loginAsUser();

        $cities = $this->prepareTestData();

        $response = $this->json(
            'POST',
            route(self::ROUTE),
            [
                'start_city_id'         => $cities[0]->id,
                'destination_city_id'   => $cities[2]->id,
                'seat_number'           => SeatNumbers::FIFTH_SEAT,
                'trip_id'               => Trip::first()->id,
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function will_fail_if_selected_seat_is_reserved()
    {
        $this->loginAsUser();

        $cities = $this->prepareTestData(11);

        $response = $this->json(
            'POST',
            route(self::ROUTE),
            [
                'start_city_id'         => $cities[0]->id,
                'destination_city_id'   => $cities[2]->id,
                'seat_number'           => SeatNumbers::FIFTH_SEAT,
                'trip_id'               => Trip::first()->id,
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function will_create_reservation_successfully()
    {
        $this->loginAsUser();

        $cities = $this->prepareTestData(11);

        $response = $this->json(
            'POST',
            route(self::ROUTE),
            [
                'start_city_id'         => $cities[0]->id,
                'destination_city_id'   => $cities[2]->id,
                'seat_number'           => SeatNumbers::TWILVTH_SEAT,
                'trip_id'               => Trip::first()->id,
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertArrayHasKey('data', $response->json());
        $this->assertArrayHasKey('seat_number', $response->json()['data']);
        $this->assertArrayHasKey('trip', $response->json()['data']);
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
