<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocioRequest;
use App\Http\Requests\UpdateSocioRequest;
use App\Models\Contrato;
use App\Models\Socio;
use App\Notifications\ContratoGeneradoNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SocioController extends Controller
{
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
        try {
            $data = $request->validated();

            // Crear el socio
            $socio = Socio::create($data);

            // Generar el contrato en PDF con los datos del socio
            $pdf = Pdf::loadView('pdf.contrato', [
                'socio' => $socio,
                'fecha' => now()->format('d/m/Y'),
            ]);

            // Definir el nombre y ruta del archivo PDF
            $fileName = 'contrato_' . $socio->numero_socio . '.pdf';
            $filePath = 'contratos/' . $fileName;

            // Guardar el archivo en storage/app/public/contratos
            Storage::disk('public')->put($filePath, $pdf->output());

            // Registrar el contrato en la base de datos
            $contrato = Contrato::create([
                'socio_id' => $socio->id,
                'fecha_firma' => now(),
                'archivo_contrato' => $filePath,
                'is_active' => true,
            ]);

            // Enviar el contrato por correo electrónico
            if (!empty($socio->email)) {
                $socio->notify(new ContratoGeneradoNotification($socio, $filePath));
            }

            return response()->json([
                'success' => true,
                'message' => 'Socio registrado, contrato generado y enviado correctamente.',
                'data' => [
                    'socio' => $socio,
                    'contrato' => $contrato,
                ],
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al registrar socio: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar socio o enviar contrato.',
            ], 500);
        }
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
