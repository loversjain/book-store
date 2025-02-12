<?php

use App\Http\Controllers\Web\Author\AuthorController;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Book\BookController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login');
});

// Apply 'custom.auth' middleware to all subsequent routes
Route::middleware('custom.auth')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/logout', 'logout')->name('logout');
    });

    Route::controller(AuthorController::class)->group(function () {
        Route::get('/authors', 'getAuthors')->name('authors.index');
        Route::get('/authors/create', [AuthorController::class, 'showCreateAuthorForm'])->name('author.create');
        Route::post('/create', 'createAuthor')->name('author.store');
        Route::get('/authors/{author_id}', 'getAuthor')->name('authors.show');
        Route::delete('/authors/{author_id}', 'deleteAuthor')->name('authors.delete');
    });

    Route::controller(BookController::class)->group(function () {
        Route::get('/book/create/{author_id}', 'showCreateBookForm')->name('book.create');
        Route::post('/book', 'storeBook')->name('book.store');
        Route::delete('/book/{book_id}', 'deleteBook')->name('book.delete');
    });
});
?>

