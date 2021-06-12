<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\getAvailableTripsRequest;
use App\Resources\TripResource;
use App\Services\TripService;

class TripController extends BaseController
{
    protected $resource = TripResource::class;

    public function __construct(TripService $service)
    {
        parent::__construct($service);
    }

    /**
     * Get Available Trips Between Two Given Cities
     *
     * @param getAvailableTripsRequest $request
     * @return JsonResource
     * @author Mohannad Elemary
     */
    public function getAvailable(getAvailableTripsRequest $request)
    {
        return $this->service->getAvailableTripsBetweenTwoCities($request->all());
    }
}
