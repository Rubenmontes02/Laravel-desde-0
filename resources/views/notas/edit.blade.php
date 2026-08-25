<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar nota</title>

    {{-- CSS de Bootstrap desde el CDN oficial --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    >
    <link href="/css/custom.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
</head>
<body>
    <div class="container mt-5" style="max-width: 500px;">
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
    </div>
</body>
</html>
