<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        // Validar que la firma del enlace sea correcta
        if (!URL::hasValidSignature($request)) {
            return response()->json([
                'success' => false,
                'message' => 'El enlace de verificación es inválido o ha expirado.'
            ], 403);
        }

        // Validar el hash del correo (seguridad adicional)
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json([
                'success' => false,
                'message' => 'El enlace de verificación no coincide con el usuario.'
            ], 403);
        }

        // Si ya está verificado
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => true,
                'message' => 'El correo ya fue verificado anteriormente.'
            ], 200);
        }

        // Marcar como verificado
        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json([
            'success' => true,
            'message' => 'Correo verificado correctamente. Ya puedes registrar tu cuenta de socio.'
        ], 200);
    }
}
