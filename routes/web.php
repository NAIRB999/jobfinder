<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use GuzzleHttp\Middleware;

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

//all listing
Route::get('/', [ListingController::class,'index']);

//show create form
Route::get('/listing/create',[ListingController::class,'create'])->middleware('auth');

// store listing data
Route::post('/listing', [ListingController::class, 'store'])->middleware('auth');

//show edit form
Route::get('/listing/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//update listing
Route::put('/listing/{listing}',[ListingController::class,'update'])->middleware('auth');

//delete listing
Route::delete('/listing/{listing}',[ListingController::class,'delete'])->middleware('auth');

//manage listings
Route::get('/listing/manage', [ListingController::class,'manage'])->middleware('auth');

//single listing
Route::get('/listing/{listing}',[ListingController::class,'show']);

//show register form
Route::get('/register',[UserController::class,'show'])->middleware('guest');

// create users
Route::post('/users', [UserController::class, 'store']);

// logout users
Route::get('/logout',[UserController::class,'logout'])->middleware('auth');

//show user login
Route::get('/login',[UserController::class,'login']);

//login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);