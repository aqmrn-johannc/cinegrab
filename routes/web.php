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

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard')->middleware('auth'); 

Route::get('/admin/dashboard', [ReservationController::class, 'adminDashboard'])->middleware('auth')->name('admin.dashboard');

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/dashboard', [ReservationController::class, 'index'])->name('dashboard');

Route::get('/reservation/{movie}', [ReservationController::class, 'show'])->name('movies.reservation');

Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

Route::get('/checkout', [ReservationController::class, 'checkout'])->name('checkout');

Route::get('/reservations/export', [ReservationExportController::class, 'export'])->middleware('auth')->name('reservations.export');

Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/movies/{movie}/seats/{time_slot}', [ReservationController::class, 'getSeatsForTimeSlot']);

Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit')->middleware('auth');
Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update')->middleware('auth');

Route::get('/admin/dashboard', [ReservationController::class, 'adminDashboard'])->middleware('auth')->name('admin.dashboard');

Route::post('/ban-user/{id}', [ReservationController::class, 'banUser'])->middleware('auth');

Route::post('/unban-user/{id}', [ReservationController::class, 'unbanUser'])->middleware('auth');




Route::get('/dashboard', function () {
    $movies = Movie::all();

    return view('dashboard', compact('movies'));
})->name('dashboard');

Route::post('/reserve', [ReservationController::class, 'store'])->name('reservation.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
