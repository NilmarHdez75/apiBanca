<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuenta>
 */
class CuentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_socio' => Socio::factory(),
            'tipo_cuenta' => $this->faker->randomElement(['ahorro', 'crédito']),
            'saldo' => $this->faker->randomFloat(2, 100, 10000),
            'fecha_apertura' => $this->faker->date(),
            'is_active' => true,
        ];
    }
}
