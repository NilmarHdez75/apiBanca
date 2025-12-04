<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RegistroSocioService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $registroSocioService;

    public function __construct(RegistroSocioService $registroSocioService)
    {
        $this->registroSocioService = $registroSocioService;
    }

    /**
     * Registro completo de usuario y socio
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente. Se envió un correo de verificación a su dirección.',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario.'
            ], 500);
        }
    }

    /**
     * Inicio de sesión
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas.'
            ], 401);
        }

        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes verificar tu correo electrónico antes de iniciar sesión.'
            ], 403);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario está inactivo.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso.',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function getSocioByUserId($userId)
    {
        $user = User::with('socio')->find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        if (!$user->socio) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario no tiene socio'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user->socio
        ], 200);
    }

    /**
     * Cierre de sesión
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }

    /**
     * Recuperación de contraseña
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Se ha enviado el enlace de recuperación a tu correo.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo enviar el enlace.'
            ], 400);
        }
    }

    /**
     * Restablecimiento de contraseña
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['success' => true, 'message' => 'Contraseña restablecida correctamente.'])
            : response()->json(['success' => false, 'message' => 'Token inválido o expirado.'], 400);
    }
}
