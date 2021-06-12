<?php

namespace App\Repositories;

use App\Enums\AppSettings;
use App\Models\Trip;
use App\Repositories\Base\BaseRepository;

class TripRepository extends BaseRepository
{
    public function model()
    {
        return Trip::class;
    }

    /**
     * Get Available Trips Between Two Given Cities
     *
     * @param array $data
     * @return Collection
     * @author Mohannad Elemary
     */
    public function getAvailableTripsBetweenTwoCities($data)
    {
        $trips = $this
        ->findAvailableTrips($data)
        ->with(['reservations'])
        ->paginate(AppSettings::PAGE_SIZE);

        return $trips;
    }

    /**
     * Get Available Trips Between Two Given Cities
     *
     * @param array $data
     * @return Collection
     * @author Mohannad Elemary
     */
    public function getSingleAvailableTrip($data)
    {
        $trip = $this
        ->findAvailableTrips($data)
        ->where(['trips.id' => $data['trip_id']])
        ->first([
            'trips.id as id',
            'trips.name as name',
            'start_path.order as start_path_order',
            'destination_path.order as destination_path_order',
        ], false);

        return $trip;
    }

    /**
     * Query To Get Available Trips To Make A Reservation
     *
     * @param array $data
     * @return self
     * @author Mohannad Elemary
     */
    private function findAvailableTrips($data)
    {
        return $this
        ->scope('hasCitiesInItsPath', $data)
        ->join('paths as start_path', function ($startJoinQuery) use ($data) {
            $startJoinQuery->on('start_path.trip_id', '=', 'trips.id')
            ->where('start_path.start_city_id', '=', $data['start_city_id']);
        })
        ->join('paths as destination_path', function ($startJoinQuery) use ($data) {
            $startJoinQuery->on('destination_path.trip_id', '=', 'trips.id')
            ->where('destination_path.destination_city_id', '=', $data['destination_city_id']);
        })
        ->select([
            'trips.id as id',
            'trips.name as name',
            'start_path.order as start_path_order',
            'destination_path.order as destination_path_order',
        ])
        ->scope('hasAvailableSeatsBetweenCities');
    }
}
