<!-- resources/views/admin/create_employee.blade.php -->

@extends('layouts.app')

@section('title', 'Créer un Employé')

@section('content')
    <h1>Créer un Employé</h1>

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmer le mot de passe:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div>
            <button type="submit">Créer l'Employé</button>
        </div>
    </form>
@endsection
