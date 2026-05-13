<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
})->name('landing');

// Menu Route
Route::get('/menu', function () {
    return Inertia::render('Menu');
})->name('menu');

// Reservation Routes - Public with Rate Limiting
Route::get('/reservations/create', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::post('/reservations', [ReservationController::class, 'store'])
    ->middleware('throttle:5,1') // 5 reservations per 1 minute
    ->name('reservations.store');

Route::get('/reservations/check-availability', [ReservationController::class, 'getByDateSession'])
    ->middleware('throttle:30,1') // 30 requests per 1 minute
    ->name('reservations.check-availability');

// Admin Dashboard - Protected Routes
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
