<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */

// COMANDO PARA CREARLO php artisan make:factory ClientFactory --model=Client
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->company(),
            'cif' => $this->faker->unique()->bothify('??########'),
            'email_contacte' => $this->faker->companyEmail(),
            'telefon' => $this->faker->phoneNumber(),
            'direccio' => $this->faker->address(),
            'actiu' => true,
        ];
    }
}
