@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card"> 
      <div class="card-header center-paragraph">Fin de la encuesta</div>
      <div class="card-body">
        <form  method="POST" action="" name="form-advise" id="login-advice" >
        @csrf
          <p class="center-paragraph"> Usted ha indicado que <strong>NO </strong>desea realizar la encuesta de Factores de Riesgo Psicosocial.<br>
          Por favor cierre la sesión</p>
          
        </form>
      </div>
      <div class="d-flex justify-content-center">
      <form id="logout-form" action="{{ route('empleado.logout') }}" method="POST" class="d-none">
        @csrf  
        <input class="btn btn-primary" type="submit" role="button">Salir</a>
      </form>
      </div>  
  </div>
</div>
@endsection  