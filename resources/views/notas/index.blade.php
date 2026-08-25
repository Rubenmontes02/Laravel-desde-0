<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis notas</title>

    {{-- CSS de Bootstrap desde el CDN oficial --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link href="/css/custom.css" rel="stylesheet">

</head>
<body>
    {{-- "container" limita el ancho y centra el contenido; "mt-5" = margin-top --}}
    <div class="container mt-5" style="max-width: 500px;">
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
            <button type="submit" class="btn btn-rosa">Guardar</button>
        </form>

        <ul class="list-group">
            @forelse ($notas as $nota)
                <li class="list-group-item">{{ $nota->texto }}</li>
            @empty
                <li class="list-group-item text-muted">Todavía no hay notas.</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
