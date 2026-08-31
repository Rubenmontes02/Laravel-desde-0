@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
    <h1 class="mb-4">Crear cuenta</h1>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="/registro" method="POST" class="d-flex flex-column gap-2">
        @csrf

        <input type="text" name="name" placeholder="Nombre" class="form-control" value="{{ old('name') }}">
        <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
        <input type="password" name="password" placeholder="Contraseña (mínimo 8 caracteres)" class="form-control">

        <button type="submit" class="btn btn-rosa">Crear cuenta</button>
    </form>

    <a href="/login" class="d-inline-block mt-3">¿Ya tienes cuenta? Inicia sesión</a>
@endsection
