<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Movie title
            $table->text('description'); // Movie description
            $table->string('genre'); // Genre (e.g., Action, Comedy)
            $table->string('director')->nullable(); // Director's name
            $table->integer('duration'); // Duration in minutes
            $table->date('release_date'); // Release date
            $table->string('rating')->nullable(); // Rating (e.g., PG-13, R)
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}

