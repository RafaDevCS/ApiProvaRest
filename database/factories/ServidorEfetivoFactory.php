<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServidorEfetivo>
 */
class ServidorEfetivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pes_id' => 1,
            'se_matricula'=> fake()->lexify('????????????????????'),
        ];
    }
}
