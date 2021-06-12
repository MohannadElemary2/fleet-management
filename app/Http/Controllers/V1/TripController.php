<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\getAvailableTripsRequest;
use App\Resources\Base\SuccessResource;
use App\Resources\TripResource;
use App\Services\TripService;
use Illuminate\Http\Response;

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
     * @return SuccessResource
     * @author Mohannad Elemary
     */
    public function getAvailable(getAvailableTripsRequest $request)
    {
        return new SuccessResource(
            $this->service->getAvailableTripsBetweenTwoCities($request->all()),
            '',
            Response::HTTP_OK
        );
    }
}
