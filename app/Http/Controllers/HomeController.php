<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
//        return "i m view";
        if(\Auth::user()->isClient()){   
             session(['role' => 'client']);
            return redirect('/clients/active_packages');
        } else if(\Auth::user()->isCoach()){
            session(['role' => 'coach']);
            return redirect('/coaches/active_packages');
        }
        else{
           session(['role' => 'admin']);
            return redirect('/coaches/active_packages');
            //return view('home');
        }
            
    }
}
