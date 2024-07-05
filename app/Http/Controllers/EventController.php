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
            return view('events.createevent');
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
        return view('events.editevent', compact('event'));
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
    
        $totalAmount = Bet::where('event_id', $event->id)->sum('bet_amount');
        $winningBets = Bet::where('event_id', $event->id)->where('bet_value', $winner)->get();
        $losingBets = Bet::where('event_id', $event->id)->where('bet_value', '!=', $winner)->sum('bet_amount');
    
        if ($winningBets->count() > 0) {
            $winningAmountPerUser = $losingBets / $winningBets->count();
    
            foreach ($winningBets as $bet) {
                $user = $bet->user;
                $user->credits += $bet->bet_amount + $winningAmountPerUser;
                $user->save();
            }
        }
    }    

    public function resolve(Request $request, $id)
    {
        $event = Event::find($id);
        $event->status = 'resolvido';
        $event->winner = $request->input('winner');
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
