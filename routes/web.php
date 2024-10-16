<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReservationController;
use App\Models\Movie;
use App\Http\Controllers\ReservationExportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $movies = Movie::all();

    return view('dashboard', compact('movies'));
});

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/dashboard', [ReservationController::class, 'index'])->name('dashboard');

Route::get('/reservation/{movie}', [ReservationController::class, 'show'])->name('movies.reservation');

Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

Route::get('/reservations/export', [ReservationExportController::class, 'export'])->middleware('auth')->name('reservations.export');

Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/movies/{movie}/seats/{time_slot}', [ReservationController::class, 'getSeatsForTimeSlot']);



Route::get('/dashboard', function () {
    // Fetch movies from the database
    $movies = Movie::all();

    // Pass movies to the view
    return view('dashboard', compact('movies'));
})->name('dashboard');

Route::post('/reserve', [ReservationController::class, 'store'])->name('reservation.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
