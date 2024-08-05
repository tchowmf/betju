<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function edit(User $user)
    {
        return view('account-manager.acc-form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|integer',
        ]);

        $user->username = $request->username;
        
        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }
        
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Conta atualizada com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard')->with('success', 'Conta excluída com sucesso!');
    }
}
