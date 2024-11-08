<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root']);
// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/data-rooms',[RoomController::class ,'index'])->name('room.index');
Route::post('/data-rooms', [RoomController::class, 'store'])->name('room.store');
Route::get('/data-rooms/{id}',[RoomController::class, 'show'])->name('room.show');
Route::put('/data-rooms/{id}',[RoomController::class, 'update'])->name('room.update');
Route::delete('/data-rooms/{id}',[RoomController::class, 'destroy'])->name('room.destroy');

// Create Guest Session
Route::post('/create-guest',[RoomController::class, 'guestJoinMakeSession'])->name('room.guest.session');
Route::post('/send-message',[RoomController::class,'sendMessage'])->name('room.guest.send');

// join  room
Route::get('/join/{id}', [RoomController::class, 'join'])->name('room.join');
Route::get('/x', [RoomController::class, 'tet'])->name('room.tet');
