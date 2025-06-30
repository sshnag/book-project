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

/*
|--------------------------------------------------------------------------
| Public Routes (accessible to everyone)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/{book}', [BookController::class, 'userShow'])->name('books.show');
Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth routes
Auth::routes(['middleware' => 'no-cache']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'no-cache'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/books/{book}', [BookController::class, 'userShow'])->name('books.show');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (for superadmin and bookadmin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'no-cache', 'role:superadmin|bookadmin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Book Routes
    Route::resource('books', BookController::class)->except(['show']);
    Route::get('/books/{book}', [BookController::class, 'adminShow'])->name('books.show');
    Route::get('/books/data', [BookController::class, 'data'])->name('books.data');

    // Contact Routes
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::patch('contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.updateStatus');

    // Category Routes
    Route::get('/categories/data', [CategoryController::class, 'getDataTable'])->name('categories.data');
    Route::resource('categories', CategoryController::class);

    // Author Routes
    Route::resource('authors', AuthorController::class);

    // User Routes (Superadmin only)
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
});
