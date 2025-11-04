<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursales = [
            [
                'nombre' => 'Corporativo Don Bosco',
                'direccion' => 'Av. Insurgentes #210, Col. Centro, San Cristóbal de las Casas, Chiapas',
                'telefono' => '967 678 1122',
                'is_active' => true,
            ],
            [
                'nombre' => 'Sucursal La Merced',
                'direccion' => 'Calle Real de Guadalupe #150, Barrio La Merced, San Cristóbal de las Casas, Chiapas',
                'telefono' => '967 123 4567',
                'is_active' => true,
            ],
            [
                'nombre' => 'Sucursal María Auxiliadora',
                'direccion' => 'Av. Diego Dugelay #98, Col. María Auxiliadora, San Cristóbal de las Casas, Chiapas',
                'telefono' => '967 765 4321',
                'is_active' => true,
            ],
        ];

        foreach ($sucursales as $data) {
            Sucursal::create($data);
        }
    }
}
