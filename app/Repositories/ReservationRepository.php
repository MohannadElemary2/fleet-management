<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\Base\BaseRepository;

class ReservationRepository extends BaseRepository
{
    public function model()
    {
        return Reservation::class;
    }

    /**
     * Store a New Reservation In a Trip Between Two Cities
     *
     * @param array $data
     * @param Trip $trip
     * @return Reservation
     * @author Mohannad Elemary
     */
    public function store($data, $trip)
    {
        return $this->create([
            'user_id'           => auth()->id(),
            'trip_id'           => $data['trip_id'],
            'path_order_start'  => $trip->start_path_order,
            'path_order_end'    => $trip->destination_path_order,
            'seat_number'       => $data['seat_number'],
        ]);
    }
}
