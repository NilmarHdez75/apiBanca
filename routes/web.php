<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Verificación de correo (enlace del email)
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');
