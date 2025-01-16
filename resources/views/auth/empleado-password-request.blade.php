@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('empleado.password.request') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="cedula" class="col-md-4 col-form-label text-md-end">{{ __('Cedula') }}</label>

                            <div class="col-md-6">
                                <input id="cedula" type="cedula" class="form-control @error('cedula') is-invalid @enderror" name="cedula" required autocomplete="current-password">

                                @error('cedula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('empleado.password.request'))
                                    <a class="btn btn-link" href="{{ route('empleado.password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
