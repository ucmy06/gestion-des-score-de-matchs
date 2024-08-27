@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-6">
    <div class="w-full max-w-4xl p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4 text-center text-gray-900">Bienvenue sur le Tableau de Bord</h1>
        <p class="text-center text-gray-700 mb-6">Ceci est la page d'accueil après la connexion.</p>

        @if(auth()->check() && auth()->user()->role === 'admin')
            <p class="text-center text-lg text-gray-800 mb-4">Vous êtes connecté en tant qu'administrateur.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">Tableau de Bord Admin</a>
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-600 text-white py-2 px-4 rounded-md shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-150 ease-in-out">Gérer les Employés</a>
                <a href="{{ route('admin.matches.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">Gérer les Matchs</a>
            </div>
        @elseif(auth()->check() && auth()->user()->role === 'employee')
            <p class="text-center text-lg text-gray-800 mb-4">Vous êtes connecté en tant qu'employé.</p>
            
            
        @endif
    </div>
</div>
@endsection
