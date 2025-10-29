<?php

namespace App\Services;

use App\Models\Contrato;
use App\Models\Socio;
use App\Models\User;
use App\Notifications\ContratoGeneradoNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RegistroSocioService
{
    public function registrarSocio(array $data): array
    {
        DB::beginTransaction();

        try {
            //Validar que el usuario exista
            $user = User::find($data['id_user']);
            if (!$user) {
                return ['success' => false, 'message' => 'El usuario no existe.'];
            }

            //Validar que el correo esté verificado
            if (is_null($user->email_verified_at)) {
                return ['success' => false, 'message' => 'El usuario debe verificar su correo antes de registrar un socio.'];
            }

            // Verificar si ya tiene un socio registrado
            if (Socio::where('id_user', $user->id)->exists()) {
                return ['success' => false, 'message' => 'Este usuario ya tiene un socio registrado.'];
            }

            //Crear socio
            $socio = Socio::create([
                'id_user' => $user->id,
                'numero_socio' => $data['numero_socio'],
                'apellido_paterno' => $data['apellido_paterno'],
                'apellido_materno' => $data['apellido_materno'],
                'sexo' => $data['sexo'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'nacionalidad' => $data['nacionalidad'],
                'curp' => $data['curp'] ?? null,
                'rfc' => $data['rfc'] ?? null,
                'ine' => $data['ine'] ?? null,
                'telefono' => $data['telefono'] ?? null,
                'id_sucursal' => $data['id_sucursal'],
            ]);

            // Generar contrato en PDF
            $pdf = Pdf::loadView('pdf.contrato', [
                'socio' => $socio,
                'user' => $user,
                'fecha' => now()->format('d/m/Y')
            ]);

            $fileName = 'contrato_' . $socio->numero_socio . '.pdf';
            $filePath = 'contratos/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('No se pudo guardar el contrato PDF.');
            }

            // Registrar contrato
            $contrato = Contrato::create([
                'id_socio' => $socio->id,
                'fecha_generacion' => now(),
                'archivo_pdf' => $filePath,
                'is_active' => true,
            ]);

            DB::commit();

            //Enviar contrato al correo del usuario
            $user->notify(new ContratoGeneradoNotification($socio, $filePath));

            return [
                'success' => true,
                'message' => 'Socio registrado correctamente. Contrato enviado por correo.',
                'data' => [
                    'socio' => $socio,
                    'contrato' => $contrato,
                    'correo_enviado' => $user->email
                ]
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar socio: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al registrar socio o enviar correo.'
            ];
        }
    }
}
