<?php

namespace App\Http\Requests;

use App\Enums\SeatNumbers;
use App\Http\Requests\Base\BaseRequest;
use BenSampo\Enum\Rules\EnumValue;

class StoreReservationRequest extends BaseRequest
{
    protected $validations = [
        'start_city_id.required',
        'start_city_id.exists',
        'destination_city_id.required',
        'destination_city_id.exists',
        'destination_city_id.different',
        'seat_number.required',
        'seat_number.in',
        'trip_id.required',
        'trip_id.exists',
    ];

    protected $label  = 'reservations';

    public function rules()
    {
        return [
            'start_city_id'         => 'required|exists:cities,id',
            'destination_city_id'   => 'required|exists:cities,id|different:start_city_id',
            'seat_number'           => ['required', new EnumValue(SeatNumbers::class, false)],
            'trip_id'               => 'required|exists:trips,id',
        ];
    }
}
