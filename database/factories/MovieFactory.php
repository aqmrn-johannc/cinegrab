<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), 
            'description' => $this->faker->paragraph, 
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Thriller']),
            'director' => $this->faker->name, 
            'duration' => $this->faker->numberBetween(90, 180), 
            'release_date' => $this->faker->date, 
            'rating' => $this->faker->randomElement(['G', 'PG', 'PG-13', 'R']), 
        ];
    }
}

