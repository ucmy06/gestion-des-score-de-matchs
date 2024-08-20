<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Équipe</title>
</head>
<body>
    <h1>Modifier Équipe: {{ $team->name }}</h1>

    <form action="{{ route('employee.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="name">Nom de l'Équipe:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" required>
        <br><br>
        <label for="logo">Logo de l'Équipe:</label>
        <input type="file" id="logo" name="logo" accept="image/*">
        <br><br>
        @if($team->logo)
            <img src="{{ asset('storage/' . $team->logo) }}" alt="Logo" width="100">
        @endif
        <br><br>
        <button type="submit">Modifier</button>
    </form>

    <a href="{{ route('employee.teams.index') }}">Retour à la liste des équipes</a>
</body>
</html>
