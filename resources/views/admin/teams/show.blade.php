<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'Équipe</title>
</head>
<body>
    <h1>Détails de l'Équipe: {{ $team->name }}</h1>

    <p><strong>Nom:</strong> {{ $team->name }}</p>
    <p><strong>Logo:</strong></p>
    @if($team->logo)
        <img src="{{ asset('storage/' . $team->logo) }}" alt="Logo" width="100">
    @endif

    <a href="{{ route('admin.teams.edit', $team->id) }}">Modifier</a>
    <a href="{{ route('admin.teams.index') }}">Retour à la liste des équipes</a>
</body>
</html>
