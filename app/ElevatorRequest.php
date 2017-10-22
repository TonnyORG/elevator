<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElevatorRequest extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completed',
        'elevator_id',
        'from',
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
     * Scope a query to only include completed elevator
     * requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', 1);
    }

    /**
     * Scope a query to only include incomplete elevator
     * requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed', 0);
    }

    /**
     * Scope a query to only include incomplete elevator
     * requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $floor
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncompleteForFloor($query, int $floor)
    {
        return self::scopeIncomplete($query)
            ->where('to', $floor);
    }

    /**
     * Scope a query to only include elevator requests
     * that haven't even started.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotEvenStarted($query)
    {
        return $query->where('started', 0);
    }

    /**
     * Scope a query to only include elevator requests
     * that haven't even started for the given floor.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $floor
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotEvenStartedForFloor($query, int $floor)
    {
        return self::scopeNotEvenStarted($query)
            ->where('from', $floor);
    }

    /**
     * Scope a query to only include pending elevator
     * requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('completed', 0)
            ->orWhere('started', 0);
    }

    /**
     * Scope a query to only include pending elevator
     * requests for the given floor.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $floor
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendingForFloor($query, int $floor)
    {
        return $query->where(function ($query) use ($floor) {
                $query->where('completed', 0)
                    ->where('to', $floor);
            })->orWhere(function ($query) use ($floor) {
                $query->where('started', 0)
                    ->where('from', $floor);
            });
    }
}
