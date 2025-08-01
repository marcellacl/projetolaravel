<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 mb-4">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
        <div class="ms-auto">
            @auth
                <span class="text-white me-3">{{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm me-2">Perfil</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
