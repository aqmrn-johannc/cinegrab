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
            'title' => $this->faker->sentence(3), // Random movie title
            'description' => $this->faker->paragraph, // Random description
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Thriller']),
            'director' => $this->faker->name, // Random director name
            'duration' => $this->faker->numberBetween(90, 180), // Duration between 90 and 180 minutes
            'release_date' => $this->faker->date, // Random release date
            'rating' => $this->faker->randomElement(['G', 'PG', 'PG-13', 'R']), // Random rating
        ];
    }
}

