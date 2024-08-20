@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenue sur le Tableau de Bord</h1>
    <p>Ceci est la page d'accueil après la connexion.</p>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <p>Vous êtes connecté en tant qu'administrateur.</p>
        <div class="btn-group">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Tableau de Bord Admin</a>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Gérer les Employés</a>
            <a href="{{ route('admin.matches.index') }}" class="btn btn-info">Gérer les Matchs</a>
        </div>
    @elseif(auth()->check() && auth()->user()->role === 'employee')
        <p>Vous êtes connecté en tant qu'employé.</p>
        <div class="btn-group">
            <a href="{{ route('employee.dashboard') }}" class="btn btn-primary">Tableau de Bord Employé</a>
            <a href="{{ route('employee.matches.index') }}" class="btn btn-info">Gérer les Matchs</a>
        </div>
    @endif
</div>
@endsection
