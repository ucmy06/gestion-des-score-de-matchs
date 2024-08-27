@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-white-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-900">Réinitialiser le Mot de Passe</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ $email }}" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Nouveau Mot de Passe</label>
                <input type="password" name="password" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-1">Confirmer le Mot de Passe</label>
                <input type="password" name="password_confirmation" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Réinitialiser le Mot de Passe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
