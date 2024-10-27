<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
    
        $movies = Movie::all();
        $reservations = Reservation::all();
        $users = User::all();

        $totalReservations = $reservations->count();
        $totalUsers = $users->count();

        return view('admin.dashboard', [
            'movies' => $movies,
            'reservations' => $reservations,
            'users' => $users,
            'totalReservations' => $totalReservations, 
            'totalUsers' => $totalUsers, 
        ]);
    }


    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        return view('movies.show', compact('movie'));
    }

        public function create()
    {
        return view('admin.addmovie');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'duration' => 'required|integer',
            'release_date' => 'required|date',
            'rating' => 'required|string|max:255',
            'price' => 'required|numeric',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:30000',
            'trailer' => 'required|mimes:mp4|max:30000',
        ]);

   
        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->genre = $request->genre;
        $movie->director = $request->director;
        $movie->duration = $request->duration;
        $movie->release_date = $request->release_date;
        $movie->rating = $request->rating;
        $movie->price = $request->price;

        if ($request->hasFile('poster')) {
            $extension = $request->file('poster')->getClientOriginalExtension();
            $cardNumber = Movie::count() + 1; 
            $posterFilename = 'card' . $cardNumber . '.' . $extension;
            $posterPath = $request->file('poster')->storeAs('images', $posterFilename, 'public'); 
            $movie->poster_filename = $posterFilename; 
        }

        if ($request->hasFile('trailer')) {
            $extension = $request->file('trailer')->getClientOriginalExtension();
            $trailerNumber = Movie::count() + 1; 
            $trailerFilename = 'trailer' . $trailerNumber . '.' . $extension; 
            $trailerPath = $request->file('trailer')->storeAs('trailers', $trailerFilename, 'public'); 
            $movie->trailer_filename = $trailerFilename; 
        }

        $movie->save();

  
        return redirect()->route('admin.dashboard')->with('success', 'Movie added successfully!');
    }


    
    public function destroy($id)
    {
   
        $movie = Movie::find($id);

        if (!$movie) {
  
            return redirect()->route('movies.index')->with('error', 'Movie not found.');
        }

   
        if ($movie->poster_filename && Storage::disk('public')->exists('images/' . $movie->poster_filename)) {
            Storage::disk('public')->delete('images/' . $movie->poster_filename);
        }

    
        if ($movie->trailer_filename && Storage::disk('public')->exists('trailers/' . $movie->trailer_filename)) {
            Storage::disk('public')->delete('trailers/' . $movie->trailer_filename);
        }

        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully.');
    }


}
