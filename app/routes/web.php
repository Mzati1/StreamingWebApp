<?php

use App\Http\Controllers\actorController;
use App\Http\Controllers\movieController;
use App\Http\Controllers\peopleController;
use App\Http\Controllers\seriesController;
use App\Http\Controllers\userController;
use App\View\Components\movieCard;
use App\View\Components\personCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/livewire/users', 'users.index');

//login and register
//Route::get('/login', [userController::class, 'login'])->name('user.login');
//Route::get('/register', [userController::class, 'register'])->name('user.register');

//movie routes
Route::get('/', [movieController::class, 'index'])->name('movie.index');
Route::get('/movie/{movie_id}', [movieController::class, 'movieDetails'])->name('movie.details');

//series routes
Route::get('/series', [seriesController::class, 'index'])->name('series.index');
Route::get('/series/{tvID}', [seriesController::class, 'serieDetails'])->name('serie.details');

//person routes
Route::get('/people', [peopleController::class, 'index'])->name('people.index');
Route::get('/people/{person_id}',[ peopleController::class, 'showPerson'])->name('person.details');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
