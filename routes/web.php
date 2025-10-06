<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPageController;

// Web Routes.
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('terms', [StaticPageController::class, 'terms'])->name('terms');
Route::get('privacy', [StaticPageController::class, 'privacy'])->name('privacy');

// Auth Routes.
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
