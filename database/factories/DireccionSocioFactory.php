<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DireccionSocio>
 */
class DireccionSocioFactory extends Factory
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
            'calle' => $this->faker->streetName(),
            'numero_ext' => $this->faker->buildingNumber(),
            'numero_int' => $this->faker->optional()->buildingNumber(),
            'colonia' => $this->faker->word(),
            'municipio' => $this->faker->city(),
            'estado' => $this->faker->state(),
            'cp' => $this->faker->postcode(),
            'pais' => 'México',
            'is_active' => true,
        ];
    }
}
