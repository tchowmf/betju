<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'status' => 'ativo', // Status padrão
            'winner' => null, // Defina o vencedor como null por padrão
            'loser_games' => $this->faker->numberBetween(0, 12), // Número aleatório de games perdidos
            'time_limit' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'player1' => 'player1_name', // Valor padrão para player1
            'player2' => 'player2_name', // Valor padrão para player2
        ];
    }
}
