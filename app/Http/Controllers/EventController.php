<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $userrole=Auth()->user()->role->name;
        
        if($userrole == 'admin')
        {
            $events = Event::all();
            return view('events.events', compact('events'));
        }
        else
        {
            $events = Event::all();
            return view('bets.showbets', compact('events'))->with('error', 'Não tem autorização');
        }
    }

    public function create(): View
    {
        $userrole=Auth()->user()->role->name;
        
        if($userrole == 'admin')
        {
            return view('events.create-event');
        }
        else
        {
            $events = Event::all();
            return view('bets.showbets', compact('events'))->with('error', 'Não tem autorização');
        } 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'player1' => 'required|string|max:255',
            'player2' => 'required|string|max:255',
            'status' => 'required|in:ativo,inativo,resolvido',
            'time_limit' => 'required|date',
        ]);

        Event::create([
            'title' => $request->title,
            'player1' => $request->player1,
            'player2' => $request->player2,
            'status' => $request->status,
            'time_limit' => $request->time_limit,
        ]);

        return redirect()->route('dashboard')->with('success', 'Evento criado com sucesso!');
    }

    public function edit(Event $event)
    {
        return view('events.edit-event', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'player1' => 'required|string|max:255',
            'player2' => 'required|string|max:255',
            'status' => 'required|in:ativo,inativo,resolvido',
            'time_limit' => 'required|date',
        ]);

        $event->update([
            'title' => $request->title,
            'player1' => $request->player1,
            'player2' => $request->player2,
            'status' => $request->status,
            'time_limit' => $request->time_limit,
        ]);

        return redirect()->route('dashboard')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('dashboard')->with('success', 'Evento excluído com sucesso!');
    }

    public function distributeWinnings(Event $event)
    {
        if ($event->status !== 'resolvido' || !$event->winner) {
            return;
        }

        $winner = $event->winner;
        $gamesLoser = $event->loser_games;

        // Distribuição para apostas do vencedor
        $totalAmountWinner = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->sum('bet_amount');
        $winningBetsWinner = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->where('bet_value', $winner)->get();
        $losingBetsWinner = Bet::where('event_id', $event->id)->where('bet_type', 'winner')->where('bet_value', '!=', $winner)->sum('bet_amount');

        if ($winningBetsWinner->count() > 0) {
            $winningAmountPerUserWinner = $losingBetsWinner / $winningBetsWinner->count();

            foreach ($winningBetsWinner as $bet) {
                $user = $bet->user;
                $user->credits += $bet->bet_amount + $winningAmountPerUserWinner;
                $user->save();
            }
        }

        // Distribuição para apostas de games perdedor
        $totalAmountGames = Bet::where('event_id', $event->id)->where('bet_type', 'games')->sum('bet_amount');
        $winningBetsGames = Bet::where('event_id', $event->id)->where('bet_type', 'games')->where(function ($query) use ($gamesLoser) {
            if ($gamesLoser <= 4) {
                $query->where('bet_value', '0-4');
            } elseif ($gamesLoser <= 8) {
                $query->where('bet_value', '5-8');
            } elseif ($gamesLoser <= 12) {
                $query->where('bet_value', '9-12');
            }
        })->get();
        $losingBetsGames = Bet::where('event_id', $event->id)->where('bet_type', 'games')->where(function ($query) use ($gamesLoser) {
            if ($gamesLoser <= 4) {
                $query->where('bet_value', '!=', '0-4');
            } elseif ($gamesLoser <= 8) {
                $query->where('bet_value', '!=', '5-8');
            } elseif ($gamesLoser <= 12) {
                $query->where('bet_value', '!=', '9-12');
            }
        })->sum('bet_amount');

        if ($winningBetsGames->count() > 0) {
            $winningAmountPerUserGames = $losingBetsGames / $winningBetsGames->count();

            foreach ($winningBetsGames as $bet) {
                $user = $bet->user;
                $user->credits += $bet->bet_amount + $winningAmountPerUserGames;
                $user->save();
            }
        }
    }   

    public function resolveGet(Event $event): View
    {
        return view('events.resolve-event', compact('event'));
    }

    public function resolve(Request $request, $id)
    {
        $event = Event::find($id);
        $event->status = 'resolvido';
        $event->winner = $request->input('winner');
        $event->loser_games = $request->input('loser_games');
        $event->save();
    
        $this->distributeWinnings($event);
    
        return redirect()->route('dashboard')->with('success', 'Evento resolvido e pagamentos distribuídos.');
    }

    public function refundBets(Event $event)
    {
        // Obter todas as apostas relacionadas ao evento
        $bets = Bet::where('event_id', $event->id)->get();

        foreach ($bets as $bet) {
            $user = $bet->user;
            $user->credits += $bet->bet_amount; // Estornar o valor apostado
            $user->save();
        }
    }

    public function cancelEvent(Request $request, $id)
    {
        $event = Event::find($id);
        $event->status = 'cancelado'; // Atualizar o status para "cancelado"
        $event->save();

        $this->refundBets($event);

        return redirect()->route('dashboard')->with('success', 'Evento cancelado e apostas estornadas.');
    }


}
