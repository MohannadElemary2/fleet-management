<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\ReservationController;
use App\Http\Controllers\V1\TripController;

Route::group(['as' => 'auth.', 'prefix' => 'v1/auth', 'middleware' => ["throttle:5,1"]], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['as' => 'trips.', 'prefix' => 'v1/trips', 'middleware' => ["auth:api"]], function () {
    Route::get('/get-available', [TripController::class, 'getAvailable'])->name('getAvailable');
});

Route::group(['as' => 'reservations.', 'prefix' => 'v1/reservations', 'middleware' => ["auth:api"]], function () {
    Route::post('/', [ReservationController::class, 'store'])->name('store');
});
