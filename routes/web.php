<?php
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get("/", function () {
//     return view('');
// });
// Route::get('/books',[BookController::class,'index'])->name('books.index');
// Route::get('/books/{book}',[BookController::class,'show'])->name('books.show');

// Route::get('/book/download/{book}',[BookController::class,'download'])->middleware('auth')->name('books.download');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Auth::routes();
Route::get('/search', [App\Http\Controllers\BookController::class, 'search'])->name('search');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('books', BookController::class, ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy','adminShow']]);
    Route::get('/books/{book}', [BookController::class, 'adminShow'])->name('books.show');

    Route::resource('authors', AuthorController::class);

    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/books/{book}', [BookController::class, 'userShow'])->name('books.show');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
});

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
});
