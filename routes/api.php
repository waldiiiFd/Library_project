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
use App\Http\Controllers\ViewStatisticsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes - Library Management System
|--------------------------------------------------------------------------
|
| Sistema de rutas con autenticación JWT y control de acceso basado en scopes
| usando el paquete app-context de Ronu
|
*/

// ============================================================================
// RUTAS PÚBLICAS (Sin autenticación)
// ============================================================================

Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});

// ============================================================================
// RUTAS PROTEGIDAS CON JWT (Requieren autenticación)
// ============================================================================

Route::middleware(['app-context'])->prefix('v1')->group(function () {

    // ------------------------------------------------------------------------
    // AUTH - Rutas de autenticación (requieren token válido)
    // ------------------------------------------------------------------------
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
    });

    // ------------------------------------------------------------------------
    // AUTHORS - Control de acceso basado en scopes
    // ------------------------------------------------------------------------
    
    // Permisos de LECTURA (GET) - Todos los usuarios autenticados pueden leer
    Route::middleware(['app.requires:author:read'])->group(function () {
        Route::get('author', [AuthorController::class, 'index'])->name('author.index');
        Route::get('author/{author}', [AuthorController::class, 'show'])->name('author.show');
    });

    // Permisos de ESCRITURA (POST, PUT, DELETE) - Solo usuarios con permisos de escritura
    Route::middleware(['app.requires:author:write'])->group(function () {
        Route::post('author', [AuthorController::class, 'store'])->name('author.store');
        Route::put('author/{author}', [AuthorController::class, 'update'])->name('author.update');
        Route::delete('author/{author}', [AuthorController::class, 'destroy'])->name('author.destroy');
        Route::post('author/update-multiple', [AuthorController::class, 'updateMultiple'])->name('author.updateMultiple');
    });

    // ------------------------------------------------------------------------
    // BOOKS - Control de acceso basado en scopes
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:book:read'])->group(function () {
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
    });

    Route::middleware(['app.requires:book:write'])->group(function () {
        Route::post('books', [BookController::class, 'store'])->name('books.store');
        Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // ------------------------------------------------------------------------
    // CATEGORIES - Control de acceso
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:book:read'])->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    });

    Route::middleware(['app.requires:book:write'])->group(function () {
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // ------------------------------------------------------------------------
    // PUBLISHERS - Control de acceso
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:book:read'])->group(function () {
        Route::get('publishers', [PublisherController::class, 'index'])->name('publishers.index');
        Route::get('publishers/{publisher}', [PublisherController::class, 'show'])->name('publishers.show');
    });

    Route::middleware(['app.requires:book:write'])->group(function () {
        Route::post('publishers', [PublisherController::class, 'store'])->name('publishers.store');
        Route::put('publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
        Route::delete('publishers/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');
    });

    // ------------------------------------------------------------------------
    // LOANS - Control de acceso
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:loan:read'])->group(function () {
        Route::get('loans', [LoanController::class, 'index'])->name('loans.index');
        Route::get('loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    });

    Route::middleware(['app.requires:loan:write'])->group(function () {
        Route::post('loans', [LoanController::class, 'store'])->name('loans.store');
        Route::put('loans/{loan}', [LoanController::class, 'update'])->name('loans.update');
        Route::delete('loans/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');
    });

    // ------------------------------------------------------------------------
    // RESERVATIONS - Control de acceso
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:reservation:read'])->group(function () {
        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    });

    Route::middleware(['app.requires:reservation:write'])->group(function () {
        Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    // ------------------------------------------------------------------------
    // FINES - Control de acceso (solo lectura para usuarios, escritura para admin)
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:loan:read'])->group(function () {
        Route::get('fines', [FineController::class, 'index'])->name('fines.index');
        Route::get('fines/{fine}', [FineController::class, 'show'])->name('fines.show');
    });

    Route::middleware(['app.requires:loan:write'])->group(function () {
        Route::post('fines', [FineController::class, 'store'])->name('fines.store');
        Route::put('fines/{fine}', [FineController::class, 'update'])->name('fines.update');
        Route::delete('fines/{fine}', [FineController::class, 'destroy'])->name('fines.destroy');
    });

    // ------------------------------------------------------------------------
    // USERS - Control de acceso (solo admin)
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:user:read'])->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    });

    Route::middleware(['app.requires:user:write'])->group(function () {
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // ------------------------------------------------------------------------
    // SEARCH HISTORY - Todos los usuarios autenticados
    // ------------------------------------------------------------------------
    
    Route::get('search-histories', [SearchHistoryController::class, 'index'])->name('search_histories.index');
    Route::post('search-histories', [SearchHistoryController::class, 'store'])->name('search_histories.store');
    Route::get('search-histories/{searchHistory}', [SearchHistoryController::class, 'show'])->name('search_histories.show');

    // ------------------------------------------------------------------------
    // RELACIONES - Libros con Autores y Categorías
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:book:read'])->group(function () {
        Route::get('book-category', [BookCategoryController::class, 'index'])->name('book_category.index');
        Route::get('author-book', [AuthorBookController::class, 'index'])->name('author_book.index');
    });

    Route::middleware(['app.requires:book:write'])->group(function () {
        Route::post('book-category', [BookCategoryController::class, 'store'])->name('book_category.store');
        Route::delete('book-category/{bookCategory}', [BookCategoryController::class, 'destroy'])->name('book_category.destroy');
        Route::post('author-book', [AuthorBookController::class, 'store'])->name('author_book.store');
        Route::delete('author-book/{authorBook}', [AuthorBookController::class, 'destroy'])->name('author_book.destroy');
    });

    // ------------------------------------------------------------------------
    // REPORTS & STATISTICS - Solo usuarios con permisos de lectura de reportes
    // ------------------------------------------------------------------------
    
    Route::middleware(['app.requires:report:read'])->prefix('reports')->group(function () {
        Route::get('/popular-books', [ReportController::class, 'popularBooks'])->name('reports.popular_books');
        Route::get('/defaulters', [ReportController::class, 'usersWithFines'])->name('reports.defaulters');
        Route::get('/statistics', [ViewStatisticsController::class, 'index'])->name('reports.statistics');
    });
});