<?php

namespace App\Traits;

use Laravel\Passport\Http\Controllers\AccessTokenController;

trait HasAuthentications
{
    /**
     * Issue New token or refresh the current one
     *
     * @param $serverRequest
     * @param array $data
     * @param boolean $refresh
     * @return void
     * @author Mohannad Elemary
     */
    public function tokenRequest($serverRequest, array $data, $refresh = false)
    {
        if ($refresh) {
            $body = $this->getAuthTokenBodyRefreshRequest($data);
        } else {
            $body = $this->getAuthTokenBodyRequest($data);
        }

        $request = $serverRequest->withParsedBody($body);
        $response =  app(AccessTokenController::class)->issueToken($request);
        $data['statusCode'] = $response->getStatusCode();
        $data['response'] =  json_decode((string) $response->getContent(), true);
        return $data;
    }

    /**
     * Prepare the body of the oauth request
     *
     * @param array $data
     * @return void
     * @author Mohannad Elemary
     */
    public function getAuthTokenBodyRequest(array $data)
    {
        return  [
            'grant_type' => 'password',
            'client_id'     => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '*'
          ];
    }

    /**
     * Prepare the body of the refresh oauth request
     *
     * @param array $data
     * @author Mohannad Elemary
     */
    public function getAuthTokenBodyRefreshRequest(array $data)
    {
        return  [
            'grant_type' => 'refresh_token',
            'client_id'     => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'refresh_token' => $data['refresh_token'],
            'scope' => '*'
          ];
    }
}
