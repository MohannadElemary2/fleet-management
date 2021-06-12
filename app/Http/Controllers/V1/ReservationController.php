<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreReservationRequest;
use App\Resources\ReservationResource;
use App\Services\ReservationService;

class ReservationController extends BaseController
{
    protected $resource = ReservationResource::class;
    protected $storeRequestFile = StoreReservationRequest::class;

    public function __construct(ReservationService $service)
    {
        parent::__construct($service);
    }
}
