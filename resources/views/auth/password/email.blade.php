@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-white-100">
    <div class="w-full max-w-md p-8 bg-gray-100 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Réinitialiser le Mot de Passe</h2>

        @if (session('status'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Envoyer le lien de réinitialisation
                </button>
                <!-- Retour au login -->
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Retour à la connexion
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
