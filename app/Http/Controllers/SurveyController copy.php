<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{   
    public function index(){
        return view('encuestas.inicio');
    }

    public function showSurvey()
    {
        $questions = [
            [
                'id' => 1,
                'text' => 'How often do you exercise?',
                'options' => [
                    'always' => 'Always',
                    'often' => 'Often',
                    'hardly' => 'Hardly',
                    'never' => 'Never'
                ]
            ],
            [
                'id' => 2,
                'text' => 'How frequently do you eat healthy food?',
                'options' => [
                    'always' => 'Always',
                    'often' => 'Often',
                    'hardly' => 'Hardly',
                    'never' => 'Never'
                ]
            ]
        ];

        return view('encuesta.secciones', compact('questions'));
    }

    public function submitSurvey(Request $request)
    {
        $validatedData = $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'in:always,often,hardly,never'
        ]);

        // Process survey responses
        dd($validatedData);
    }

    public function showFormDataEmployee()
    {
        // Provide any pre-populated data if needed
        $departments = [
            'IT' => 'Information Technology',
            'HR' => 'Human Resources',
            'Finance' => 'Finance Department'
        ];

        return view('encuesta.fichadatos', compact('departments'));
    }

    public function submitFormDataEmploye(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'department' => 'required|in:IT,HR,Finance',
            'birthdate' => 'required|date',
            'comments' => 'nullable|string',
            'interests' => 'array',
            'subscription' => 'nullable|string'
        ]);

        // Process the form data (e.g., save to database)
        dd($validatedData); // Dump and die to show submitted data
    }

    public function showFormNotData(){
        return view('encuesta.noConsentimiento');
    }
    
    public function showWelcome(){
        return view('encuesta.bienvenida');
    }

    public function showAdvise(){
        return view('encuesta.consentimiento');
    }

    public function showTerms(){
        return view('encuesta.terminos');
    }
}
