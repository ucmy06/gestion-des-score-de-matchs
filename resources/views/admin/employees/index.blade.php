@extends('layouts.app')

@section('title', 'Liste des Employés')

@section('content')
    <style>
        /* Styles généraux */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748; /* Couleur du texte : gris foncé */
            margin-bottom: 20px;
        }

        /* Styles pour les messages de succès */
        .alert-success {
            background-color: #e6fffa;
            color: #2f855a;
            border: 1px solid #b2f5ea;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Styles pour les boutons */
        .btn-primary {
            background-color: #4299e1; /* Couleur bleu */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background-color: #3182ce; /* Couleur bleu plus foncé */
        }

        .btn-warning {
            background-color: #ecc94b; /* Couleur jaune */
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-warning:hover {
            background-color: #d69e2e; /* Couleur jaune plus foncé */
        }

        .btn-danger {
            background-color: #e53e3e; /* Couleur rouge */
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c53030; /* Couleur rouge plus foncé */
        }

        /* Styles pour la table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0; /* Couleur gris clair */
            color: #2d3748; /* Couleur du texte : gris foncé */
        }

        th {
            background-color: #edf2f7; /* Couleur gris clair */
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f7fafc; /* Couleur gris très clair au survol */
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 20px;
            }

            th, td {
                padding: 8px;
                font-size: 14px;
            }

            .btn-primary, .btn-warning, .btn-danger {
                padding: 8px 10px;
                font-size: 14px;
            }
        }
    </style>

    <div class="container">
        <h1>Liste des Employés</h1>
        
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div>
            <a href="{{ route('admin.employees.create') }}" class="btn-primary">Ajouter un Employé</a>
        </div>

        <div class="table-responsive">
            <table>
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
                                <div>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn-warning">Modifier</a>
                                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
