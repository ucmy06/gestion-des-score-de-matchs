@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Matchs</h1>
    
    <!-- Réactiver le bouton d'ajout -->
    <a href="{{ route('admin.matches.create') }}" class="btn btn-primary">Ajouter un Match</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Équipe 1</th>
                <th>Équipe 2</th>
                <th>Score Équipe 1</th>
                <th>Score Équipe 2</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matches as $match)
            <tr>
                <td>{{ $match->id }}</td>
                <td>{{ $match->team1 ? $match->team1->name : 'N/A' }}</td>
                <td>{{ $match->team2 ? $match->team2->name : 'N/A' }}</td>
                <td>{{ $match->score_team_1 }}</td>
                <td>{{ $match->score_team_2 }}</td>
                <td>
                    <a href="{{ route('admin.matches.show', $match->id) }}" class="btn btn-info">Voir journal du match</a>
                    <a href="{{ route('admin.matches.edit', $match->id) }}" class="btn btn-warning">lancer le match</a>
                    <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
