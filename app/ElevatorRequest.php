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
        'form',
        'to',
    ];

}
