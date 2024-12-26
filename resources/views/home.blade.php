@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="content">
                    <form action="{{ route('survey.welcome') }}" method="post" id="form1">
                    @csrf
                        <div class="confirmation-box">
                                !USUARIO HABILITADO!
                                <p align="center"><strong>Sr(a) COLINA TORRES SANTIAGO:</strong><br>
                                Esta accediendo como empleado de la empresa <strong> GO - GESTION Y OPERACION DE LA </strong>.<br>
                                Su cédula <strong>72008127 </strong> se encuentra habilitada para acceder a la encuesta de FACTORES DE RIESGO PSICOSOCIAL </p>
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
