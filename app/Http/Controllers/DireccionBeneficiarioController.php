<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDireccionBeneficiarioRequest;
use App\Http\Requests\UpdateDireccionBeneficiarioRequest;
use App\Models\DireccionBeneficiario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DireccionBeneficiarioController extends Controller
{
    public function index(): JsonResponse
    {
        $direcciones = DireccionBeneficiario::with('beneficiario')->get();
        return response()->json(['success' => true, 'data' => $direcciones]);
    }

    public function store(StoreDireccionBeneficiarioRequest $request): JsonResponse
    {
        try {
            $direccion = DireccionBeneficiario::create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Dirección de beneficiario registrada correctamente.',
                'data' => $direccion
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al registrar dirección: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al registrar la dirección.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $direccion = DireccionBeneficiario::find($id);
        return $direccion
            ? response()->json(['success' => true, 'data' => $direccion])
            : response()->json(['success' => false, 'message' => 'Dirección no encontrada.'], 404);
    }

    public function update(UpdateDireccionBeneficiarioRequest $request, $id): JsonResponse
    {
        $direccion = DireccionBeneficiario::find($id);
        if (!$direccion) {
            return response()->json(['success' => false, 'message' => 'Dirección no encontrada.'], 404);
        }

        $direccion->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Dirección actualizada correctamente.']);
    }

    public function destroy($id): JsonResponse
    {
        $direccion = DireccionBeneficiario::find($id);
        if (!$direccion) {
            return response()->json(['success' => false, 'message' => 'Dirección no encontrada.'], 404);
        }

        $direccion->delete();
        return response()->json(['success' => true, 'message' => 'Dirección eliminada correctamente.']);
    }
}
