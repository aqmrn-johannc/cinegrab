<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Support\Str; 

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
              
                $timeSlots = ['09:00', '12:00', '15:00']; 

                foreach ($timeSlots as $timeSlot) {
                    $reservedSeats = [];

               
                    for ($i = 0; $i < 20; $i++) { 
                        $seat = $seats[array_rand($seats)];

                       
                        if (in_array($seat, $reservedSeats)) {
                            continue;
                        }

                        Reservation::create([
                            'user_id' => $user->id,
                            'movie_id' => $movie->id,
                            'time_slot' => $timeSlot, 
                            'seat_number' => $seat,
                            'order_number' => strtoupper(Str::random(10)),
                        ]);

     
                        $reservedSeats[] = $seat;
                    }
                }
            }
        }
    }

}
