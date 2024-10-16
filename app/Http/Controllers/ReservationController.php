<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Seat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        $seats = Seat::where('movie_id', $movie->id)->get();

        return view('movies.reservation', compact('movie', 'seats'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'seat' => 'required',
            'time_slot' => 'required|in:09:00,12:00,15:00',
        ]);

        $movie = Movie::find($validatedData['movie_id']);
        $seat = Seat::where('movie_id', $validatedData['movie_id'])
                    ->where('seat_number', $validatedData['seat'])
                    ->where('time_slot', $validatedData['time_slot'])
                    ->first();

        if ($seat->is_booked) {
            return back()->withErrors(['seat' => 'The seat is already booked.']);
        }

        $seat->update(['is_booked' => true]);

        $orderNumber = 'ORD-' . Str::random(10);

        Reservation::create([
            'movie_id' => $validatedData['movie_id'],
            'seat_number' => $validatedData['seat'],
            'time_slot' => $validatedData['time_slot'],
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'price' => $movie->price,
        ]);

        return redirect()->route('dashboard')->with('success', 'Seat reserved successfully!');
    }

    public function getSeatsForTimeSlot($movieId, $timeSlot)
    {
        $seats = Seat::where('movie_id', $movieId)
                    ->where('time_slot', $timeSlot)
                    ->get();

        return response()->json(['seats' => $seats]);
    }

    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if ($reservation) {
            $seat = Seat::where('movie_id', $reservation->movie_id)
                        ->where('seat_number', $reservation->seat_number)
                        ->first();

            if ($seat) {
                $seat->is_booked = false;
                $seat->save();
            }

            $reservation->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


}
