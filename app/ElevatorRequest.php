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
        'started',
    ];

    /**
     * Get the elevator request associated with the elevator.
     */
    public function elevator()
    {
        return $this->belongsTo(Elevator::class);
    }

    /**
     * Scope a query to only include incomplete elevator
     * requests.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed', 0);
    }

    /**
     * Scope a query to only include elevator requests
     * that haven't even started.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotEvenStarted($query)
    {
        return $query->where('started', 0);
    }
}
