@extends('layouts.app')

@section('title', 'Mis tareas')

@section('content')

    <h1 class="mb-4">Mis Tareas</h1>

        @if ($errors -> any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
    
    <form action="/tareas" method="POST" class="d-flex gap-2 mb-4">
        @csrf
        <input type="text" name="tarea" placeholder="Escribe una tarea..." class="form-control">
        
        <select name='proyecto_id' class="form-select">
            <option value="">Sin proyecto</option>
            @foreach ($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}">{{ $proyecto->proyecto }}</option>
            @endforeach
        </select>

        <div class="form-check d-flex align-items-center">
            <input type="checkbox" name="completada" value="1" class="form-check-input">
            <label class="form-check-label ms-1">Completada</label>
        </div>

        <button type="submit" class="btn btn-rosa">Guardar</button>
    </form>

    <ul class="list-group">
        @forelse ($tareas as $tarea)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $tarea->tarea }} - {{ $tarea->completada ? 'Completada' : 'Pendiente' }}
                <small class="text-muted">{{ $tarea->proyecto ?? 'Sin proyecto' }}</small>
                <small class="text-muted">Usuario: {{ $tarea->user_name ?? 'Sin usuario' }}</small>
                
                @if (auth()->user()->name === $tarea->user_name)
                    <div class="d-flex gap-2">
                        <a href="/tareas/{{ $tarea->id }}/edit" class="btn btn-sm btn-outline-secondary bi bi-pencil-square"></a>

                        <form action="/tareas/{{ $tarea->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger bi bi-trash"></button>
                        </form>
                    </div>
                @endif

            </li>



        @empty
            <li class="list-group-item text-muted">Todavía no hay tareas.</li>
        @endforelse
    </ul>
    


@endsection

