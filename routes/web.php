<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user', App\Http\Controllers\UserViewController::class)->except(['show', 'destroy']);
