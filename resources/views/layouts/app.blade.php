<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>
    @vite('resources/css/app.css') <!-- Inclure Tailwind CSS -->
    <!-- Les styles personnalisés sont désormais mieux gérés par Tailwind CSS -->
</head>
<body class="bg-white text-white font-sans">
    @auth
        @include('layouts.nav') <!-- Inclusion de la barre de navigation seulement si l'utilisateur est authentifié -->
    @endauth

    <main class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>
</html>
