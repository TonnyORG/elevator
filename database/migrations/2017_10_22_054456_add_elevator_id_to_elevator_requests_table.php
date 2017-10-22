<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddElevatorIdToElevatorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elevator_requests', function (Blueprint $table) {
            $table->unsignedInteger('elevator_id')->nullable();

            $table->index('elevator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elevator_requests', function (Blueprint $table) {
            $table->dropIndex(['elevator_id']);

            $table->dropColumn('elevator_id');
        });
    }
}
