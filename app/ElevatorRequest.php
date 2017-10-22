<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElevatorRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completed',
        'elevator_id',
        'form',
        'to',
    ];

    /**
     * Get the elevator request associated with the elevator.
     */
    public function elevator()
    {
        return $this->belongsTo(Elevator::class);
    }
}
