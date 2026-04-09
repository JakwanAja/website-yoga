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

Route::prefix('admin')->group(function () {
    Route::get('/jadwal', function () {
        return view('admin.jadwal');
    })->name('admin.jadwal');
});

Route::prefix('admin')->group(function () {
    Route::get('/user', function () {
        return view('admin.user');
    })->name('admin.user');
});

Route::prefix('admin')->group(function () {
    Route::get('/booking', function () {
        return view('admin.booking');
    })->name('admin.booking');
});

Route::view('/login', 'login')->name('login');
