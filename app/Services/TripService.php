<?php

namespace App\Services;

use App\Repositories\TripRepository;
use App\Services\Base\BaseService;

class TripService extends BaseService
{
    public function __construct(TripRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get Available Trips Between Two Given Cities
     *
     * @param array $data
     * @return JsonResource
     * @author Mohannad Elemary
     */
    public function getAvailableTripsBetweenTwoCities($data)
    {
        $trips = $this->repository->getAvailableTripsBetweenTwoCities($data);

        return $this->repository->resource::collection($trips);
    }
}
