<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoteElevatorRequestIdFromElevatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->dropColumn('elevator_request_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->unsignedInteger('elevator_request_id')
                ->nullable()
                ->after('id');
        });
    }
}
