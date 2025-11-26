<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::where('is_active', true)
            ->select('id', 'nombre', 'direccion', 'telefono')
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sucursales
        ]);
    }
}
