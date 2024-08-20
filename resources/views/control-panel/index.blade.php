<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau de Contrôle</title>
    @vite('resources/css/app.css') <!-- Assure-toi que tu utilises Vite ou une autre méthode pour les assets -->
</head>
<body>
    <header>
        <h1>Panneau de Contrôle</h1>
    </header>

    <main>
        <h2>Gestion des Équipes</h2>
        <ul>
            @foreach($teams as $team)
                <li>{{ $team->name }}</li>
            @endforeach
        </ul>

        <h2>Gestion des Matchs</h2>
        <ul>
            @foreach($matches as $match)
                <li>
                    {{ $match->team1->name }} vs {{ $match->team2->name }} - Score: {{ $match->score_team_1 }} - {{ $match->score_team_2 }}
                </li>
            @endforeach
        </ul>
    </main>

    <footer>
        <!-- Footer -->
    </footer>

    @vite('resources/js/app.js') <!-- Assure-toi que tu utilises Vite ou une autre méthode pour les assets -->
</body>
</html>
