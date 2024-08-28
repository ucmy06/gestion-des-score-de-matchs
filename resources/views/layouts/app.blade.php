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
    

    
    
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
<script>
    const socket = io('http://localhost:3000'); // Assurez-vous que le port correspond à celui de votre serveur

    socket.on('message', (data) => {
        console.log('Message received from server:', data);
        // Vous pouvez maintenant manipuler le DOM en fonction des données reçues
    });

    // Pour envoyer un message au serveur
    socket.emit('message', 'Hello, server!');
</script>

</body>
</html>
