@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <h1 class="mb-4">Iniciar sesión</h1>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="/login" method="POST" class="d-flex flex-column gap-2">
        @csrf

        <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
        <input type="password" name="password" placeholder="Contraseña" class="form-control">

        <button type="submit" class="btn btn-rosa">Entrar</button>
    </form>

    <a href="/registro" class="d-inline-block mt-3">¿No tienes cuenta? Regístrate</a>
@endsection
