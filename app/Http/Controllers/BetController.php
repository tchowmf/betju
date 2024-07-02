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
        $events = Event::all();
        return view('bets.showbets', compact('events'));
    }

    public function inspect($id)
    {
        $bet = Event::findOrFail($id);
        return view('bets.inspectbet', compact('bet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'bet_type' => 'required|in:winner,games',
            'bet_value' => 'required',
            'bet_amount' => 'required|numeric|min:15|max:30',
        ]);

        $user = auth()->user();
        $betAmount = $request->bet_amount;

        // Verificar se o usuário tem créditos suficientes
        if ($user->credits < $betAmount) {
            return redirect()->route('bet.index')->with('error', 'Créditos insuficientes para realizar a aposta.');
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
