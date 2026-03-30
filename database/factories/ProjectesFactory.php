<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projecte>
 */

// COMANDO PARA CREARLO php artisan make:factory ProjecteFactory --model=Projecte

class ProjectesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codi_projecte' => $this->faker->unique()->bothify('PRJ-###'),
            'nom' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'estat' => 'PLANIFICACIO',
            'data_inici' => $this->faker->date(),
            'data_fi_prevista' => $this->faker->date(),
            'pressupost_hores_estimades' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
