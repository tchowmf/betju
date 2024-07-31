<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bet>
 */
class BetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'event_id' => \App\Models\Event::factory(),
            'bet_type' => $this->faker->randomElement(['winner', 'games']),
            'bet_value' => $this->faker->randomElement(['player1', 'player2', '0-4', '5-8', '9-12']),
            'bet_amount' => 45, // Valor da aposta padrão
        ];
    }
}
