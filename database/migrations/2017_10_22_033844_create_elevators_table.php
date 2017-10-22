<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElevatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elevators', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('elevator_request_id')->nullable();
            $table->integer('current_floor')->default(1);
            $table->enum('direction', [
                    'down',
                    'stand',
                    'up',
                ])
                ->default('stand');
            $table->enum('signal', [
                    'closed',
                    'open',
                ])
                ->default('closed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elevators');
    }
}
