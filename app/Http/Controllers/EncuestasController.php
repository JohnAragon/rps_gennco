<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Config;

class EncuestasController extends Controller
{
    public function index(){
        $user = Auth::user();

            if ($user->terminos == config('constants.TERMINOS_EN_ESPERA')){
                return redirect()->route('inicio');
            }    
            
            if($user->consentimiento == config('constants.CONSENTIMIENTO_EN_ESPERA')){
                return redirect()->route('encuesta.consentimiento');
            }
                
            if ($user->consentimiento == config('constants.CONSENTIMIENTO_SI')){
                return redirect()->route('encuesta.fichadatos');
            }            
    }

    public function mostrarAdvertencia(){
        return view('encuesta.advertencia');
    }

    public function mostrarTerminos(){
        return view('encuesta.terminos');
    }

    public function mostrarConsentimiento(){
        return view('encuesta.consentimiento');
    } 

    public function mostrarNoConsentimiento(){
        return view('encuesta.finencuesta');
    }
    
    public function aceptarTerminos(Request $request){
        $user_registro = Auth::user()->registro;
        try{
            Empleado::where('registro',$user_registro)
            ->update(['terminos'=>$request->input('terminos')]); 
            
        }catch(ModelNotFoundException $exception){
            Log::error('Empleado no encontrado: ', $exception);
            return back()->withError(config('MENSAJE_ERROR_MODELO_NOT_FOUND'))->withInput(); 
        }
       
        return redirect()->route('encuesta.consentimiento');
    }

 

    public function aceptarConsentimiento(Request $request){
        $user_registro = Auth::user()->registro;
        try{
            Empleado::where('registro',$user_registro)
                ->update([
                        'consentimiento' => $request->input('consentimiento'),
                        'habilitado' => config('constants.CONSENTIMIENTO_COMPLETO'),
                        'llave' => config('constants.CONSENTIMIENTO_LLAVE')
                    ]);      
             
        }catch(ModelNotFoundException $exception){
            Log::error('Empleado no encontrado: ', $exception);
            return back()->withError(config('MENSAJE_ERROR_MODELO_NOT_FOUND'))->withInput();
        }

        if($request->consentimiento == config('constants.CONSENTIMIENTO_SI')){
            return redirect()->route('encuesta.fichadatos');
        }else{
          return redirect()->intended('encuesta/no-consentimiento');
    
       }
    }   
    public function mostrarFichadatos()
    {
        // Provide any pre-populated data if needed
        $departments = [
            'IT' => 'Information Technology',
            'HR' => 'Human Resources',
            'Finance' => 'Finance Department'
        ];

        return view('encuesta.fichadatos', compact('departments'));
    }

    public function confirmaFichadatos(){

    }


}
