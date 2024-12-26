<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dynamic-form', [FormController::class, 'showForm'])->name('show.form');
    Route::post('/submit-form', [FormController::class, 'submitForm'])->name('submit.form');

    Route::get('/survey', [App\Http\Controllers\SurveyController::class, 'showSurvey'])->name('show.survey');
    Route::post('/submit-survey', [SurveyController::class, 'submitSurvey'])->name('submit.survey');
    Route::any('/survey/bienvenida', [App\Http\Controllers\SurveyController::class, 'showWelcome'])->name('survey.welcome');
    Route::any('/survey/consentimiento', [App\Http\Controllers\SurveyController::class, 'showAdvise'])->name('survey.advise');
    Route::any('/survey/no-consentimiento', [App\Http\Controllers\SurveyController::class, 'showFormNotData'])->name('survey.data.not');

    Route::any('/survey/fichadatos', [App\Http\Controllers\SurveyController::class, 'showFormDataEmployee'])->name('survey.data');

    Route::post('/survey/fichadatos-confirmar', [App\Http\Controllers\SurveyController::class, 'submitFormDataEmploye'])->name('survey.data.confirm');


    Route::get('/users', [UserController::class, 'index']);

});



