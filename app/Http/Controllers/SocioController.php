<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocioRequest;
use App\Http\Requests\UpdateSocioRequest;
use App\Models\Socio;
use App\Services\RegistroSocioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SocioController extends Controller
{

    protected $registroSocioService;

    public function __construct(RegistroSocioService $registroSocioService)
    {
        $this->registroSocioService = $registroSocioService;
    }
    public function index(): JsonResponse
    {
        try {
            $socios = Socio::with(['user', 'sucursal'])->where('is_active', true)->get();
            return response()->json([
                'success' => true,
                'message' => 'Lista de socios obtenida correctamente.',
                'data' => $socios
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al listar socios: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener socios.'], 500);
        }
    }

    // Registrar nuevo socio
    public function store(StoreSocioRequest $request): JsonResponse
    {
        $result = $this->registroSocioService->registrarSocio($request->validated());

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'] ?? 'Socio registrado correctamente. Contrato enviado por correo.',
            'data' => $result['data']
        ], 201);
    }

    // Mostrar socio específico
    public function show($id): JsonResponse
    {
        $socio = Socio::with(['user', 'sucursal', 'direccion', 'beneficiarios'])->find($id);

        if (!$socio || !$socio->is_active) {
            return response()->json(['success' => false, 'message' => 'Socio no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $socio], 200);
    }

    // Actualizar socio
    public function update(UpdateSocioRequest $request, $id): JsonResponse
    {
        try {
            $socio = Socio::find($id);
            if (!$socio) {
                return response()->json(['success' => false, 'message' => 'Socio no encontrado.'], 404);
            }

            $socio->update($request->validated());
            return response()->json(['success' => true, 'message' => 'Socio actualizado correctamente.'], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar socio: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar socio.'], 500);
        }
    }

    // Desactivar socio (soft delete)
    public function destroy($id): JsonResponse
    {
        $socio = Socio::find($id);

        if (!$socio) {
            return response()->json(['success' => false, 'message' => 'Socio no encontrado.'], 404);
        }

        $socio->update(['is_active' => false]);
        return response()->json(['success' => true, 'message' => 'Socio desactivado correctamente.'], 200);
    }
}
