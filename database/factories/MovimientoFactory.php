<?php

namespace Database\Factories;

use App\Models\Cuenta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movimiento>
 */
class MovimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_cuenta' => Cuenta::factory(),
            'tipo_movimiento' => $this->faker->randomElement(['deposito', 'retiro']),
            'monto' => $this->faker->randomFloat(2, 50, 5000),
            'fecha_movimiento' => $this->faker->dateTimeThisYear(),
            'is_active' => true,
        ];
    }
}
