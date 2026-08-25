@extends('layouts.app')

@section('title', 'Editar nota')

@section('content')
    <h1 class="mb-4">Editar nota</h1>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first('texto') }}</div>
    @endif

    <form action="/notas/{{ $nota->id }}" method="POST" class="d-flex gap-2">
        @csrf
        @method('PUT')
        <input
            type="text"
            name="texto"
            value="{{ $nota->texto }}"
            class="form-control"
        >
        <button type="submit" class="btn btn-rosa">Actualizar</button>
    </form>

    <a href="/notas" class="d-inline-block mt-3 bi bi-card-list">Volver a la lista</a>
@endsection
