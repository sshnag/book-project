<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes with cache prevention
Auth::routes(['middleware' => 'no-cache']);

Route::get('/search', [BookController::class, 'search'])->name('search');

// Admin routes with cache prevention
Route::prefix('admin')->name('admin.')->middleware(['auth', 'no-cache', 'role:admin'])->group(function () {
    Route::resource('books', BookController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/books/{book}', [BookController::class, 'adminShow'])->name('books.show');

    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Consolidated user routes with cache prevention
Route::middleware(['auth', 'no-cache'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/books/{book}', [BookController::class, 'userShow'])->name('books.show');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
});

// Public book route (no authentication required)
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
