<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Équipe</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier Équipe: {{ $team->name }}</h1>

        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'Équipe:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" required class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo de l'Équipe:</label>
                <input type="file" id="logo" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @if($team->logo)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $team->logo) }}" alt="Logo" class="w-24 h-24 object-cover rounded-md">
                    </div>
                @endif
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Modifier</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('admin.teams.index') }}" class="text-indigo-600 hover:underline">Retour à la liste des équipes</a>
        </div>
    </div>

</body>
</html>
