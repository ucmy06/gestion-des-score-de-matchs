<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau de Contrôle Employé</title>
    @vite('resources/css/app.css')
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('employee.dashboard') }}">Tableau de bord</a></li>
            <li><a href="{{ route('employee.matches.index') }}">Gestion des matchs</a></li>
            <a href="{{ route('employee.teams.index') }}">Gestion des équipes</a>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Déconnexion</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h1>Bienvenue, Employé</h1>
        <!-- Affichage des informations de gestion -->
    </div>
    
    @vite('resources/js/app.js')
</body>
</html>
