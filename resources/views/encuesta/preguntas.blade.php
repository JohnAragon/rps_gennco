@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-paragraph-bold">Encuesta tipo A - {{$proximaSeccion}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('encuesta.preguntas',['tipo' => $tipo, 'seccion' => $proximaSeccion]) }}">
                        @csrf
                        @foreach($preguntas as $pregunta)
                            <div>
                                <p>{{ $pregunta['pregunta'] }}</p>
                
                            </div>
                        @endforeach
                        <button type="submit">Submit Survey</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection