<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\BaseRequest;

class LoginRequest extends BaseRequest
{
    protected $validations = [
        'email.required',
        'email.email',
        'password.required',
        'client_id.required',
        'client_secret.required',
    ];

    protected $label  = 'users';

    public function rules()
    {
        return [
            'email'     => 'required|email',
            'password'  => 'required',
            'client_id'  => 'required',
            'client_secret'  => 'required',
        ];
    }
}
