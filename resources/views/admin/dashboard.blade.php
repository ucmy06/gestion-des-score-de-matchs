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
            <nav>
                <ul>
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Profile</a>
                        <div class="dropdown-content">
                            <a href="{{ route('profile.edit') }}">Modifier votre profil</a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
        </ul>
    </nav>

    <div class="container">
        <h1>Bienvenue, Admin</h1>
        <!-- Affichage des informations de gestion -->
    </div>
    
    @vite('resources/js/app.js')
</body>
</html>
