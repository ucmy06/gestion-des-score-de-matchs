@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="w-full max-w-md p-8 bg-gray-100 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Connexion</h2>

        <!-- Affichage des erreurs -->
        @if ($errors->has('login_error'))
            <div class="mb-4 text-sm text-red-600">
                {{ $errors->first('login_error') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" class="block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-gray-900 bg-gray-50 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required autofocus>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Mot de passe</label>
                <input type="password" id="password" name="password" class="block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-gray-900 bg-gray-50 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <a class="text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Se connecter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
