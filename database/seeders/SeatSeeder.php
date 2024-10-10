<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    public function run()
    {
        $seats = [];

        // Generate seats A1-A10 and B1-B10
        for ($row = 'A'; $row <= 'J'; $row++) {
            for ($number = 1; $number <= 10; $number++) {
                $seats[] = [
                    'seat_number' => $row . $number,
                    'is_booked' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert seats into the database
        Seat::insert($seats);
    }
}
