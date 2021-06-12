<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }
}
