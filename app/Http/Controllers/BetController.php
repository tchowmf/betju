<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bet;
use App\Models\User;
use App\Models\Event;

class BetController extends Controller
{

    public function index()
    {
        $events = Event::where('status', 'ativo')
            ->orderBy('time_limit') // Ordena pelo tempo limite
            ->get();
        
        foreach ($events as $event) {
            // Apostas para vencedor
            $totalBets = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->count();
            $player1Bets = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->where('bet_value', $event->player1)->count();
            $player2Bets = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->where('bet_value', $event->player2)->count();
    
            $player1Total = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->where('bet_value', $event->player1)->sum('bet_amount');
            $player2Total = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->where('bet_value', $event->player2)->sum('bet_amount');
    
            $event->player1Percentage = $totalBets > 0 ? ($player1Bets / $totalBets) * 100 : 0;
            $event->player2Percentage = $totalBets > 0 ? ($player2Bets / $totalBets) * 100 : 0;
    
            $event->player1Total = $player1Total;
            $event->player2Total = $player2Total;
    
            // Apostas para games
            $gameIntervals = [
                '0-4' => Bet::where('event_id', $event->id)->where('bet_type', 'games')->where('bet_value', '0-4')->sum('bet_amount'),
                '5-8' => Bet::where('event_id', $event->id)->where('bet_type', 'games')->where('bet_value', '5-8')->sum('bet_amount'),
                '9-12' => Bet::where('event_id', $event->id)->where('bet_type', 'games')->where('bet_value', '9-12')->sum('bet_amount'),
            ];
    
            $event->gameBets = $gameIntervals;
            $event->totalGameBets = array_sum($gameIntervals);
        }
    
        return view('bets.showbets', compact('events'));
    }

    public function inspect($id)
    {
        $bet = Event::findOrFail($id);
        return view('bets.inspectbet', compact('bet'));
    }

    public function campeao()
    {
        // Supondo que você tenha um evento específico para o campeonato
        $event = Event::where('title', 'Quem será CAMPEÃO')->first();

        if (!$event) {
            return redirect()->route('bet.index')->with('error', 'Evento não encontrado.');
        }

        return view('bets.campeao', compact('event'));
    }

    public function storeCAMPEAO(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'bet_type' => 'required|in:winner',
            'bet_value' => 'required',
            'bet_amount' => 'required|numeric|min:15|max:30',
        ]);
    
        $event = Event::findOrFail($request->event_id);
    
        if ($event->status !== 'inativo' || now() > $event->time_limit) {
            return redirect()->route('bet.index')->with('error', 'Não é possível realizar a aposta. Evento inativo ou fora do tempo permitido.');
        }
    
        $user = auth()->user();
        $betAmount = $request->bet_amount;
    
        // Verificar se o usuário tem créditos suficientes
        if ($user->credits < $betAmount) {
            return redirect()->route('bet.index')->with('error', 'JuuuCoins insuficientes para realizar a aposta.');
        }
    
        // Descontar os créditos
        $user->credits -= $betAmount;
        /** @var \App\Models\User $user **/
        $user->save();
    
        // Registrar a aposta
        $bet = new Bet();
        $bet->user_id = $user->id;
        $bet->event_id = $request->event_id;
        $bet->bet_type = $request->bet_type;
        $bet->bet_value = $request->bet_value;
        $bet->bet_amount = $betAmount;
        $bet->save();
    
        return redirect()->route('bet.index')->with('success', 'Aposta realizada com sucesso!');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'bet_type' => 'required|in:winner,games',
            'bet_value' => 'required',
            'bet_amount' => 'required|numeric|min:15|max:30',
        ]);
    
        $event = Event::find($request->event_id);
    
        if ($event->status !== 'ativo' || now() > $event->time_limit) {
            return redirect()->route('bet.index')->with('error', 'Não é possível realizar a aposta. Evento inativo ou fora do tempo permitido.');
        }
    
        $user = auth()->user();
        $betAmount = $request->bet_amount;
    
        // Verificar se o usuário tem créditos suficientes
        if ($user->credits < $betAmount) {
            return redirect()->route('bet.index')->with('error', 'JuuuCoins insuficientes para realizar a aposta.');
        }
    
        // Descontar os créditos
        $user->credits -= $betAmount;
        /** @var \App\Models\User $user **/
        $user->save();
    
        // Registrar a aposta
        $bet = new Bet();
        $bet->user_id = $user->id;
        $bet->event_id = $request->event_id;
        $bet->bet_type = $request->bet_type;
        $bet->bet_value = $request->bet_value;
        $bet->bet_amount = $betAmount;
        $bet->save();
    
        return redirect()->route('bet.index')->with('success', 'Aposta realizada com sucesso!');
    }
    

}
