<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncuestasController extends Controller
{
    public function index(){

        return view('encuesta.inicio');
    }
}
