<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\BaseRequest;

class getAvailableTripsRequest extends BaseRequest
{
    protected $validations = [
        'start_city_id.required',
        'start_city_id.exists',
        'destination_city_id.required',
        'destination_city_id.exists',
        'destination_city_id.different',
    ];

    protected $label  = 'trips';

    public function rules()
    {
        return [
            'start_city_id'         => 'required|exists:cities,id',
            'destination_city_id'   => 'required|exists:cities,id|different:start_city_id',
        ];
    }
}
