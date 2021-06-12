<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class User extends BaseModel
{
    protected $fillable = [
        'name',
    ];
}
