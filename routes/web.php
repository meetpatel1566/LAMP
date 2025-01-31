<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Auth::routes();


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('admin');
Route::get('/user-dashboard', [DashboardController::class, 'userIndex'])->name('user.dashboard')->middleware('auth');
Auth::routes();

