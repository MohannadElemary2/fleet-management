<?php

use App\Http\Controllers\V1\AuthController;

Route::group(['as' => 'auth.', 'prefix' => 'v1/auth', 'middleware' => ["throttle:5,1"]], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
