<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmpleadoAuthController;


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
    return view('welcome');
});



Route::get('empleado/login', [EmpleadoAuthController::class, 'showLoginForm'])->name('empleado.login');
Route::post('empleado/login', [EmpleadoAuthController::class, 'login']);
Route::post('empleado/logout', [EmpleadoAuthController::class, 'logout'])->name('empleado.logout');

Route::get('empleado/password/reset', [EmpleadoAuthController::class, 'showLinkRequestForm'])->name('empleado.password.request');
Route::post('empleado/password/email', [EmpleadoAuthController::class, 'sendResetLinkEmail'])->name('empleado.password.email');
Route::get('empleado/password/reset/{token}', [EmpleadoAuthController::class, 'showResetForm'])->name('empleado.password.reset');
Route::post('empleado/password/reset', [EmpleadoAuthController::class, 'reset'])->name('empleado.password.update');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth.empleados');
