<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Publisher\PublisherController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

//Rota criada unicamente para gerar token para o postman
Route::get('/postman/csrf', function () {
    return csrf_token();
});

Route::prefix('usuarios')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('{user}', [UserController::class, 'show']);
    Route::post('{user?}', [UserController::class, 'save']);
    Route::delete('{user}', [UserController::class, 'destroy']);
});

Route::prefix('autores')->group(function () {
    Route::get('', [AuthorController::class, 'index']);
    Route::get('{author}', [AuthorController::class, 'show']);
    Route::post('{author?}', [AuthorController::class, 'save']);
    Route::delete('{author}', [AuthorController::class, 'destroy']);
});

Route::prefix('editoras')->group(function () {
    Route::get('', [PublisherController::class, 'index']);
    Route::get('{publisher}', [PublisherController::class, 'show']);
    Route::post('{publisher?}', [PublisherController::class, 'save']);
    Route::delete('{publisher}', [PublisherController::class, 'destroy']);
});

Route::prefix('livros')->group(function () {
    Route::get('', [BookController::class, 'index']);
    Route::get('{book}', [BookController::class, 'show']);
    Route::post('{book?}', [BookController::class, 'save']);
    Route::delete('{book}', [BookController::class, 'destroy']);
});
