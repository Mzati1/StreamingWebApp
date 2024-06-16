<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\SeriesController;

// Volt Livewire route
use Livewire\Volt\Volt;

Volt::route('/livewire/users', 'users.index');

// Public routes
Route::get('/', [MovieController::class, 'index'])->name('movie.index');
Route::get('/movie/{movie_id}', [MovieController::class, 'movieDetails'])->name('movie.details');

Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{tvID}', [SeriesController::class, 'serieDetails'])->name('serie.details');
Route::get('/series/{tvID}/watch-now', [SeriesController::class, 'watchSeries'])->name('serie.watchNow');

Route::get('/people', [PeopleController::class, 'index'])->name('people.index');
Route::get('/people/{person_id}', [PeopleController::class, 'showPerson'])->name('person.details');

// Profile route
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
});

Route::post('/login', [UserController::class, 'login'])->name('user.login');


Route::get('/verify', [UserController::class, 'verify'])->name('user.verify');
Route::post('/verify', [UserController::class, 'resendVerificationLink'])->name('user.verify.resend');


// Authentication routes
Auth::routes();
Auth::routes(['verify' => true]);

// user post routes
Route::post('/register', [UserController::class, 'create'])->name('user.create.profile');
