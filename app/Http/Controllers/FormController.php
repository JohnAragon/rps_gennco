// app/Http/Controllers/FormController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function showForm()
    {
        // Provide any pre-populated data if needed
        $departments = [
            'IT' => 'Information Technology',
            'HR' => 'Human Resources',
            'Finance' => 'Finance Department'
        ];

        return view('dynamic-form', compact('departments'));
    }

    public function submitForm(Request $request)
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
}