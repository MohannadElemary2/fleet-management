<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Path extends BaseModel
{
    protected $fillable = [
        'trip_id',
        'start_city_id',
        'destination_city_id',
        'order',
    ];
}
