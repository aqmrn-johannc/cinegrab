<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Seat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\User;

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
                        ->where('time_slot', $reservation->time_slot) 
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


    public function checkout(Request $request)
    {
        $movie_id = $request->input('movie_id');
        $time_slot = $request->input('time_slot');
        $seat = $request->input('seat');
        $price = $request->input('price');
        $title = $request->input('title');

        return view('movies.checkout', compact('movie_id', 'time_slot', 'seat', 'price', 'title'));
    }


    public function adminDashboard()
    {
        $reservations = Reservation::with(['movie', 'user'])->get(); // Fetch reservations with movie and user details

        // Fetch users along with their reservations, excluding the admin account
        $users = User::with('reservations')->where('email', '!=', 'admin123@gmail.com')->get(); 

        $totalReservations = $reservations->count(); // Count total reservations
        $totalUsers = $users->count(); // Count total users

        return view('admin.dashboard', compact('reservations', 'users', 'totalReservations', 'totalUsers'));
    }


    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $movie = Movie::findOrFail($reservation->movie_id); // Assuming you have a movie_id in the reservation

        return view('admin.edit', compact('reservation', 'movie'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'time_slot' => 'required|in:09:00,12:00,15:00',
            'seat' => 'required',
        ]);

        $reservation = Reservation::findOrFail($id);
        $oldSeat = Seat::where('movie_id', $reservation->movie_id)
                    ->where('seat_number', $reservation->seat_number)
                    ->where('time_slot', $reservation->time_slot)
                    ->first();

        // If the seat is being changed, mark the old seat as available
        if ($reservation->seat_number !== $validatedData['seat']) {
            $oldSeat->is_booked = false;
            $oldSeat->save();
            
            // Check if the new seat is booked
            $newSeat = Seat::where('movie_id', $reservation->movie_id)
                        ->where('seat_number', $validatedData['seat'])
                        ->where('time_slot', $validatedData['time_slot'])
                        ->first();

            if ($newSeat && $newSeat->is_booked) {
                return back()->withErrors(['seat' => 'The new seat is already booked.']);
            }

            // Update the new seat to booked
            if ($newSeat) {
                $newSeat->is_booked = true;
                $newSeat->save();
            }
        }

        // Update reservation details
        $reservation->update([
            'time_slot' => $validatedData['time_slot'],
            'seat_number' => $validatedData['seat'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Reservation updated successfully!');
    }

    public function banUser(Request $request, $id)
    {
        $request->validate([
            'duration' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        
        // Set the banned_until time
        $user->banned_until = now()->addMinutes($request->duration);
        $user->ban_reason = $request->reason;
        $user->save();

        return response()->json(['success' => true]);
    }
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);

        // Remove the ban
        $user->banned_until = null; // Set banned_until to null
        $user->ban_reason = null; // Optionally clear the ban reason
        $user->save();

        return response()->json(['success' => true]);
    }

}
