<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Common user dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Book download route for users
    Route::get('books/download/{book}', [BookController::class, 'download'])
        ->name('books.download')
        ->middleware('can:download books');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);

    // Additional admin routes
    // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});
