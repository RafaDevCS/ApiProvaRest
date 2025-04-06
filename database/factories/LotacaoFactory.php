<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lotacao>
 */
class LotacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lot_data_lotacao'=> fake()->date(),
            'lot_data_remocao'=> fake()->date(),
            'lot_portaria' => fake()->name(),
            'pes_id' => 1,
            'unid_id' => 1,
        ];
    }
}
