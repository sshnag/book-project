<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public routes (open to all)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/{book}', action: [BookController::class, 'userShow'])->name('books.show');
Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
// Auth routes
Auth::routes(['middleware' => 'no-cache']);

// Authenticated user routes
Route::middleware(['auth', 'no-cache'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/books/{book}', action: [BookController::class, 'userShow'])->name('books.show');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'no-cache', 'role:superadmin|bookadmin'])->group(function () {
    Route::resource('books', BookController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/books/{book}', [BookController::class, 'adminShow'])->name('books.show');

    // Fix: Admin contact routes
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.updateStatus');

    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole'); // ✅ FIXED
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
