<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Elevator;
use App\Http\Controllers\Controller;

class ElevatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Elevator::all());
    }
}
