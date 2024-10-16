<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Support\Str; // Add this import

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $movies = Movie::all();
        $seats = [
            'A1', 'A2', 'A3', 'A4', 'A5',
            'B1', 'B2', 'B3', 'B4', 'B5',
            'C1', 'C2', 'C3', 'C4', 'C5',
            'D1', 'D2', 'D3', 'D4', 'D5',
        ];

        foreach ($movies as $movie) {
            foreach ($users as $user) {
                // Create reservations for multiple time slots with correct format
                $timeSlots = ['09:00', '12:00', '15:00']; // Change to match migration enum

                foreach ($timeSlots as $timeSlot) {
                    $reservedSeats = []; // Track reserved seats for this movie and time slot

                    // Attempt to create multiple reservations
                    for ($i = 0; $i < 20; $i++) { // Adjust number as needed
                        $seat = $seats[array_rand($seats)];

                        // Ensure the seat hasn't already been reserved for this time slot
                        if (in_array($seat, $reservedSeats)) {
                            continue; // Skip to the next iteration if the seat is already taken
                        }

                        Reservation::create([
                            'user_id' => $user->id,
                            'movie_id' => $movie->id,
                            'time_slot' => $timeSlot, // Use the correct time format
                            'seat_number' => $seat,
                            'order_number' => strtoupper(Str::random(10)), // Use Str::random here
                        ]);

                        // Add the seat to the reserved list
                        $reservedSeats[] = $seat;
                    }
                }
            }
        }
    }

}
