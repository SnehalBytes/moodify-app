<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// This single line tells Laravel to use our new HomeController instead of the old function
Route::get('/', [HomeController::class, 'index'])->name('home');