<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/class', 'class')->name('class');
Route::view('/schedule', 'schedule')->name('schedule');

Route::view('/booking', 'booking')->name('booking');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::view('/login', 'login')->name('login');