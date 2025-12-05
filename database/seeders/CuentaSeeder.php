<?php

namespace Database\Seeders;

use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Database\Seeder;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socioId = 5;

        $cuentas = Cuenta::factory()
            ->count(3)
            ->create([
                'socio_id' => $socioId
            ]);

        foreach ($cuentas as $cuenta) {
            Movimiento::factory()
                ->count(15)
                ->create([
                    'cuenta_id' => $cuenta->id
                ]);
        }
    }
}
