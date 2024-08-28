<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Équipe</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Détails de l'Équipe: {{ $team->name }}</h1>

        <div class="mb-4">
            <p class="text-gray-700"><strong class="font-medium">Nom:</strong> {{ $team->name }}</p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700"><strong class="font-medium">Logo:</strong></p>
            @if($team->logo)
                <img src="{{ asset('storage/' . $team->logo) }}" alt="Logo de l'équipe" class="mt-2 w-32 h-32 object-cover">
            @else
                <p class="text-gray-500">Pas de logo disponible</p>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.teams.edit', $team->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Modifier</a>
            <a href="{{ route('admin.teams.index') }}" class="text-blue-500 hover:underline">Retour à la liste des équipes</a>
        </div>
    </div>
</body>
</html>
