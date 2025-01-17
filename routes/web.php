<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmpleadoAuthController;
use App\Http\Controllers\EncuestasController;

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

Route::get('/', function () {
    return view('auth.empleado-login');
});



Route::get('empleado/login', [EmpleadoAuthController::class, 'showLoginForm'])->name('empleado.login');
Route::post('empleado/login', [EmpleadoAuthController::class, 'login']);
Route::post('empleado/logout', [EmpleadoAuthController::class, 'logout'])->name('empleado.logout');

Route::get('empleado/password/reset', [EmpleadoAuthController::class, 'showLinkRequestForm'])->name('empleado.password.request');
Route::post('empleado/password/email', [EmpleadoAuthController::class, 'sendResetLinkEmail'])->name('empleado.password.email');
Route::get('empleado/password/reset/{token}', [EmpleadoAuthController::class, 'showResetForm'])->name('empleado.password.reset');
Route::post('empleado/password/reset', [EmpleadoAuthController::class, 'reset'])->name('empleado.password.update');

Route::get('/inicio', [EncuestasController::class, 'index'])->name('encuesta.inicio')->middleware('auth.empleados');
Route::get('/encuesta/advertencia', [EncuestasController::class, 'mostrarAdvertencia'])->name('encuesta.advertencia')->middleware('auth.empleados');
Route::get('/encuesta/terminos', [EncuestasController::class, 'mostrarTerminos'])->name('encuesta.terminos')->middleware('auth.empleados');

/*Route::any('/encuesta', [App\Http\Controllers\SurveyController::class, 'showSurvey'])->name('encuesta.secciones');
Route::any('/encuesta-confirmar', [App\Http\Controllers\SurveyController::class, 'submitSurvey'])->name('encuesta.secciones');
Route::any('/encuesta/consentimiento', [App\Http\Controllers\SurveyController::class, 'showAdvise'])->name('encuesta.consentimiento');
Route::any('/encuesta/no-consentimiento', [App\Http\Controllers\SurveyController::class, 'showFormNotData'])->name('encuesta.noconsentimiento');
Route::any('/encuesta/fichadatos', [App\Http\Controllers\SurveyController::class, 'showFormDataEmployee'])->name('encuesta.confirmada');
Route::any('/encuesta/fichadatos-confirmar', [App\Http\Controllers\SurveyController::class, 'submitFormDataEmploye'])->name('survey.encuesta.confirm');
*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth.empleados');
