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
        'elevator_request_id',
        'signal',
    ];
}
