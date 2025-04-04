<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pes_nome' => fake()->name(),
            'pes_data_nascimento' => fake()->date(),
            'pes_sexo' => fake()->lexify('?????????'),
            'pes_mae' => fake()->name(),
            'pes_pai' => fake()->name(),
        ];
    }
}
