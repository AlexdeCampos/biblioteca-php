<?php

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

