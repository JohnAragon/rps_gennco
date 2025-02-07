@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card"> 
      <div class="card-header center-paragraph">Fin de la encuesta</div>
      <div class="card-body">
            <div class="d-flex justify-content-center">
                @if(Auth::user()->consentimiento == config('constants.USUARIO_NIEGA'))
                    <p class="center-paragraph"> Usted ha indicado que <strong>NO </strong>desea realizar la encuesta de Factores de Riesgo Psicosocial.<br>
                    Por favor cierre la sesión</p>
                @else 
                    <P class="center-paragraph"><strong>¡GRACIAS POR SU PARTICIPACION!</strong></P>
                    <p class="center-paragraph"> Usted ha terminado con éxito la encuesta de Factores de Riesgo Psicosocial .<br>
                    Por favor cierre la sesión</p>
                @endif       
            </div> 
            <div class="d-flex justify-content-center">
                <form action="{{ route('empleado.logout') }}" method="POST">
                    @csrf  
                    <input class="btn btn-primary" type="submit" value="Salir">
                </form>
            </div>
        </div>  
    </div>
</div>
@endsection