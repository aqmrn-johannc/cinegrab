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
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('genre')->nullable();
            $table->string('director')->nullable();
            $table->integer('duration')->nullable();
            $table->date('release_date')->nullable();
            $table->string('rating')->nullable();
            $table->string('poster_filename')->nullable();  
            $table->string('trailer_filename')->nullable(); 
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
        Schema::dropIfExists('movies');
    }
}

