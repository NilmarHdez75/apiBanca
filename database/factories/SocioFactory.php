<?php

namespace Database\Factories;

use App\Models\Beneficiario;
use App\Models\Contrato;
use App\Models\Cuenta;
use App\Models\DireccionSocio;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Socio>
 */
class SocioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'numero_socio' => '12-10-' . $this->faker->unique()->numerify('#####'),
            'apellido_paterno' => $this->faker->lastName(),
            'apellido_materno' => $this->faker->lastName(),
            'genero' => $this->faker->randomElement(['M', 'F']),
            'fecha_nacimiento' => $this->faker->date(),
            'nacionalidad' => 'Mexicana',
            'curp' => strtoupper($this->faker->bothify('????######??????')),
            'rfc' => strtoupper($this->faker->bothify('???######???')),
            'ine' => strtoupper($this->faker->bothify('#############')),
            'telefono' => $this->faker->phoneNumber(),
            'id_sucursal' => Sucursal::inRandomOrder()->first()?->id_sucursal ?? 1,
            'is_active' => true,
        ];

    }

    public function configure()
    {
        return $this->afterCreating(function ($socio) {
            DireccionSocio::factory()->create(['id_socio' => $socio->id_socio]);
            Beneficiario::factory(2)->create(['id_socio' => $socio->id_socio]);
            //Contrato::factory()->create(['id_socio' => $socio->id_socio]);
            $cuenta = Cuenta::factory()->create(['id_socio' => $socio->id_socio]);
            \App\Models\Movimiento::factory(3)->create(['id_cuenta' => $cuenta->id_cuenta]);
        });
    }
}
