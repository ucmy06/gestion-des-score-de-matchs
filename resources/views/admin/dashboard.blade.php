<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau de Contrôle Admin</title>
    @vite('resources/css/app.css')
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
            <li><a href="{{ route('admin.employees.index') }}">Gestion des utilisateurs</a></li>
            <li><a href="{{ route('admin.matches.index') }}">Gestion des matchs</a></li>
            <li><a href="{{ route('admin.teams.index') }}">Gestion des équipes</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Déconnexion</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h1>Bienvenue, Admin</h1>
        <!-- Affichage des informations de gestion -->
    </div>
    
    @vite('resources/js/app.js')
</body>
</html>
