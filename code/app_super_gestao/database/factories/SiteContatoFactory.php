<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteContato>
 */
class SiteContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     * php artisan make:factory SiteContatoFactory --model=SiteContato
     * php artisan db:seed --class=SiteContatoSeeder
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nome' => $this->faker->name(),
           'telefone' => $this->faker->phoneNumber(),
           'email' => $this->faker->unique()->safeEmail(),
           'motivo_contato' => $this->faker->numberBetween(1,3),
           'mensagem' => $this->faker->text(200),
        ];
    }
}
