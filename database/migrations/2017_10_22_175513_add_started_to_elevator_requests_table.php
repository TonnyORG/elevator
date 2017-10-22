<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartedToElevatorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elevator_requests', function (Blueprint $table) {
            $table->boolean('started')
                ->default(false)
                ->before('completed');

            $table->index('started');
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
            $table->dropIndex(['started']);

            $table->dropColumn('started');
        });
    }
}
