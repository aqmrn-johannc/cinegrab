<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Seat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\ReservationStatusChanged;
use App\Notifications\ReservationPendingNotification;

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

 
        if ($seat) {
            $seat->is_pending = true; 
            $seat->save();
        }

        $orderNumber = 'ORD-' . Str::random(10);

        $reservation = Reservation::create([
            'movie_id' => $validatedData['movie_id'],
            'seat_number' => $validatedData['seat'],
            'time_slot' => $validatedData['time_slot'],
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'price' => $movie->price,
            'status' => 'pending', 
        ]);

       
        $adminUsers = User::where('is_admin', true)->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new \App\Notifications\ReservationPendingNotification($reservation));
        }

        return redirect()->route('dashboard')->with('success', 'Reservation pending approval!');
    }


    public function getSeatsForTimeSlot($movieId, $timeSlot)
    {
        $seats = Seat::where('movie_id', $movieId)
                     ->where('time_slot', $timeSlot)
                     ->get(['seat_number', 'is_booked', 'is_pending']); 
    
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
                $seat->is_pending = false;
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
      
        $movies = Movie::all();

 
        $reservations = Reservation::with(['movie', 'user'])->get();

       
        $users = User::where('email', '!=', 'admin123@gmail.com')->get();

      
        $totalReservations = $reservations->count();
        $totalUsers = $users->count();

       
        return view('admin.dashboard', compact('movies', 'reservations', 'totalReservations', 'totalUsers', 'users'));
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $movie = Movie::findOrFail($reservation->movie_id); 

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

      
        if ($reservation->seat_number !== $validatedData['seat']) {
            $oldSeat->is_booked = false;
            $oldSeat->save();
            
       
            $newSeat = Seat::where('movie_id', $reservation->movie_id)
                        ->where('seat_number', $validatedData['seat'])
                        ->where('time_slot', $validatedData['time_slot'])
                        ->first();

            if ($newSeat && $newSeat->is_booked) {
                return back()->withErrors(['seat' => 'The new seat is already booked.']);
            }

          
            if ($newSeat) {
                $newSeat->is_booked = true;
                $newSeat->save();
            }
        }

   
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
        
   
        $user->banned_until = now()->addMinutes($request->duration);
        $user->ban_reason = $request->reason;
        $user->save();

        return response()->json(['success' => true]);
    }
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);

     
        $user->banned_until = null; 
        $user->ban_reason = null;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function approveReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

       
        $seat = Seat::where('movie_id', $reservation->movie_id)
                    ->where('seat_number', $reservation->seat_number)
                    ->where('time_slot', $reservation->time_slot)
                    ->first();

        if ($seat) {
            $seat->is_pending = false; 
            $seat->is_booked = true;    
            $seat->save();
        }

      
        $user = User::find($reservation->user_id);
        $user->notify(new ReservationStatusChanged($reservation));

        return redirect()->back()->with('success', 'Reservation approved!');
    }


    public function denyReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'denied';
        $reservation->save();

        
        $seat = Seat::where('movie_id', $reservation->movie_id)
                    ->where('seat_number', $reservation->seat_number)
                    ->where('time_slot', $reservation->time_slot)
                    ->first();

        if ($seat) {
            $seat->is_pending = true;  
            $seat->is_booked = false;  
            $seat->save();
        }

        
        $user = User::find($reservation->user_id);
        $user->notify(new ReservationStatusChanged($reservation));

        return redirect()->back()->with('success', 'Reservation denied!');
    }


}
