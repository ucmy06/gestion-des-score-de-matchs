<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Équipe</title>
</head>
<body>
    <h1>Ajouter une Nouvelle Équipe</h1>

    <form action="{{ route('employee.teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Nom de l'Équipe:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="logo">Logo de l'Équipe:</label>
        <input type="file" id="logo" name="logo" accept="image/*">
        <br><br>
        <button type="submit">Ajouter</button>
    </form>

    <a href="{{ route('employee.teams.index') }}">Retour à la liste des équipes</a>
</body>
</html>
