<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index($id): View
    {
        $userrole = Auth()->user()->role->name;

        if($userrole == 'admin'){
            $users = User::find($id);
            return view('transaction.transfer-form', compact('users'));
        }else {
            $events = Event::all();
            return view('bets.showbets', compact('events'))->with('error', 'Não tem autorização');
        }
    }

    public function transaction(Request $request, $id)
    {
        $request->validate([
            'transaction_type' => 'required|in:deposit,withdraw',
            'transaction_value' => 'required|numeric|min:0.01'
        ]);
        
        $user = User::findOrFail($id);
        $type = $request->transaction_type;
        $value = $request->transaction_value;

        if ($type == 'deposit') {
            $user->credits += $value;
            $message = 'R$' . number_format($value, 2) . ' foram depositados na sua conta!';
            $type = 'deposit';
        } elseif ($type == 'withdraw') {
            if ($user->credits < $value) {
                return redirect()->back()->with('error', 'Saldo insuficiente para a retirada.');
            }
            $user->credits -= $value;
            $message = 'R$' . number_format($value, 2) . ' foram retirados da sua conta!';
            $type = 'withdraw';
        }

        $user->save(); // Salva as mudanças no saldo do usuário

        // Registrar a transação
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->transaction_value = $request->transaction_value;
        $transaction->save();

        // Enviar notificação
        $details = [
            'message' => $message,
            'action' => route('transaction', $user->id),
            'type' => $type
        ];

        $user->notify(new UserNotification($details));

        return redirect()->route('dashboard')->with('success', 'Transação realizada com sucesso!');
    }

}
