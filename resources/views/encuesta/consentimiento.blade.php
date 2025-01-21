@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-paragraph">{{ __('Consentimiento') }}</div>

                <div class="card-body">	  	
                    <div class="row ">
                        <p class="center-paragraph">
                            <strong>¡BIENVENIDO!</strong><br>
                            Usted está ingresando a la encuesta: Factores de Riesgo Psicosocial, recuerde que su plazo para finalizar el proceso es hasta: <strong>{{Auth::user()->fecha_final}}</strong></h2>  
                        </p>        
                    </div>
                    <div class="row">
                        <div class="col-6" >
                            <form action="{{route(encuesta.consentimiento.aceptar)}}" method="POST" style="display: inline;">
                                @csrf
                                <button class="btn red btn-circle" name="consentimiento" type="submit" value="{{config('constants.CONSENTIMIENTO_NO')}}">
                                    <i class="fas fa-times"></i>  <!-- Icon for "X" -->
                                </button>
                                <span style="vertical-align: button; margin-left: 10px;">No Deseo realizar la encuesta</span>
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="{{route(encuesta.consentimiento.aceptar)}}" method="POST" style="display: inline;">
                                @csrf
                                <button class="btn green btn-circle" name="consentimiento" type="submit" value="{{config('constants.CONSENTIMIENTO_SI')}}">
                                    <i class="fas fa-check"></i><!-- Icon for "Check" -->
                                </button>
                                <span style="vertical-align: button; margin-left: 10px;">Deseo realizar la encuesta</span>
                            </form>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>            
@endsection    