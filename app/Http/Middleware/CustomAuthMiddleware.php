<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,...$guards)
    {
        if (session()->has('authenticated_empleado')) { 
            $empleado = session('authenticated_empleado');
            if ($empleado) { 
                Auth::guard('empleados')->setUser($empleado); 
                \Log::info('Usuario atenticado en el middleware: ' . $empleado->cedula); } 
            } 
            if (Auth::guard('empleados')->check()) { 
                return $next($request); 
            }     
            \Log::info('Usuario no es autenticado en el middleware, redireccionando'); 
            return redirect()->route('empleado.login');
    } 
}    
      
