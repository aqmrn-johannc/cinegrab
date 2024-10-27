<?php

namespace App\Observers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class MovieObserver
{
    public function created(Movie $movie)
    {
        $rows = range('A', 'J');
        $columns = range(1, 10);
        $time_slots = ['09:00', '12:00', '15:00'];

        foreach ($time_slots as $time_slot) {
            foreach ($rows as $row) {
                foreach ($columns as $column) {
                    DB::table('seats')->insert([
                        'movie_id' => $movie->id,
                        'seat_number' => $row . $column,
                        'is_booked' => false,
                        'time_slot' => $time_slot,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
