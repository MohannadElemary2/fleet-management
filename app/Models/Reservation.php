<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Reservation extends BaseModel
{
    protected $fillable = [
        'trip_id',
        'user_id',
        'path_order_start',
        'path_order_end',
        'seat_number',
    ];
}
