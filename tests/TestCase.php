<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const USER_AUTH_GUARD = 'api';

    public function prepareDatabase()
    {
        $this->artisan('migrate');

        $this->artisan('passport:client', ['--password' => null, '--no-interaction' => true, '--provider' => 'users']);
        $this->artisan('passport:keys', ['--no-interaction' => true]);
    }

    /**
     * Login As a User
     *
     * @return void
     * @author Mohannad Elemary
     */
    public function loginAsUser($user = null)
    {
        if (!$user) {
            $user = $this->createUser();
        }
        $this->actingAs($user, self::USER_AUTH_GUARD);
    }

    /**
     * Create tenant user
     *
     * @return User
     * @author Mohannad Elemary
     */
    public function createUser($overrides = [])
    {
        return User::factory()->create($overrides);
    }
}
