<?php

use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */

Route::resource('/authors', AuthorController::class); // GET, POST, PUT, DELETE
Route::resource('/books', BookController::class); // GET, POST, PUT, DELETE
Route::resource('/categories', CategoryController::class); // GET, POST, PUT, DELETE
Route::resource('/fines', FineController::class); // GET, POST, PUT, DELETE
Route::resource('/loans', LoanController::class); // GET, POST, PUT, DELETE
Route::resource('/publishers', PublisherController::class); // GET, POST, PUT, DELETE
Route::resource('/reservations', ReservationController::class); // GET, POST, PUT, DELETE
Route::resource('/search_histories', SearchHistoryController::class); // GET, POST, PUT, DELETE
Route::resource('/users', UserController::class); // GET, POST, PUT, DELETE
Route::resource('/book_category', BookCategoryController::class); // GET, POST, PUT, DELETE
Route::resource('/author_book', AuthorBookController::class); // GET, POST, PUT, DELETE

Route::prefix('reports')->group(function () {
    Route::get('/popular-books', [ReportController::class, 'popularBooks']);
    Route::get('/defaulters', [ReportController::class, 'usersWithFines']);
    Route::get('/stadistics', [ReportController::class, 'loansByCategory']);
    Route::get('/efficiency-returns', [ReportController::class, 'returnEfficiency']);
});
