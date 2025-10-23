<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiarioRequest;
use App\Http\Requests\UpdateBeneficiarioRequest;
use App\Models\Beneficiario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => Beneficiario::with('socio')->get()]);
    }

    public function store(StoreBeneficiarioRequest $request): JsonResponse
    {
        $beneficiario = Beneficiario::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Beneficiario registrado correctamente.', 'data' => $beneficiario], 201);
    }

    public function show($id): JsonResponse
    {
        $beneficiario = Beneficiario::find($id);
        return $beneficiario
            ? response()->json(['success' => true, 'data' => $beneficiario])
            : response()->json(['success' => false, 'message' => 'Beneficiario no encontrado.'], 404);
    }

    public function update(UpdateBeneficiarioRequest $request, $id): JsonResponse
    {
        $beneficiario = Beneficiario::find($id);
        if (!$beneficiario) return response()->json(['success' => false, 'message' => 'Beneficiario no encontrado.'], 404);

        $beneficiario->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Beneficiario actualizado correctamente.']);
    }

    public function destroy($id): JsonResponse
    {
        $beneficiario = Beneficiario::find($id);
        if (!$beneficiario) return response()->json(['success' => false, 'message' => 'Beneficiario no encontrado.'], 404);

        $beneficiario->update(['is_active' => false]);
        return response()->json(['success' => true, 'message' => 'Beneficiario desactivado correctamente.']);
    }
}
