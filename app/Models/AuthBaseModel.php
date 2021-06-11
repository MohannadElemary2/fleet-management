<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class AuthBaseModel extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens;

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Auto Hashing Passwords
     *
     * @return void
     * @author Mohannad Elemary
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value ? bcrypt($value) : null;
    }
}
