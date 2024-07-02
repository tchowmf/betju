<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $userrole=Auth()->user()->role->name;
            
            if($userrole == 'admin')
            {
                return view('events.createevent');
            }

            if($userrole == 'gambler')
            {
                return view('events.showbets');
            }

            else
            {
                return redirect()->back();
            }
        }
    }
}
