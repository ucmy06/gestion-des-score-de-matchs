<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <style>
        /* Styles pour le fond */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: url('https://wallpapercave.com/wp/wp4908754.jpg') no-repeat center center fixed;
            background-size: cover;
            z-index: -1;
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
    <div class="background"></div>
    <div class="container">
        <div class="auth-content">
            @if (Route::has('login'))
                <nav class="flex flex-col items-center">
                    @auth
                        <!-- Contenu pour les utilisateurs connectés -->
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                        <p>Cliquez ici pour vous connecter</p>
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</body>
</html>
