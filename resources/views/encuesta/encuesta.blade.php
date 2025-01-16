@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenida') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('submit.survey') }}">
                        @csrf
                        @foreach($questions as $question)
                            <div>
                                <p>{{ $question['text'] }}</p>
                                @foreach($question['options'] as $value => $label)
                                    <label>
                                        <input type="radio" 
                                            name="responses[{{ $question['id'] }}]" 
                                            value="{{ $value }}"> 
                                        {{ $label }}
                                    </label>
                                @endforeach
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