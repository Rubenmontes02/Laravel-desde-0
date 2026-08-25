@extends('layouts.app')

@section('title', 'Mis notas')

@section('content')
    <h1 class="mb-4">Mis notas</h1>

    @if ($errors->any())
        {{-- "alert alert-danger" = caja roja de aviso, estilo Bootstrap --}}
        <div class="alert alert-danger">{{ $errors->first('texto') }}</div>
    @endif

    <form action="/notas" method="POST" class="d-flex gap-2 mb-4">
        @csrf

        <input
            type="text"
            name="texto"
            placeholder="Escribe una nota..."
            class="form-control"
        >

        <select name="categoria_id" class="form-select">
            <option value="">Sin categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
            @endforeach
        </select>


        <button type="submit" class="btn btn-rosa">Guardar</button>
    </form>

    <ul class="list-group">
        @forelse ($notas as $nota)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $nota->texto }}
                <small class="text-muted">{{ $nota->categoria->categoria ?? 'Sin categoría' }}</small>


                <div class="d-flex gap-2">
                    <a href="/notas/{{ $nota->id }}/edit" class="btn btn-sm btn-outline-secondary bi bi-pencil-square"></a>

                    <form action="/notas/{{ $nota->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger bi bi-trash"></button>
                    </form>
                </div>
            </li>
        @empty
            <li class="list-group-item text-muted">Todavía no hay notas.</li>
        @endforelse
    </ul>
@endsection
