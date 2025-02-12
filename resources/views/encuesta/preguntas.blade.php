@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header center-paragraph-bold">Encuesta tipo {{strtoupper($seccion->tipo)}} - {{$seccion->nombre}}</div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{dd(session('error')) }}
                    </div>
                @endif
    
                <div class="row">
                  
                    @if($seccion->route == 'fin-encuesta')
                    <form action="{{ route('empleado.logout') }}" method="POST">
                    @csrf
                        <P class="center-paragraph"><strong>¡GRACIAS POR SU PARTICIPACION!</strong></P>
                        <p class="center-paragraph">{{$seccion->enunciado}}</p>
            

                    @elseif($seccion->route == 'confirma-atencion' || $seccion->route == 'confirma-jefe' )
                    @csrf
                    <form method="POST" action="{{ route('encuesta.preguntas.confirmar')}}">
                    <h5>{{$seccion->enunciado}}</h5>
                    <input type="hidden" name="tipo" value="{{strtoupper($seccion->tipo)}}">
                    <input type="hidden" name="rutaActual" value="{{ $seccion->route }}">
                    <input type="hidden" name="proximaSeccionId" value="{{ $proximaSeccionId }}">
                    <div class="col-6" >
                            <button class="btn green btn-circle" name="confirma" type="submit" value="{{config('constants.USUARIO_APLICA')}}">
                                <i class="fas fa-check"></i><!-- Icon for "Check" -->
                            </button>
                            <span style="vertical-align: button; margin-left: 10px;">SI</span>
                    </div>
                    <div class="col-6">
                            <button class="btn red btn-circle" name="confirma" type="submit" value="{{config('constants.USUARIO_NO_APLICA')}}">
                                <i class="fas fa-times"></i>  <!-- Icon for "X" -->
                            </button>
                            <span style="vertical-align: button; margin-left: 10px;">NO</span> 
                    </div>        
                </div>
                <div class="row">   
                    @else 
                    <div class="survey-table">
                                <!-- Table Header -->
                                <div class="table-header">
                                    <div class="question-col">Pregunta</div>
                                    @foreach ($opciones as $opcion)
                                        <div class="options-col">{{$opcion->nombre}}</div>
                                    @endforeach    
                                </div>

                                <!-- Questions and Options -->
                                @foreach ($preguntas as $pregunta)
                                    <div class="table-row">
                                        <div class="question-col">
                                            <span class="question-number">{{ $pregunta->orden }}.</span>
                                            {{$pregunta->pregunta }}
                                        </div>
                                        @foreach ($pregunta->opciones as $opcion)
                                            <div class="options-col" data-option-name="{{$opcion->nombre}}">
                                                <input type="radio" 
                                                    id="{{$prefijoPreguntas.$pregunta->orden.$sufijoPreguntas}}_{{$opcion->pivot->valor_id}}" 
                                                    name="{{$prefijoPreguntas.$pregunta->orden.$sufijoPreguntas}}" 
                                                    value="{{ $opcion->valor_encontrado }}"
                                                    class="custom-radio"
                                                    {{ old($prefijoPreguntas.$pregunta->orden.$sufijoPreguntas) ==  $opcion->valor_encontrado ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error($prefijoPreguntas . $pregunta->orden .$sufijoPreguntas) 
                                        <div class="error-row">
                                            <span class="error-message">{{ $message }}</span>
                                        </div>
                                    @enderror
                                @endforeach
                            </div>
                        </div>
                        <!-- Hidden inputs -->
                        <input type="hidden" name="confirma" value="">
                        <input type="hidden" name="tipo" value="{{strtoupper($seccion->tipo)}}">
                        <input type="hidden" name="registro" value="{{$fichaDato->registro}}">
                        <input type="hidden" name="empresa" value="{{$fichaDato->empresas}}">
                        <input type="hidden" name="area" value="{{$fichaDato->nombredepto}}">
                        <input type="hidden" name="sede" value="{{$fichaDato->sede}}">
                        <input type="hidden" name="nombre" value="{{$fichaDato->nombre}}">
                        <input type="hidden" name="cargo" value="{{$fichaDato->cargoempresa}}">
                        <input type="hidden" name="NumeroFolio" value="{{$fichaDato->NumeroFolio}}">
                        <input type="hidden" name="cedula" value="{{$fichaDato->cedula}}">
                        <input type="hidden" name="periodo" value="{{$fichaDato->periodo}}">
                        <input type="hidden" name="proximaSeccionId" value="{{ $proximaSeccionId }}">
                        <input type="hidden" name="rutaActual" value="{{ $seccion->route }}">
                        @endif 
                        @if($seccion->route == 'fin-encuesta') 
                            <input class="submit-btn" type="submit" value="Salir">
                        @else
                            <button type="submit" class="submit-btn">Continuar</button>
                        @endif     
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>
@endsection