<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDireccionSocioRequest;
use App\Http\Requests\UpdateDireccionSocioRequest;
use App\Models\DireccionSocio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DireccionSocioController extends Controller
{
    public function index(): JsonResponse
    {
        $direcciones = DireccionSocio::with('socio')->get();
        return response()->json(['success' => true, 'data' => $direcciones], 200);
    }

    public function store(StoreDireccionSocioRequest $request): JsonResponse
    {
        try {
            $direccion = DireccionSocio::create($request->validated());
            return response()->json(['success' => true, 'message' => 'Dirección registrada correctamente.', 'data' => $direccion], 201);
        } catch (\Exception $e) {
            Log::error('Error al registrar dirección: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al registrar la dirección.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $direccion = DireccionSocio::find($id);
        return $direccion
            ? response()->json(['success' => true, 'data' => $direccion])
            : response()->json(['success' => false, 'message' => 'Dirección no encontrada.'], 404);
    }

    public function update(UpdateDireccionSocioRequest $request, $id): JsonResponse
    {
        $direccion = DireccionSocio::find($id);
        if (!$direccion) {
            return response()->json(['success' => false, 'message' => 'Dirección no encontrada.'], 404);
        }

        $direccion->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Dirección actualizada correctamente.']);
    }

    public function destroy($id): JsonResponse
    {
        $direccion = DireccionSocio::find($id);
        if (!$direccion) {
            return response()->json(['success' => false, 'message' => 'Dirección no encontrada.'], 404);
        }

        $direccion->delete();
        return response()->json(['success' => true, 'message' => 'Dirección eliminada correctamente.']);
    }
}
