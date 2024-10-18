<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;

class SeatSeeder extends Seeder
{
    public function run()
    {
        $rows = range('A', 'J'); 
        $columns = range(1, 10); 
        $time_slots = ['09:00', '12:00', '15:00']; 

        $movies = Movie::all();

        foreach ($movies as $movie) {
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
}
