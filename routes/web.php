<?php
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Auth;

// Route::get("/", function () {
//     return view('');
// });
// Route::get('/books',[BookController::class,'index'])->name('books.index');
// Route::get('/books/{book}',[BookController::class,'show'])->name('books.show');

// Route::get('/book/download/{book}',[BookController::class,'download'])->middleware('auth')->name('books.download');

Route::get('/', [PublicController::class, 'index'])->name('home');

// Authentication routes
Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function() {
    Route::resource('books', BookController::class);

    Route::resource('authors', AuthorController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
});
