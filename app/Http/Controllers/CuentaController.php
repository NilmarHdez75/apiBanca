<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuentaRequest;
use App\Http\Requests\UpdateCuentaRequest;
use App\Models\Cuenta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CuentaController extends Controller
{
    public function index(): JsonResponse
    {
        $cuentas = Cuenta::with('socio')->where('is_active', true)->get();
        return response()->json(['success' => true, 'data' => $cuentas]);
    }

    public function store(StoreCuentaRequest $request): JsonResponse
    {
        try {
            $cuenta = Cuenta::create($request->validated());
            return response()->json(['success' => true, 'message' => 'Cuenta creada correctamente.', 'data' => $cuenta], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear cuenta: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear cuenta.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $cuenta = Cuenta::with(['socio', 'movimientos'])->find($id);
        return $cuenta
            ? response()->json(['success' => true, 'data' => $cuenta])
            : response()->json(['success' => false, 'message' => 'Cuenta no encontrada.'], 404);
    }

    public function update(UpdateCuentaRequest $request, $id): JsonResponse
    {
        $cuenta = Cuenta::find($id);
        if (!$cuenta) return response()->json(['success' => false, 'message' => 'Cuenta no encontrada.'], 404);

        $cuenta->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Cuenta actualizada correctamente.']);
    }

    public function destroy($id): JsonResponse
    {
        $cuenta = Cuenta::find($id);
        if (!$cuenta) return response()->json(['success' => false, 'message' => 'Cuenta no encontrada.'], 404);

        $cuenta->update(['is_active' => false]);
        return response()->json(['success' => true, 'message' => 'Cuenta desactivada correctamente.']);
    }
}
