<?php

namespace App\Models;

use App\Models\Base\AuthBaseModel;

class User extends AuthBaseModel
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
