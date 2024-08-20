@extends('layouts.app')

@section('title', 'Liste des Employés')

@section('content')
    <h1>Liste des Employés</h1>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">Ajouter un Employé</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
