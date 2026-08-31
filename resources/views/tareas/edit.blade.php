@extends('layouts.app')

@section('title', 'Mis tareas')

@section('content')

    <h1 class="mb-4">Editar tareas</h1>

    @if ($errors -> any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="/tareas/{{ $tarea->id }}" method="POST" class="d-flex gap-2">
        @csrf
        @method('PUT')
        <input 
            type="text" 
            name="tarea" 
            value="{{ $tarea->tarea }}" 
            class="form-control">

        <select name='proyecto_id' class="form-control">
            <option value="">Sin proyecto</option>
            @foreach ($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}" {{ $tarea->proyecto_id == $proyecto->id ? 'selected' : '' }}>{{ $proyecto->proyecto }}</option>
            @endforeach
        </select>

        <div class="form-check d-flex align-items-center">
            <input type="checkbox" name="completada" value="1" {{ $tarea->completada ? 'checked' : '' }} class="form-check-input">
            <label class="form-check-label ms-1">Completada</label>
        </div>

        <button type="submit" class="btn btn-rosa">Actualizar</button>
    </form>

@endsection