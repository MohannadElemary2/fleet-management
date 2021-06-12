<?php

namespace App\Models;

use App\Enums\SeatNumbers;
use App\Models\Base\BaseModel;

class Trip extends BaseModel
{
    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'reserved_seats',
        'available_seats',
    ];

    /**
     * Every Trip Has Many Paths "in-between cities" That Crosses It
     *
     * @return HasMany
     * @author Mohannad Elemary
     */
    public function paths()
    {
        return $this->hasMany(Path::class, 'trip_id');
    }

    /**
     * Every Trip Has Many Reservations
     *
     * @return HasMany
     * @author Mohannad Elemary
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'trip_id');
    }

    /**
     * Get Reserved Seats In Trip Between Two Cities
     *
     * @return array
     * @author Mohannad Elemary
     */
    public function getReservedSeatsAttribute()
    {
        return $this
        ->reservations
        ->where('path_order_start', '<=', $this->destination_path_order)
        ->where('path_order_end', '>=', $this->start_path_order)
        ->pluck('seat_number')
        ->ToArray();
    }

    /**
     * Get Available Seats In Trip Between Two Cities
     *
     * @return array
     * @author Mohannad Elemary
     */
    public function getAvailableSeatsAttribute()
    {
        return array_diff(
            SeatNumbers::getValues(),
            $this->reserved_seats
        );
    }

    /**
     * Get Trips That Contains A Path Between Specific Two Cities
     *
     * @param Builder $query
     * @param array $data
     * @return Builder
     * @author Mohannad Elemary
     */
    public function scopeHasCitiesInItsPath($query, $data)
    {
        return $query
            ->whereHas('paths', function ($q) use ($data) {
                $q->where('start_city_id', $data['start_city_id']);
            })
            ->whereHas('paths', function ($q) use ($data) {
                $q->where('destination_city_id', $data['destination_city_id']);
            });
    }

    /**
     * Get Trips That Contains Available Seats Between Two Cities In Its Path
     *
     * @param Builder $query
     * @return Builder
     * @author Mohannad Elemary
     */
    public function scopeHasAvailableSeatsBetweenCities($query)
    {
        return $query
            ->withCount(['reservations' => function ($q) {
                $q->whereColumn('reservations.path_order_start', '<=', 'destination_path.order')
                ->whereColumn('reservations.path_order_end', '>=', 'start_path.order');
            }])
            ->groupBy(['reservations_count', 'trips.id', 'trips.name', 'start_path.order', 'destination_path.order'])
            ->having('reservations_count', '<', 12);
    }
}
