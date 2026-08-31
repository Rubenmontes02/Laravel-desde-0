<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {{-- @yield('title', 'valor por defecto') -> si la vista hija no define un título, usa este --}}
    <title>@yield('title', 'Mis notas')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >
    <link href="/css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 500px;">
        {{-- @auth / @endauth: solo se muestra si HAY sesión iniciada --}}
        @auth
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Sesión: {{ auth()->user()->name }}</small>

                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Cerrar sesión</button>
                </form>

                <a href="/inicio" class="btn btn-sm btn-outline-secondary">Menu Inicio</a>
            </div>
        @endauth

        

        {{-- Aquí es donde cada vista hija mete su contenido propio --}}
        @yield('content')
    </div>
</body>
</html>
