<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elevator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'current_floor',
        'direction',
        'signal',
    ];

    /**
     * Get the elevator request associated with the elevator.
     */
    public function elevatorRequests()
    {
        return $this->hasMany(ElevatorRequest::class);
    }

    /**
     * Scope a query to include elevators moving to the given floor.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $floor
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMovingTo($query, int $floor)
    {
        return $query->where(function ($query) {
                $query->where('direction', 'down')
                    ->where('current_floor', '<=', $floor);
            })->orWhere(function ($query) {
                $query->where('direction', 'up')
                    ->where('current_floor', '>=', $floor);
            });
    }

    /**
     * Scope a query to include only standing elevators.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStanding($query)
    {
        return $query->where('direction', 'stand');
    }

    /**
     * Scope a query to only include elevators in the same
     * floor than the given one.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $floor
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhichCurrentLocation($query, int $floor)
    {
        return $query->where('current_floor', $floor);
    }
}
