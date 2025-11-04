<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimientoRequest;
use App\Http\Requests\UpdateMovimientoRequest;
use App\Models\Movimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovimientoController extends Controller
{
    public function index(): JsonResponse
    {
        $movimientos = Movimiento::with('cuenta')->get();
        return response()->json(['success' => true, 'data' => $movimientos]);
    }

    public function store(StoreMovimientoRequest $request): JsonResponse
    {
        try {
            $movimiento = Movimiento::create($request->validated());
            return response()->json(['success' => true, 'message' => 'Movimiento registrado correctamente.', 'data' => $movimiento], 201);
        } catch (\Exception $e) {
            Log::error('Error al registrar movimiento: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al registrar el movimiento.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $movimiento = Movimiento::find($id);
        return $movimiento
            ? response()->json(['success' => true, 'data' => $movimiento])
            : response()->json(['success' => false, 'message' => 'Movimiento no encontrado.'], 404);
    }

    public function update(UpdateMovimientoRequest $request, $id): JsonResponse
    {
        $movimiento = Movimiento::find($id);
        if (!$movimiento) return response()->json(['success' => false, 'message' => 'Movimiento no encontrado.'], 404);

        $movimiento->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Movimiento actualizado correctamente.']);
    }

    public function destroy($id): JsonResponse
    {
        $movimiento = Movimiento::find($id);
        if (!$movimiento) return response()->json(['success' => false, 'message' => 'Movimiento no encontrado.'], 404);

        $movimiento->delete();
        return response()->json(['success' => true, 'message' => 'Movimiento eliminado correctamente.']);
    }
}
