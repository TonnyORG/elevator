<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Elevator;
use App\Jobs\ProcessElevatorRequests as ProcessElevatorRequestsJob;

class ProcessElevatorRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elevator:processelevatorrequests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the elevator requests for each elevator.';

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
     * @return mixed
     */
    public function handle()
    {
        foreach (Elevator::all() as $elevator) {
            ProcessElevatorRequestsJob::dispatch($elevator);
        }
    }
}
