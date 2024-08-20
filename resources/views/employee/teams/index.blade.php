<!DOCTYPE html>
<html>
<head>
    <title>Liste des Équipes</title>
</head>
<body>
    <h1>Liste des Équipes</h1>
    <a href="{{ route('employee.teams.create') }}">Ajouter une nouvelle équipe</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $team)
                <tr>
                    <td>{{ $team->id }}</td>
                    <td>{{ $team->name }}</td>
                    <td>
                        @if($team->logo)
                            <img src="{{ asset('storage/' . $team->logo) }}" alt="Logo" width="100">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employee.teams.show', $team->id) }}">Voir</a>
                        <a href="{{ route('employee.teams.edit', $team->id) }}">Modifier</a>
                        <form action="{{ route('employee.teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
