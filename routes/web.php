<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('user', App\Http\Controllers\UserViewController::class)->except(['show', 'destroy']);
    Route::resource('room', App\Http\Controllers\RoomViewController::class)->except(['show', 'destroy']);
    Route::resource('booking', App\Http\Controllers\BookingViewController::class)->except(['show', 'destroy']);
    Route::resource('payment', App\Http\Controllers\PaymentViewController::class)->except(['show', 'destroy']);
    Route::get('user/report', [App\Http\Controllers\UserViewController::class, 'report'])->name('user.report');
    Route::get('payment/report', [App\Http\Controllers\PaymentViewController::class, 'report'])->name('payment.report');
});
