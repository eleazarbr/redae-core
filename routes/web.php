<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Web Routes.
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Auth Routes.
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
