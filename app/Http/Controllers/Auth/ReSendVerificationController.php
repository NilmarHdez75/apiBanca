<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReSendVerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validar email
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        // Buscar usuario
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        // Ya verificado
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => true,
                'message' => 'El correo ya fue verificado'
            ], 200);
        }

        // Reenviar email
        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Correo de verificación reenviado'
        ], 200);
    }
}
