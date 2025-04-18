<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Middleware\AddFiltersToProps;

Route::get('/', function () {
    return redirect('/authors');
});

Route::middleware(AddFiltersToProps::class)->group(function () {
    Route::prefix('authors')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
        Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
        Route::put('/{id}', [AuthorController::class, 'update'])->name('authors.update');

        Route::prefix('books')->group(function () {
            Route::get('/', [BookController::class, 'index'])->name('books.index');
            Route::post('/', [BookController::class, 'store'])->name('books.store');
            Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
            Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
        });
    });
});
