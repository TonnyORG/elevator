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
}
