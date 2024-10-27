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
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->string('seat_number');
            $table->enum('time_slot', ['09:00', '12:00', '15:00']); 
            $table->string('order_number')->nullable();
            $table->string('user_name')->nullable(); 
            $table->decimal('price', 8, 2)->default(100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

