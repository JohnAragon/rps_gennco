<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.empleados');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        \Log::info('HomeController - Auth: ' . Auth::check()); 
        \Log::info('HomeController - User: ' . Auth::user());
        if (auth()->check()) { 
            \Log::info('User is authenticated'); 
        } 
        else { 
            \Log::info('User is not authenticated'); 
        }
        return view('home');
    }
}
