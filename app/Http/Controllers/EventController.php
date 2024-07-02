<?php

namespace App\Http\Controllers;

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
        ]);

        Event::create([
            'title' => $request->title,
            'player1' => $request->player1,
            'player2' => $request->player2,
        ]);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
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
        ]);

        $event->update([
            'title' => $request->title,
            'player1' => $request->player1,
            'player2' => $request->player2,
        ]);

        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento excluído com sucesso!');
    }
}
