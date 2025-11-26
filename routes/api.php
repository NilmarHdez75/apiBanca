<?php

use App\Http\Controllers\Auth\ReSendVerificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\DireccionBeneficiarioController;
use App\Http\Controllers\DireccionSocioController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\SucursalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (sin autenticación)
|--------------------------------------------------------------------------
*/
// Registro e inicio de sesión
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Recuperación de contraseña
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Verificación de correo
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');

// Reenviar correo de verificación
Route::post('/email/resend', ReSendVerificationController::class);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
     Sucursales
     */

    Route::get('/sucursales', [SucursalController::class, 'index']);

    /*
    Módulo de Socios (crear, ver, editar)
    */
    Route::get('/socios/{id}', [SocioController::class, 'show']);      // Ver socio
    Route::post('/socios', [SocioController::class, 'store']);         // Crear socio
    Route::put('/socios/{id}', [SocioController::class, 'update']);    // Editar socio

    /*
     Direcciones de Socios
    */
    Route::get('/socios/{id}/direccion', [DireccionSocioController::class, 'show']);    // Ver dirección del socio
    Route::post('/socios/{id}/direccion', [DireccionSocioController::class, 'store']);  // Agregar dirección
    Route::put('/socios/{id}/direccion', [DireccionSocioController::class, 'update']);  // Actualizar dirección

    /*
     Módulo de Beneficiarios (CRUD)
    */
    Route::get('/beneficiarios', [BeneficiarioController::class, 'index']);        // Listar beneficiarios
    Route::post('/beneficiarios', [BeneficiarioController::class, 'store']);       // Crear beneficiario
    Route::get('/beneficiarios/{id}', [BeneficiarioController::class, 'show']);    // Ver beneficiario
    Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update']);  // Editar beneficiario
    Route::delete('/beneficiarios/{id}', [BeneficiarioController::class, 'destroy']); // Eliminar beneficiario

    /*
     Direcciones de Beneficiarios
    */
    Route::get('/beneficiarios/{id}/direccion', [DireccionBeneficiarioController::class, 'show']);   // Ver dirección
    Route::post('/beneficiarios/{id}/direccion', [DireccionBeneficiarioController::class, 'store']); // Crear dirección
    Route::put('/beneficiarios/{id}/direccion', [DireccionBeneficiarioController::class, 'update']); // Actualizar dirección

    /*
     Consultas financieras (cuentas y movimientos)
    */
    Route::get('/cuentas', [CuentaController::class, 'index']);                  // Ver cuentas del socio
    Route::get('/cuentas/{id}/movimientos', [MovimientoController::class, 'index']); // Ver movimientos de una cuenta
});
