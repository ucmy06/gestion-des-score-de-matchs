<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Équipes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        a.button, a.retour-button {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        a.button:hover, a.retour-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        img {
            border-radius: 5px;
        }

        .actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            background-color: #fff;
        }

        .actions a:hover {
            background-color: #007bff;
            color: white;
        }

        .actions form {
            display: inline;
        }

        .actions button {
            padding: 5px 10px;
            border: 1px solid #dc3545;
            border-radius: 5px;
            background-color: #dc3545;
            color: white;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Liste des Équipes</h1>
    <a href="{{ route('admin.teams.create') }}" class="button">Ajouter une nouvelle équipe</a>
    <a href="{{ route('home') }}" class="retour-button">Retour</a>
    <table>
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th>Numéro</th>

                <th>Nom</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $index => $team)
                <tr>
                    {{-- <td>{{ $team->id }}</td> --}}
                    <td class="py-2 px-4 border-b text-black">{{ $index + 1 }}</td>

                    <td>{{ $team->name }}</td>
                    <td>
                        @if($team->logo)
                            <img src="{{ asset('storage/' . $team->logo) }}" alt="Logo" width="100">
                        @endif
                    </td>
                    <td class="actions">
                        <a href="{{ route('admin.teams.show', $team->id) }}">Voir</a>
                        <a href="{{ route('admin.teams.edit', $team->id) }}">Modifier</a>
                        <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST">
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
