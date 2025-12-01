<?php

namespace App\Http\Controllers\Validated;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocioValidationController extends Controller
{
    public function validateUnique(Request $request): JsonResponse
    {
        $campo = $request->get('campo');
        $valor = $request->get('valor');

        if (!in_array($campo, ['curp', 'rfc', 'ine'])) {
            return response()->json([
                'success' => false,
                'message' => 'Campo no permitido.'
            ], 400);
        }

        if (!$valor || $valor === "") {
            return response()->json([
                'success' => true,
                'isUnique' => true
            ]);
        }

        $exists = Socio::where($campo, $valor)->exists();

        return response()->json([
            'success' => true,
            'isUnique' => !$exists
        ]);
    }
}
