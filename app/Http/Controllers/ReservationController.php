<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Reservation;
use Illuminate\Support\Str;

class ReservationController extends Controller
{

    public function show($movie)
    {
        $seats = Seat::all();
        $movie = Movie::find($movie);  
        return view('movies.reservation', compact('movie','seats'));  
    }
    public function reserve(Request $request)
    {
        $request->validate([
            'seat' => 'required|string|exists:seats,seat_number',
        ]);

        $seat = Seat::where('seat_number', $request->seat)->first();
        if ($seat) {
            $seat->is_booked = true;
            $seat->save();

            // Create a reservation (make sure you have a Reservation model)
            $reservation = new Reservation();
            $reservation->user_id = auth()->id();
            $reservation->user_name = auth()->user()->name; // Add user's name here
            $reservation->order_number = Str::random(7); // Generate a random order number
            $reservation->seat = $seat->seat_number;
            $reservation->movie_id = $request->movie_id; // Make sure to include the movie_id
            $reservation->save();

            return redirect()->route('dashboard')->with('success', 'Reservation Added!');
        }

        return redirect()->back()->with('error', 'Failed to reserve the seat.');
    }



}
