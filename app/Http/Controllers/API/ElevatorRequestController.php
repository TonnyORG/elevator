<?php

namespace App\Http\Controllers\API;

use Artisan;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Rules\ActiveFloor as ActiveFloorValidator;

class ElevatorRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'from' => [
                'required',
                'integer',
                'different:to',
                new ActiveFloorValidator,
            ],
            'to' => [
                'required',
                'integer',
                'different:from',
                new ActiveFloorValidator,
            ],
        ]);

        $elevatorRequestId = Artisan::call('elevator:createelevatorrequest', [
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        ]);

        return response()->json([], $elevatorRequestId ? 200 : 500);
    }
}
