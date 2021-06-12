<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"            => $this->id,
            "seat_number"   => $this->seat_number,
            "trip"          => new TripShortDetailsResource($this->trip),
        ];
    }
}
