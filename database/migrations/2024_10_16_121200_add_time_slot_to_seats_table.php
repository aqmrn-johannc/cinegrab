<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeSlotToSeatsTable extends Migration
{
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->enum('time_slot', ['09:00', '12:00', '15:00'])->after('is_booked'); // Add the time_slot column
        });
    }

    public function down()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->dropColumn('time_slot');
        });
    }
}
