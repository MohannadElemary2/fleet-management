<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\LoginRequest;
use App\Resources\Base\FailureResource;
use App\Resources\Base\SuccessResource;
use App\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends BaseController
{
    protected $resource = UserResource::class;

    public function __construct(AuthService $service)
    {
        parent::__construct($service);
    }

    /**
     * Login admin and retrieve token from oauth server
     *
     * @param  LoginRequest $request
     * @param  ServerRequestInterface $serverRequest
     * @return FailureResource|SuccessResource
     * @author Mohannad Elemary
     */
    public function login(LoginRequest $request, ServerRequestInterface $serverRequest)
    {
        $data = $this->service->login($request->all(), $serverRequest);

        return new SuccessResource(
            $data,
            __('users/messages.success_login'),
            Response::HTTP_OK,
            $data
        );
    }
}
