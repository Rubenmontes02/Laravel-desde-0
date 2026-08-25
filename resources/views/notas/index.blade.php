<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis notas</title>
</head>
<body>
    <h1>Mis notas</h1>

    {{-- Si la validación del controlador falla, aquí aparece el mensaje de error --}}
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first('texto') }}</p>
    @endif

    <form action="/notas" method="POST">
        @csrf
        <input type="text" name="texto" placeholder="Escribe una nota...">
        <button type="submit">Guardar</button>
    </form>

    <ul>
        @forelse ($notas as $nota)
            <li>{{ $nota->texto }}</li>
        @empty
            <li>Todavía no hay notas.</li>
        @endforelse
    </ul>
</body>
</html>
