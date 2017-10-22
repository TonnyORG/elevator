<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Elevator;
use App\ElevatorRequest;

class CreateElevatorRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elevator:createelevatorrequest
        {from : The floor where the elevator was asked for}
        {to : The floor where the guest wants to go}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule a new elevator request.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return \Integer
     */
    public function handle()
    {
        $from = intval($this->argument('from'));
        $to = intval($this->argument('to'));

        $elevatorRequest = ElevatorRequest::create([
            'from' => $from,
            'to' => $to,
        ]);

        $elevatorRequest->associate(
                $this->findBestElevator($from, $to)
            )->save();

        return $elevatorRequest->id;
    }

    /**
     * [findBestElevator description]
     *
     * @param  \Integer $from
     * @param  \Integer $to
     * @return \App\Elevator
     */
    protected function findBestElevator($from, $to)
    {
        $direction = $from > $to ? 'down' : 'up';

        $elevator = Elevator::whichCurrentLocation($from)->first();
        if ($elevator) {
            return $elevator;
        }

        $elevator = Elevator::movingTo($from)->first();
        if ($elevator) {
            return $elevator;
        }

        $elevator = Elevator::standing()->first();
        if ($elevator) {
            return $elevator;
        }

        return Elevator::first();
    }
}
