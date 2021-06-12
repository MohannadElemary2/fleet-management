<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Repositories\TripRepository;
use App\Resources\Base\FailureResource;
use App\Services\Base\BaseService;
use Illuminate\Http\Response;

class ReservationService extends BaseService
{
    public function __construct(ReservationRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Validate & Store New Trip Reservation
     * 1) Trip Is Available To Receive New Reservations
     * 2) Chosen Seat is Available To Be Reserved
     *
     * @param array $data
     * @return JsonResource
     * @author Mohannad Elemary
     */
    public function store($data)
    {
        // Get The Trip If Available To Have New Reservations
        $trip = app(TripRepository::class)->getSingleAvailableTrip($data);

        // Check If The Trip Is Available
        if (!$trip) {
            return abort(
                new FailureResource(
                    [],
                    __('reservations/messages.unavailable_trip_to_reserve'),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        // Check If The Chosen Seat Is Available
        if (!$trip->isAvailableForReservations($data['seat_number'])) {
            return abort(
                new FailureResource(
                    [],
                    __('reservations/messages.unavailable_seat_to_reserve'),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        // Create New Reservation
        return $this->repository->store($data, $trip);
    }
}
