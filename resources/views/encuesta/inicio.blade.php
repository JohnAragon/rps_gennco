@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Encuesta de factores de Riesgo Psicosocial') }}</div>

                <div class="card-body">
                  
                    <div id="content">
                    <form action="" method="post" id="form1">
                    @csrf
                        <div class="confirmation-box">
                                !USUARIO HABILITADO!
                                <p align="center"><strong>{{Auth::user()->nombre}}</strong><br>
                                Esta accediendo como empleado de la empresa <strong> {{Auth::user()->lugartrabajo}} </strong>.<br>
                                Su cédula <strong>{{Auth::user()->cedula}} </strong> se encuentra habilitada para acceder a la encuesta de FACTORES DE RIESGO PSICOSOCIAL </p>
                            </div>

                                <input class="button round blue image-right ic-right-arrow" name="submit" type="submit" value="IR A ENCUESTA">

                        </form>	

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection