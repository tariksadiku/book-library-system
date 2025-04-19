<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Middleware\AddFiltersToProps;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/authors');
});

Route::middleware(AddFiltersToProps::class)->group(function () {
    Route::prefix('authors')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
        Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('/create', [AuthorController::class, 'create'])->name('authors.create');
        Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
        Route::get('/{id}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::put('/{id}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    });

    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('books.index');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::get('/create', [BookController::class, 'create'])->name('books.create');
        Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
        Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });
});
