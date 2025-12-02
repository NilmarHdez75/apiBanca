<?php
namespace App\Exceptions;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {

            if ($e instanceof \Exception) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ha ocurrido un error inesperado en el servidor.',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        }

        return parent::render($request, $e);
    }
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'success' => false,
            'message' => 'Errores de validación.',
            'errors' => $exception->errors(),
        ], $exception->status);
    }
}
