@extends('layouts.app')

@section('content')
<div class="container">
        <form method="POST" action="{{ route('empleado.login') }}">
            @csrf
            <div class="form-group">
                <label for="cedula">Cedula:</label>
                <input type="text" id="cedula" name="cedula" required>
                @error('cedula')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
                @error('contrasena')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit">Ingresar</button>
            </div>
        </form>
        <a href="{{ route('empleado.password.request') }}" class="link">¿Olvidaste tu contraseña?</a>
</div>
@endsection

