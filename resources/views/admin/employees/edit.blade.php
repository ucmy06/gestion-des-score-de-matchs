@extends('layouts.app')

@section('title', 'Modifier l\'Employé')

@section('content')
    <h1>Modifier l'Employé</h1>

    <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $employee->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $employee->email }}" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection

