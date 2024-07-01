<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bet;
use App\Models\Event;

class BetController extends Controller
{

    public function index()
    {
        $events = Event::all();
        return view('bets.showbets', compact('events'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $betAmount = 15 * $request->bet_value;

        if ($user->credits < $betAmount) {
            return response()->json(['error' => 'Créditos insuficientes'], 400);
        }

        DB::transaction(function () use ($user, $request, $betAmount) {
            // Subtrair créditos do usuário
            $user->credits -= $betAmount;

            /** @var \App\Models\User $user **/
            $user->save();

            // Registrar a aposta
            Bet::create([
                'user_id' => $user->id,
                'bet_type' => $request->bet_type,
                'bet_value' => $request->bet_value,
                'bet_amount' => $betAmount,
            ]);
        });

        return response()->json(['success' => 'Aposta realizada com sucesso!']);
    }

    public function processResults($matchId, $result)
    {
        $bets = Bet::where('match_id', $matchId)->get();

        $totalBetAmount = $bets->sum('bet_amount');

        $winnerBets = $bets->where('bet_type', 'winner')->where('bet_value', $result['winner']);
        $loserBets = $bets->where('bet_type', 'games')->where('bet_value', $result['games']);

        $totalWinnerBets = $winnerBets->sum('bet_amount');
        $totalLoserBets = $loserBets->sum('bet_amount');

        $totalWinners = $winnerBets->count();
        $totalLosers = $loserBets->count();

        // Distribuir prêmios
        DB::transaction(function () use ($winnerBets, $loserBets, $totalWinnerBets, $totalLoserBets, $totalWinners, $totalLosers) {
            if ($totalWinners > 0) {
                $winnings = ($totalLoserBets + $totalWinnerBets) / $totalWinners;
                foreach ($winnerBets as $bet) {
                    $user = $bet->user;
                    $user->credits += $winnings;
                    $user->save();
                }
            }

            if ($totalLosers > 0) {
                $winnings = ($totalWinnerBets + $totalLoserBets) / $totalLosers;
                foreach ($loserBets as $bet) {
                    $user = $bet->user;
                    $user->credits += $winnings;
                    $user->save();
                }
            }
        });
    }


}
