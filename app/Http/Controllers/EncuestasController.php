<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use App\Models\Fichadato;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Seccion;
use App\Models\PreguntaA;
use App\Models\PreguntaB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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
         $validatedData = $request->validated();
       
         $additionalData = $request->only(['empresas', 'sede', 'nombre','cedula','lugartrabajodpto','lugartrabajocity', 'nombredepto', 'registro','periodo','cargoempresa','tablacontestada']);
         $edad = Carbon::now()->format('Y') - $validatedData['anonaci'];
         $additionalData['edad']   = $edad;
       
         $data = array_merge($validatedData, $additionalData);
       
        try {
               
            Fichadato::create($data);

            return redirect()->route('encuesta.preguntas', [strtolower(Auth::user()->nivelSeguridad), $data['tablacontestada']])->with('success', '¡Sus datos fueron registrados!');
        } catch (Exception $exception) {
            Log::error('Error registrando ficha datos: ', $exception);

            return redirect()->route('encuesta.fichadatos')->with('error', 'Ha ocurrido un error al intentar guardar sus datos');
        }

    }

    public function mostrarPreguntas(Request $request){
        $fichaDato = Fichadato::where('registro', Auth::user()->registro)->first();
        $secciones = Seccion::where('tipo', $request->tipo)->get();
        $conteoSecciones = count($secciones);
        $seccion = Seccion::where('tipo', $request->tipo)->where('route', $request->seccion)->first();
        $preguntas = $this->obtenerPreguntas(strtoupper($request->tipo), $seccion->id);
        $proximaSeccionId = $secciones->get(($seccion->orden + 1) - 1)->route;
        $tipo = strtoupper($request->tipo); 
        $seccionId = $seccion->id; 
        $registro = $fichaDato->registro;
        $empresa = $fichaDato->empresas;
        $numeroFolio = $fichaDato->NumeroFolio;
        $cedula = $fichaDato->cedula;
        $periodo = $fichaDato->periodo;
        $titulo = $seccion->nombre;
        $enunciado = $seccion->enunciado;  

        return view('encuesta.preguntas', compact('preguntas','seccionId','periodo','numeroFolio','empresa','registro','cedula','proximaSeccionId', 'tipo','titulo','enunciado'));
    }

    public function confirmarPreguntas(Request $request){
        $fichaDato = Fichadato::where('registro', Auth::user()->registro)->first();
     
        $rules = [];
        foreach ($request->except(['_token', 'tipo', 'proximaSeccionId', 'seccionId']) as $key => $value) {
            $rules[$key] = 'required';
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Retrieve the seccion record
        $seccion = Seccion::find($request->input('seccionId'));
        if (!$seccion) {
            return redirect()->back()
                             ->with('error', 'Sección no encontrada.');
        }
    
+        $modelClass = $seccion->modelo;
    
        if (!class_exists($modelClass)) {
            return redirect()->back()
                             ->with('error', 'Modelo no válido.');
        }
    
        $data = $request->except(['_token', 'tipo', 'proximaSeccionId', 'seccionId']);
       
        $modelClass::create($data);
        
        $fichaDato->update(['tablacontestada' => $request->input('proximaSeccionId')]);

    
        // Redirect to the next section or a confirmation page
        return redirect()->route('encuesta.preguntas', ['tipo' => $request->tipo,'seccion'=>$request->input('proximaSeccionId')])
                         ->with('success', 'Respuestas guardadas correctamente.');
    
    }

    public function obtenerMunicipios($departamento){
        $departamento = Departamento::where('departamento', $departamento)->first();
        $municipios = Municipio::where('id_departamento', $departamento->id_departamento)->get();
        return response()->json($municipios);
    }

    public function obtenerPreguntas($tipo, $seccion_id){
    
        if($tipo == config('constants.TIPO_A')){
           return PreguntaA::where('seccion_id', $seccion_id)->with(['opciones.valor']) ->get();
        }else{
            return PreguntaB::where('seccion_id', $seccion_id)->with(['opciones.valor']) ->get();
        }    
    }
}
    
