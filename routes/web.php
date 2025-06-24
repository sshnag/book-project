<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;

// Public routes (open to all)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/{book}', action: [BookController::class, 'userShow'])->name('books.show');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/contact',[ContactController::class,'create'])->name('contact.create');
Route::post('/contact',[ContactController::class,'store'])->name('contact.store');
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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'no-cache', 'role:admin'])->group(function () {
    Route::resource('books', BookController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/books/{book}', [BookController::class, 'adminShow'])->name('books.show');

    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::get('admin/contacts',[ContactController::class,'index'])->name('contact.index');
        Route::get('/admin/contacts/data', [ContactController::class, 'getData'])->name('contacts.data');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

