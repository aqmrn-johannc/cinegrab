<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('user_name'); // Name of the user
            $table->string('order_number')->unique(); // Order number
            $table->string('seat'); // The seat reserved
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Foreign key for movies
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

