<?php

use Illuminate\Database\Seeder;

use App\Elevator;

class ElevatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < config('elevator.total'); $i++) {
            (new Elevator)->save();
        }
    }
}
