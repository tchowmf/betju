<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bet;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $wonBetsCount = $user->wonBetsCount();
        $netEarnings = $user->netEarnings();

        return view('profile.index', compact('user', 'wonBetsCount', 'netEarnings'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.update-password', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function userBets(Request $request)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $status = $request->query('status', 'ativas');
    
        $bets = Bet::where('user_id', $user->id)
                    ->whereHas('event', function($query) use ($status) {
                        if ($status == 'ativas') {
                            $query->where('status', 'ativo');
                        } else {
                            $query->where('status', 'resolvido');
                        }
                    })
                    ->get();
    
        return view('profile.bets', compact('user', 'bets', 'status'));
    }  
    
    public function updateBet(Request $request, $id)
    {
        $bet = Bet::findOrFail($id);
        
        if ($bet->event->status == 'ativo' && $bet->event->time_limit > now()) {
            $bet->bet_value = $request->input('bet_value');
            $bet->bet_type = $request->input('bet_type');
            $bet->save();
            
            return redirect()->route('profile.userBets', ['status' => 'ativas'])->with('success', 'Aposta atualizada com sucesso!');
        }
        
        return redirect()->route('profile.userBets', ['status' => 'ativas'])->with('error', 'Não foi possível atualizar a aposta.');
    }

    public function cancelBet($id)
    {
        $bet = Bet::findOrFail($id);

        // Verifica se a aposta pode ser cancelada
        if ($bet->event->status == 'ativo' && $bet->event->time_limit > now()) {
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $user->credits += $bet->bet_amount;
            $user->save();
            
            $bet->delete();
            
            return redirect()->route('profile.userBets', ['status' => 'ativas'])->with('success', 'Aposta cancelada com sucesso!');
        }

        return redirect()->route('profile.userBets', ['status' => 'ativas'])->with('error', 'Não foi possível cancelar a aposta.');
    }


}
