<?php

use Illuminate\Support\Facades\Route;

//Rota criada unicamente para gerar token para o postman
Route::get('/postman/csrf', function () {
    return csrf_token();
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
