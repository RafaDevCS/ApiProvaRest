<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            PessoaSeeder::class,
            UnidadeSeeder::class,
            CidadeSeeder::class,

        ]);

        $this->call([
            EnderecoSeeder::class,
        ]);

        /*User::factory()->create([
            'name' => 'Rafael Morais',
            'email' => 'rafael@mail.com',
            'password' => '1234',
        ]);*/
    }
}
