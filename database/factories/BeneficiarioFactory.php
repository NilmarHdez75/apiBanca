<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiario>
 */
class BeneficiarioFactory extends Factory
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
            'nombre' => $this->faker->firstName(),
            'apellido_paterno' => $this->faker->lastName(),
            'apellido_materno' => $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->date(),
            'parentesco' => $this->faker->randomElement(['Padre', 'Madre', 'Hijo', 'Cónyuge']),
            'porcentaje' => $this->faker->randomFloat(2, 10, 100),
            'is_active' => true,
        ];
    }
}
