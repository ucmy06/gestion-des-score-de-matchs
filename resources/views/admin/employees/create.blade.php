@extends('layouts.app')

@section('title', 'Créer un Employé')

@section('content')
    <style>
        /* Styles généraux */
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff; /* Blanc */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre subtile */
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748; /* Gris foncé */
            margin-bottom: 20px;
            text-align: center;
        }

        /* Styles pour les labels */
        label {
            display: block;
            font-weight: 600;
            color: #4a5568; /* Gris moyen */
            margin-bottom: 8px;
        }

        /* Styles pour les champs de formulaire */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e0; /* Gris clair */
            border-radius: 8px;
            font-size: 16px;
            color: #2d3748; /* Gris foncé */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4299e1; /* Bleu */
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5); /* Effet de focus */
        }

        /* Styles pour les boutons */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4299e1; /* Bleu */
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #3182ce; /* Bleu plus foncé */
        }
    </style>

    <div class="container">
        <h1>Créer un Employé</h1>

        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="mb-4">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="mb-6">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Créer</button>
        </form>
    </div>
@endsection
