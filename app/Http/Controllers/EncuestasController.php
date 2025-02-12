<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use App\Models\Fichadato;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Seccion;
use App\Models\Opcion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\FichadatosValidacion;
use App\Http\Requests\PreguntasRequest;

use Illuminate\Support\Facades\Config;


class EncuestasController extends Controller
{
    public function index(){
        $user = Auth::user();

            if($user->terminos == config('constants.USUARIO_ESPERA')){
                return redirect()->route('inicio');
            }    
            
            if($user->consentimiento == config('constants.USUARIO_ESPERA')){
                return redirect()->route('encuesta.consentimiento');
            }
                
            if ($user->consentimiento == config('constants.USUARIO_CONFIRMA') && $user->fichadatos == config('constants.USUARIO_NIEGA')){
                return redirect()->route('encuesta.fichadatos');
            } 
            
            if ($user->consentimiento == config('constants.USUARIO_CONFIRMA') && $user->fichadatos == config('constants.USUARIO_CONFIRMA')){
                return redirect()->route('encuesta.preguntas', [strtolower($user->nivelSeguridad), $user->fichadato->tablacontestada]);
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
                        'habilitado' => config('constants.USUARIO_COMPLETO'),
                        'llave' => config('constants.USUARIO_LLAVE')
                    ]);      
             
        }catch(ModelNotFoundException $exception){
            Log::error('Empleado no encontrado: ', $exception);
            return back()->withError(config('MENSAJE_ERROR_MODELO_NOT_FOUND'))->withInput();
        }

        if($request->consentimiento == config('constants.USUARIO_CONFIRMA')){
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
            
            $modelInfo = Fichadato::where('registro',$request->registro)->first();
            !empty($modelInfo) ?  FichaDato::where('registro',$data['registro'])->update($data) : FichaDato::create($data);

            return redirect()->route('encuesta.preguntas', [strtolower(Auth::user()->nivelSeguridad), $data['tablacontestada']])->with('success', '¡Sus datos fueron registrados!');
        } catch (Exception $exception) {
            Log::error('Error registrando ficha datos: ', $exception);

            return redirect()->route('encuesta.fichadatos')->with('error', 'Ha ocurrido un error al intentar guardar sus datos');
        }

    }

    public function mostrarPreguntas(Request $request){
   
        $fichaDato = Fichadato::where('registro', Auth::user()->registro)->first();
        $secciones = Seccion::where('tipo', $request->tipo)->orderBy('orden','asc')->get();
        $seccion = Seccion::where('tipo', $request->tipo)->where('route', $request->seccion)->first();
        $preguntas = [];
        $prefijoPreguntas= null;
        $proximaSeccionId = $seccion->route != 'fin-encuesta' ? $secciones->get(($seccion->orden + 1) - 1)->route : 'fin-encuesta';  
        $incluyePreguntas = $this->esSeccionConPreguntas($seccion->route);
        
        if($incluyePreguntas){
            $prefijoPreguntas = $this->obtenerPrefijoPreguntas($seccion->route);
            $sufijoPreguntas = $this->obtenerSufijoPreguntas($request->tipo, $seccion->route);
            $opciones = $this->obtenerOpcionesPreguntas($seccion->route);
            $preguntas = $this->obtenerValorPreguntas(strtoupper($request->tipo), $seccion->id, $seccion->modeloPregunta); 
            return view('encuesta.preguntas', compact('preguntas','seccion','fichaDato', 'proximaSeccionId', 'prefijoPreguntas', 'sufijoPreguntas', 'opciones'));
        }
        return view('encuesta.preguntas', compact('seccion','fichaDato', 'proximaSeccionId',));
    }

    public function confirmarPreguntas(PreguntasRequest $request){
       
        $seccion = Seccion::where('tipo', $request->tipo)->where('route', $request->rutaActual)->first();

        if (!$seccion) {
            return redirect()->back()
                ->with('error', 'Sección no encontrada.');
        }

        
        $fichaDato = Fichadato::where('registro', Auth::user()->registro)->first();
    
        $proximaSeccionId = $this->obtenerFinPreguntas($request->input('proximaSeccionId'));

        $incluyePreguntas = $this->esSeccionConPreguntas($request->rutaActual);
      
        try{
            if($incluyePreguntas){
            
                $data = $this->obenterRequestData($request, $seccion->ruta);
                
  
                $modelClass = $seccion->modelo;
        
                if (!class_exists($modelClass) ) {
                    return redirect()->back()
                                    ->with('error', 'Modelo no válido.');
                }
    
                $modelInfo = $modelClass::where('registro',$data['registro'])->first();

                !empty($modelInfo) ?  $modelClass::where('registro',$data['registro'])->update($data) : $modelClass::create($data);

                $fichaDato->update(['tablacontestada' => $proximaSeccionId]);

                if($proximaSeccionId == 'fin-encuesta'){
                    $empleado = Empleado::where('registro',Auth::user()->registro);
                    $empleado->update(['habilitado'=>config('constants.USUARIO_COMPLETO'),
                        'llave'=>config('constants.USUARIO_LLAVE'),
                        'tipoencuesta'=>config('constants.USUARIO_CONSTESTO')
                    ]);

                }
            }
             
            if($request->input('confirma') != null){
             
                if($request->rutaActual == "confirma-atencion"){
                    $proximaSeccionId = $request->input('confirma') == config('constants.USUARIO_APLICA') ? $request->input('proximaSeccionId') : 'confirma-jefe';
                    
                    $fichaDato->update([
                        'serviciocliente' => $request->input('confirma'),
                        'tablacontestada' => $proximaSeccionId
                    ]);

                }

                if($request->rutaActual == "confirma-jefe"){

                    $proximaSeccionId = $request->input('confirma') == config('constants.USUARIO_APLICA') ? $request->input('proximaSeccionId') : 'condiciones-vivienda';

                    $fichaDato->update([
                        'soyjefe' => $request->input('confirma'),
                        'tablacontestada' => $proximaSeccionId
                    ]);

                }
            }

            
            
            return redirect()->route('encuesta.preguntas', ['tipo' =>strtolower($request->tipo),'seccion'=>$proximaSeccionId])
                            ->with('success', 'Respuestas guardadas correctamente.');
        } catch (Exception $exception) {
            Log::error('Error registrando encuesta: ', $exception);
                
            return redirect()->route('encuesta.preguntas', ['tipo' =>strtolower($request->tipo),'seccion'=>$seccion->route])->with('error', 'Ha ocurrido un error al intentar guardar sus datos');
        }
    }

    public function obtenerMunicipios($departamento){
        $departamento = Departamento::where('departamento', $departamento)->first();
        $municipios = Municipio::where('id_departamento', $departamento->id_departamento)->get();
        return response()->json($municipios);
    }

    public function obtenerValorPreguntas($tipo, $seccion_id, $tipoModelo){
        $preguntas = $tipoModelo::where('seccion_id', $seccion_id)->with(['opciones.valor'])->orderBy('orden','asc')->get();
        $preguntas->each(function ($pregunta) {
            $pregunta->opciones->each(function ($opcion) {
                $valor = $opcion->valor->firstWhere('id', $opcion->pivot->valor_id); 
                if ($valor) {
                    $opcion->valor_encontrado = $valor->valor;
                }
            });
        });
        return $preguntas;
    }

    public function esSeccionConPreguntas ($ruta){
        switch($ruta){
            case 'confirma-jefe':
                return false;

            case 'confirma-atencion':
                return false;
                
            case 'fin-encuesta':
                    return false; 
            
            default : 
                return true;
        }        
    }

    public function obtenerPrefijoPreguntas ($ruta){
        switch($ruta){
            case 'condiciones-vivienda':
                return 'ext';

            case 'condiciones-extralaborales':
                return 'ext';    
            
            case 'sintomas-estres':
                return 'estres';        
            
            default : 
                return "p";
        }        
    }

    public function obtenerSufijoPreguntas ($tipo , $ruta){
        if($tipo == config('constants.TIPO_B') && $ruta == 'sintomas-estres'){
            return "a";
        }
        return null;        
    }

    public function obtenerOpcionesPreguntas ($ruta){
       switch($ruta){
            case 'sintomas-estres':
                return  Opcion::whereIn('id', [1, 2, 6, 5])
                ->orderBy('orden', 'asc')
                ->get();
            case 'afrontamiento-seccion-I':
                return  Opcion::whereIn('id', [6, 7, 5, 4, 2, 1])
                ->orderBy('orden', 'desc')
                ->get();

            case 'afrontamiento-seccion-II':
                return  Opcion::whereIn('id', [6, 7, 5, 4, 2, 1])
                ->orderBy('orden', 'desc')
                ->get(); 
                
            case 'afrontamiento-seccion-III':
                return  Opcion::whereIn('id', [6, 7, 5, 4, 2, 1])
                ->orderBy('orden', 'desc')
                ->get(); 
            case 'personalidad':
                return  Opcion::whereIn('id', [8,9])
                ->orderBy('orden', 'asc')
                ->get();   
           
            default:
                return Opcion::whereIn('id', [1, 2, 3, 4,5])
            ->orderBy('orden', 'asc')
            ->get(); 

       }   
    }

    public function obtenerFinPreguntas($ruta){
        
        $tieneAfrontamiento = $this->validarEncuestaAdicional(Auth::user()->afrontamiento);
        $tienePersonalidad = $this->validarEncuestaAdicional(Auth::user()->adicional);

        if($ruta == 'sintomas-estres' && $tieneAfrontamiento){
            return 'afrontamiento-seccion-I';
        }

        else if ($ruta == 'sintomas-estres' && $tienePersonalidad){
            return 'personalidad';
        }

        else if ($ruta == 'afrontamiento-seccion-III' && $tienePersonalidad){
            return 'personalidad';
        }

        else if ($ruta == 'afrontamiento-seccion-III' && !$tienePersonalidad){
            return 'fin-encuesta';
        }

        else if ($ruta != 'sintomas-estres'){
            return $ruta;
        }

        return 'fin-encuesta';

    }
    
    public function validarEncuestaAdicional ($ruta){
        switch($ruta){
            case 'SI':
                return true;

            case 'NO':
                return false;    
            
            default : 
                return false;
        }        
    }

    public function obenterRequestData(Request $request, $ruta){
        $coincidencia = null;
        switch($ruta){
            case 'afrontamiento-seccion-I':
                $coincidencia ='afrontamiento';

            case 'afrontamiento-seccion-II':
                return false;    
            
                
            case 'afrontamiento-seccion-III':
                $coincidencia ='afrontamiento';
                
            case 'personalidad':
                $coincidencia ='personalidad';    
            
            default : 
                $coincidencia =null;
        } 

        if ($coincidencia != null && str_contains($seccion->route, $coincidencia) != false ) {
            $data = $request->except(['_token', 'tipo', 'proximaSeccionId','rutaActual','confirma','sede','area','cargo','nombre']);
        }  else{
            $data = $request->except(['_token', 'tipo', 'proximaSeccionId','rutaActual','confirma']);
        }

       return $data;
    }
}
    
