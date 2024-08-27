<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>
    @vite('resources/css/app.css') <!-- Inclure Tailwind CSS -->
    <!-- Les styles personnalisés sont désormais mieux gérés par Tailwind CSS -->
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">
    @auth
        @include('layouts.nav') <!-- Inclusion de la barre de navigation seulement si l'utilisateur est authentifié -->
    @endauth

    <main class="container mx-auto p-6 md:p-8 lg:p-10">
        @if (session('success'))
            <div class="bg-green-600 text-white p-4 rounded-lg shadow-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white p-4 rounded-lg shadow-md mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>
</html>
