<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Elevator;

class ProcessElevatorRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The elevator object.
     *
     * @var \App\Elevator
     */
    protected $elevator;

    /**
     * The floors array.
     *
     * @var array
     */
    protected $floors = [];

    /**
     * Create a new job instance.
     *
     * @param \App\Elevator $elevator
     * @return void
     */
    public function __construct(Elevator $elevator)
    {
        $this->elevator = $elevator;
        $this->floors = config('elevator.floors');
        $this->floorsIndexes = array_keys($this->floors);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->elevator->signal === 'open') {
            $this->elevator->signal = 'closed';
            $this->elevator->save();

            return 1;
        }

        $this->deleteUnnaceptableElevatorRequests($this->elevator);

        $elevatorRequestForCurrentFloorCount = $elevator->elevatorRequest()
            ->pendingForFloor($elevator->current_floor)
            ->count();

        $this->handleCurrentFloorElevatorRequests($this->elevator);

        $this->deleteCompletedElevatorRequests($this->elevator);

        if ($elevatorRequestForCurrentFloorCount) {
            $this->elevator->signal = 'open';
            $this->elevator->direction = 'stand';
            $this->elevator->save();

            return 1;
        }

        if (!count($this->elevator->elevatorRequests)) {
            $this->elevator->direction = 'stand';
            $this->elevator->save();

            return 1;
        }

        switch ($this->elevator->direction) {
            case 'down':
                return $this->handleDownDirection($this->elevator, $elevator->current_floor - 1);
                break;

            case 'up':
                return $this->handleUpDirection($this->elevator, $elevator->current_floor + 1);
                break;

            default:
                return $this->handleNextElevatorRequest($this->elevator);
                break;
        }
    }

    /**
     * Delete completed elevator requests.
     *
     * @param  \App\Elevator $elevator
     * @return void
     */
    protected function deleteCompletedElevatorRequests(Elevator $elevator)
    {
        $elevator->elevatorRequest()->completed()->delete();
    }

    /**
     * Delete elevator requests that haven't started yet and the floor
     * from the request doesn't exist anymore or elevator requests that
     * haven't been completed yet and the destination floor doesn't exist
     * anymore. 
     *
     * @param  \App\Elevator $elevator
     * @return void
     */
    protected function deleteUnnaceptableElevatorRequests(Elevator $elevator)
    {
        $minFloor = min($this->floorsIndexes);
        $maxFloor = max($this->floorsIndexes);

        $elvatorEquests = $elevator->elevatorRequests()
            ->pending()
            ->get();

        foreach ($elvatorEquests as $elevatorRequest) {
            if (!$elevatorRequest->started) {
                if ($elevatorRequest->from < $minFloor || $elevatorRequest->from > $maxFloor) {
                    $elevatorRequest->delete();
                }
            }

            if (!$elevatorRequest->completed) {
                if ($elevatorRequest->to < $minFloor || $elevatorRequest->to > $maxFloor) {
                    $elevatorRequest->delete();
                }
            }
        }
    }

    /**
     * Process all the elevator requests for the current floor.
     *
     * @param  \App\Elevator $elevator
     * @return void
     */
    protected function handleCurrentFloorElevatorRequests(Elevator $elevator)
    {
        $currentFloor = $elevator->current_floor;

        $elevator->elevatorRequest()
            ->notEvenStartedForFloor($currentFloor)
            ->update(['started' => 1]);

        $elevator->elevatorRequest()
            ->incompleteForFloor($currentFloor)
            ->update(['completed' => 1]);
    }

    /**
     * Process elevator request when elevator is moving down.
     *
     * @param  \App\Elevator $elevator
     * @param  int
     * @return int
     */
    protected function handleDownDirection(Elevator $elevator, int $nextFloor)
    {
        $minFloor = min($this->floorsIndexes);

        // Prevent "removed" floors from config file
        while ($nextFloor > max($this->floorsIndexes)) {
            $nextFloor--;
        }

        // Prevent "removed" floors from config file,
        // if the floor scheduled doesn't exist anymore
        // just continue with the next elevator request.
        if ($nextFloor < $minFloor) {
            $elevator->current_floor = $minFloor;
            $elevator->save();

            return $this->handleNextElevatorRequest($elevator);
        }

        if (!in_array($nextFloor, $this->floorsIndexes)) {
            return $this->handleDownDirection($elevator, $nextFloor - 1);
        }

        $elevator->current_floor = $nextFloor;
        $elevator->save();

        return 1;
    }

    /**
     * Process elevator request when elevator is standing.
     *
     * @param  \App\Elevator $elevator
     * @return int
     */
    protected function handleNextElevatorRequest(Elevator $elevator)
    {
        $elevatorRequest = $elevator->elevatorRequests()->first();

        if (!$elevatorRequest) {
            $elevator->direction = 'stand';
            $elevator->save();

            return 1;
        }

        if (!$elevatorRequest->started) {
            $elevator->direction = $elevator->current_floor > $elevatorRequest->from ? 'down' : 'up';
        } else {
            $elevator->direction = $elevator->current_floor > $elevatorRequest->to ? 'down' : 'up';
        }

        $elevator->save();

        return 1;
    }

    /**
     * Process elevator request when elevator is moving up.
     *
     * @param  \App\Elevator $elevator
     * @param  int
     * @return int
     */
    protected function handleUpDirection(Elevator $elevator, int $nextFloor)
    {
        $maxFloor = max($this->floorsIndexes);

        // Prevent "removed" floors from config file
        while ($nextFloor < min($this->floorsIndexes)) {
            $nextFloor++;
        }

        // Prevent "removed" floors from config file,
        // if the floor scheduled doesn't exist anymore
        // just continue with the next elevator request.
        if ($nextFloor > $maxFloor) {
            $elevator->current_floor = $maxFloor;
            $elevator->save();

            return $this->handleNextElevatorRequest($elevator);
        }

        if (!in_array($nextFloor, $this->floorsIndexes)) {
            return $this->handleUpDirection($elevator, $nextFloor + 1);
        }

        $elevator->current_floor = $nextFloor;
        $elevator->save();

        return 1;
    }
}
