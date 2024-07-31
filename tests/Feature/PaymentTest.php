<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Bet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_refund_single_bet_if_no_opposing_bets()
    {
        $user = User::factory()->create(['credits' => 100]);
        $event = Event::factory()->create([
            'status' => 'resolvido',
            'winner' => 'player1',
            'loser_games' => 5
        ]);

        Bet::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'bet_type' => 'games',
            'bet_value' => '0-4',
            'bet_amount' => 45
        ]);

        $event->distributeWinnings();

        $user = $user->fresh();
        $this->assertEquals(145, $user->credits);
    }

    /** @test */
    public function it_should_distribute_correctly_with_opposing_bets()
    {
        $user1 = User::factory()->create(['credits' => 100]);
        $user2 = User::factory()->create(['credits' => 100]);
        $event = Event::factory()->create([
            'status' => 'resolvido',
            'winner' => 'player1',
            'loser_games' => 5
        ]);

        Bet::factory()->create([
            'user_id' => $user1->id,
            'event_id' => $event->id,
            'bet_type' => 'winner',
            'bet_value' => 'player1',
            'bet_amount' => 45
        ]);

        Bet::factory()->create([
            'user_id' => $user2->id,
            'event_id' => $event->id,
            'bet_type' => 'winner',
            'bet_value' => 'player2',
            'bet_amount' => 45
        ]);

        $event->distributeWinnings();

        $user1 = $user1->fresh();
        $user2 = $user2->fresh();

        $this->assertEquals(145, $user1->credits); // 100 - 45 + 90
        $this->assertEquals(55, $user2->credits);  // 100 - 45
    }
}