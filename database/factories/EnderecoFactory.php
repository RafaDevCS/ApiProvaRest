<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'end_tipo_logradouro' => fake()->name(),
            'end_logradouro' => fake()->name(),
            'end_numero' => fake()->randomNumber(5),
            'end_bairro' => fake()->name(),
            'cid_id' => 5,        
        ];
    }
}
