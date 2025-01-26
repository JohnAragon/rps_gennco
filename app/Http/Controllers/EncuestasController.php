<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use App\Models\Fichadato;
use App\Models\Departamento;
use App\Models\Municipio;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\FichadatosValidacion;

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
        $departamentos = Departamento::all();

        $hoy = Carbon::now()->format('Y');
        $inicio_anio = $hoy-100;
        $fin_anio = $hoy-16;

        $anios = [];
        for($i = $inicio_anio;  $i<= $fin_anio; $i++){
            $anios[] = $i;
        }
        return view('encuesta.fichadatos', compact('departamentos', 'anios'));
    }

    public function confirmaFichadatos(FichadatosValidacion $request){
         // All validated data
         $validatedData = $request->validated();
       
         $additionalData = $request->only(['empresas', 'sede', 'nombre','cedula','lugartrabajodpto','lugartrabajocity', 'nombredepto', 'registro','periodo','cargoempresa','tablacontestada']);
         $edad = Carbon::now()->format('Y') - $validatedData['anonaci'];
         $additionalData['edad']   = $edad;
       
        // Merge validated and additional data
         $data = array_merge($validatedData, $additionalData);
         
        try {
   
            // Store in the database
            Fichadato::create($data);

            return redirect()->route('encuesta.fichadatos')->with('success', '¡Sus datos fueron registrados!');
        } catch (Exception $exception) {
            Log::error('Error registrando ficha datos: ', $exception);

            return redirect()->route('encuesta.fichadatos')->with('error', 'Ha ocurrido un error al intentar guardar sus datos');
        }

    }

    public function obtenerMunicipios($departamento){
        $departamento = Departamento::where('departamento', $departamento)->first();
        $municipios = Municipio::where('id_departamento', $departamento->id_departamento)->get();
        return response()->json($municipios);
    }

}
