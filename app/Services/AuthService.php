<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Resources\Base\FailureResource;
use App\Resources\UserResource;
use App\Services\Base\BaseService;
use App\Traits\HasAuthentications;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    use HasAuthentications;

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Login user and retrieve token from oauth server
     *
     * @param array $data
     * @param ServerRequestInterface $serverRequest
     * @return FailureResource|SuccessResource
     * @author Mohannad Elemary
     */
    public function login($data, $serverRequest)
    {
        // Validating user credintials
        $user = $this->repository->where([
            'email' => $data['email']
        ])->first(['*'], false);

        if (!$user || !Hash::check($data['password'], $user->getAuthPassword())) {
            return abort(
                new FailureResource(
                    [],
                    __('users/messages.invalid_credentials'),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        // Issue Access Token From Oauth Server
        $result = $this->tokenRequest($serverRequest, $data);

        // Validate If token generated successfully
        if ($result['statusCode'] != Response::HTTP_OK) {
            return abort(
                new FailureResource(
                    [],
                    $result['response']['error_description'],
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        return array_merge(
            ["user" => new UserResource($user)],
            $result['response']
        );
    }
}
