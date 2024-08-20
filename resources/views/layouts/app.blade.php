<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>
    @vite('resources/css/app.css')
    <style>
        /* Styles pour la liste déroulante */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {background-color: #f1f1f1}
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
        
        /* Styles pour le fond */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #000; /* Fond noir */
            color: white; /* Couleur du texte */
        }
        .background-video {
            display: none; /* Masquer la vidéo */
        }
        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .auth-content {
            background-color: rgba(0, 0, 0, 0.6); /* Ajoute une couche de fond sombre pour la lisibilité */
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
        }
        .nav-link {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            color: white;
            background-color: #FF2D20;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #e02d1f;
        }
        .auth-content p {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <!-- <video class="background-video" autoplay muted loop>
        <source src="https://static.vecteezy.com/system/resources/previews/017/274/159/mp4/stadium-super-bowl-food-or-drink-promotion-you-can-add-product-free-video.mp4" type="video/mp4">
        Votre navigateur ne prend pas en charge les vidéos.
    </video> -->

    <nav>
        <ul>

            <li class="dropdown">
                <a href="#" class="dropbtn">Profile</a>
                <div class="dropdown-content">
                    <a href="{{ route('profile.edit') }}">Modifier votre profile</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <main>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <!-- Votre contenu de pied de page -->
    </footer>

    @vite('resources/js/app.js')
</body>
</html>
