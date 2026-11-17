<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/results', [PublicController::class, 'results'])->name('results');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

// Authentication Routes
Route::get('/login', [PublicController::class, 'login'])->name('login');
Route::post('/logout', [PublicController::class, 'logout'])->name('logout');

// Admin Protected Routes
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/turnamen', [AdminController::class, 'turnamen'])->name('turnamen');
    Route::get('/turnamen/baru', [AdminController::class, 'createTurnamen'])->name('turnamen.baru');
    Route::get('/turnamen/{id}', [AdminController::class, 'showTurnamen'])->name('turnamen.detail');
    Route::get('/pesan', [AdminController::class, 'pesan'])->name('pesan');
});
