<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Passport\Client;
use Tests\TestCase;

class LoginTest extends TestCase
{
    const ROUTE_LOGIN = 'auth.login';
    public $mockConsoleOutput = false;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->artisan('passport:client', ['--password' => null, '--no-interaction' => true, '--provider' => 'users']);
        $this->artisan('passport:keys', ['--no-interaction' => true]);
    }

    /**
     * @test
     */
    public function will_fail_with_validation_errors_when_email_is_missing()
    {
        $response = $this->json(
            'POST',
            route(self::ROUTE_LOGIN),
            [
                'password' => 'password',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'email'
                ]
            );
    }

    /**
     * @test
     */
    public function will_fail_with_validation_errors_when_password_is_missing()
    {
        $response = $this->json(
            'POST',
            route(self::ROUTE_LOGIN),
            [
                'email' => 'john.doe@email.com',
                'password' => '',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'password'
                ]
            );
    }

    /**
     * @test
     */
    public function will_fail_with_incorrect_credentials()
    {
        $user = User::factory()->create();
        $oauthClient = $this->getOauthClient();

        $response = $this->json(
            'POST',
            route(self::ROUTE_LOGIN),
            [
                'email' => $user->email,
                'password' => 'invalid-password',
                'client_id' => $oauthClient->id,
                'client_secret' => $oauthClient->secret,
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function will_login_successfully_with_correct_credentials()
    {
        $user = User::factory()->create();
        $oauthClient = $this->getOauthClient();

        $response = $this->json(
            'POST',
            route(self::ROUTE_LOGIN),
            [
                'email' => $user->email,
                'password' => 'pa$$W0rD',
                'client_id' => $oauthClient->id,
                'client_secret' => $oauthClient->secret,
            ]
        );

        $response->assertStatus(Response::HTTP_OK);

        $this->assertArrayHasKey('access_token', $response->json()['data']);
        $this->assertArrayHasKey('refresh_token', $response->json()['data']);
        $this->assertArrayHasKey('user', $response->json()['data']);
    }

    private function getOauthClient()
    {
        return Client::first();
    }
}
