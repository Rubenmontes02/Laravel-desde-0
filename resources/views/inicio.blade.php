@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <h1 class="mb-4">Menu Módulos</h1>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="d-flex gap-2">
        <a href="/notas" class="btn btn-sm btn-outline-primary">Módulo Notas</a>
        <a href="/tareas" class="btn btn-sm btn-outline-primary">Módulo Tareas</a>

    </div>


@endsection
