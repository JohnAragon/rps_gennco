@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-paragraph-bold">Encuesta tipo {{$tipo}} - {{$titulo}}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display Error Message -->
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <h5>{{$enunciado}}</h5>
                    <form method="POST" action="{{ route('encuesta.preguntas.confirmar')}}">
                        @csrf
                        @foreach ($preguntas as $pregunta)
                            <div>
                                <h6> {{ $pregunta->id }}. {{$pregunta->pregunta }}</h6>
                                @foreach ($pregunta->opciones as $opcion)
                                    <label>
                                        <input type="radio" name="p{{$pregunta->id}}" value="{{ $opcion->pivot->valor_id }}">
                                        {{ $opcion->nombre }}
                                    </label><br>
                                @endforeach
                            </div>
                            <hr>
                            @endforeach
                            <input type="hidden" name="tipo" value="{{$tipo}}">
                            <input type="hidden" name="registro" value="{{$registro}}">
                            <input type="hidden" name="empresa" value="{{$empresa}}">
                            <input type="hidden" name="NumeroFolio" value="{{$numeroFolio}}">
                            <input type="hidden" name="cedula" value="{{$cedula}}">
                            <input type="hidden" name="periodo" value="{{$periodo}}">
                            <input type="hidden" name="proximaSeccionId" value="{{ $proximaSeccionId }}">
                            <input type="hidden" name="seccionId" value="{{ $seccionId }}">
                        <button type="submit">Submit Survey</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection