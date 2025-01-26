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
Route::post('/encuesta/terminos/aceptar', [EncuestasController::class, 'aceptarTerminos'])->name('encuesta.terminos.aceptar')->middleware('auth.empleados');
Route::get('/encuesta/consentimiento', [EncuestasController::class, 'mostrarConsentimiento'])->name('encuesta.consentimiento')->middleware('auth.empleados');
Route::get('/encuesta/no-consentimiento', [EncuestasController::class, 'mostrarNoConsentimiento'])->name('encuesta.no-consentimiento')->middleware('auth.empleados');
Route::post('/encuesta/consentimiento/aceptar', [EncuestasController::class, 'aceptarConsentimiento'])->name('encuesta.consentimiento.aceptar')->middleware('auth.empleados');
Route::get('/encuesta/fichadatos', [EncuestasController::class, 'mostrarFichadatos'])->name('encuesta.fichadatos')->middleware('auth.empleados');
Route::post('/encuesta/fichadatos/confirmar',[EncuestasController::class, 'confirmaFichadatos'])->name('encuesta.fichadatos.confirmar')->middleware('auth.empleados');
Route::get('/encuesta/municipios/{departamento}',[EncuestasController::class, 'obtenerMunicipios'])->name('encuesta.municipios')->middleware('auth.empleados');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth.empleados');
