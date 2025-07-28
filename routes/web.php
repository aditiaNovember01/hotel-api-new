<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user', App\Http\Controllers\UserViewController::class)->except(['show', 'destroy']);
Route::resource('room', App\Http\Controllers\RoomViewController::class)->except(['show', 'destroy']);
Route::resource('booking', App\Http\Controllers\BookingViewController::class)->except(['show', 'destroy']);
Route::resource('payment', App\Http\Controllers\PaymentViewController::class)->except(['show', 'destroy']);
