<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContratoRequest;
use App\Http\Requests\UpdateContratoRequest;
use App\Models\Contrato;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContratoController extends Controller
{
    public function index(): JsonResponse
    {
        $contratos = Contrato::with('socio')
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $contratos
        ], 200);
    }

    /**
     * Guarda un nuevo contrato y su archivo PDF.
     */
    /*
    public function store(StoreContratoRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Guardar archivo PDF si existe
            if ($request->hasFile('archivo_contrato')) {
                $path = $request->file('archivo_contrato')->store('contratos', 'public');
                $data['archivo_contrato'] = $path;
            }

            $contrato = Contrato::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Contrato registrado correctamente.',
                'data' => $contrato
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al registrar contrato: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al registrar el contrato.'], 500);
        }
    }*/

    /**
     * Muestra un contrato específico
     */
    public function show($id): JsonResponse
    {
        $contrato = Contrato::with('socio')->find($id);

        if (!$contrato) {
            return response()->json(['success' => false, 'message' => 'Contrato no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $contrato]);
    }

    /**
     * Actualiza información o reemplaza el archivo del contrato.
     */
    public function update(UpdateContratoRequest $request, $id): JsonResponse
    {
        try {
            $contrato = Contrato::find($id);
            if (!$contrato) {
                return response()->json(['success' => false, 'message' => 'Contrato no encontrado.'], 404);
            }

            $data = $request->validated();

            // Si se sube un nuevo PDF, reemplazar el anterior
            if ($request->hasFile('archivo_contrato')) {
                if ($contrato->archivo_contrato && Storage::disk('public')->exists($contrato->archivo_contrato)) {
                    Storage::disk('public')->delete($contrato->archivo_contrato);
                }
                $path = $request->file('archivo_contrato')->store('contratos', 'public');
                $data['archivo_contrato'] = $path;
            }

            $contrato->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Contrato actualizado correctamente.',
                'data' => $contrato
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar contrato: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el contrato.'], 500);
        }
    }

    /**
     * Desactiva un contrato (no lo elimina físicamente)
     */
    public function destroy($id): JsonResponse
    {
        $contrato = Contrato::find($id);
        if (!$contrato) {
            return response()->json(['success' => false, 'message' => 'Contrato no encontrado.'], 404);
        }

        $contrato->update(['is_active' => false]);
        return response()->json(['success' => true, 'message' => 'Contrato desactivado correctamente.'], 200);
    }

    /**
     * Permite descargar el contrato PDF
     */
    public function download($id)
    {
        $contrato = Contrato::find($id);

        if (!$contrato || !$contrato->archivo_contrato || !Storage::disk('public')->exists($contrato->archivo_contrato)) {
            return response()->json(['success' => false, 'message' => 'Archivo no encontrado.'], 404);
        }

        return response()->download(storage_path('app/public/' . $contrato->archivo_contrato));
    }
}
