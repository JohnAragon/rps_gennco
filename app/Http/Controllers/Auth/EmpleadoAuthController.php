<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class EmpleadoAuthController extends Controller
{

    // Login
    public function showLoginForm()
    {
        return view('auth.empleado-login');

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt: ', $request->all());

        // Define validation rules
         $rules = [
             'cedula' => ['required', 'string', 'min:4', 'max:20'], // Customize rules as needed
             'contrasena' => ['required', 'string','min:4','max:20'], // Minimum password length of 
         ];

         // Validate the request
         $validator = Validator::make($request->all(), $rules);

         if ($validator->fails()) {
             return back()->withErrors($validator)->withInput();
         }

        $credentials = $request->only('cedula', 'contrasena');

       // Custom authentication logic for empleados
       $empleado = Empleado::where('cedula', $credentials['cedula'])
        ->where('habilitado','habilitado')
        ->where('llave','nada')
        ->first();
       

       Log::info('Empleado encontrado: ', ['empleado' => $empleado]);
       

        if ($empleado && Auth::attempt(['cedula' => $credentials['cedula'], 'contrasena' => $credentials['contrasena']])) {
            session(['authenticated_empleado_id' => Auth::guard('empleados')->user()->registro]);
            return redirect()->intended('/inicio');
        }else{
            $empleado = Empleado::where('cedula', $request->cedula)
            ->where('habilitado','completo')
            ->where('llave','terminado')
            ->first();

            if ($empleado){
                return back()->withErrors([
                    'cedula' => 'El usuario registrado ya ha completado la encuesta',
                ]); 
            }else{
                return back()->withErrors([
                    'cedula' => 'Los datos ingresados no coinciden con nuestros registros',
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/empleado/login');
    }

    // Password Reset
    public function showLinkRequestForm()
    {
        return view('auth.empleado-password-request');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['cedula' => 'required|string|exists:empleados,cedula']);

        $status = Password::sendResetLink(
            $request->only('cedula')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['cedula' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.empleado-reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|exists:empleados,cedula',
            'contrasena' => 'required|string|confirmed|min:6',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('cedula', 'contrasena', 'token'),
            function ($empleado, $contrasena) {
                $empleado->forceFill([
                    'contrasena' => $contrasena,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('empleado.login')->with('status', __($status))
            : back()->withErrors(['cedula' => [__($status)]]);
    }

    protected function redirectTo() { 
        return '/inicio'; 
    }

}
