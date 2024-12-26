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