@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Matchs</h1>
    <a href="{{ route('employee.matches.create') }}" class="btn btn-primary">Ajouter un Match</a>
    <!-- @if(auth()->user()->role === 'admin')
        <a href="{{ route('employee.matches.create') }}" class="btn btn-primary">Ajouter un Match</a>
    @endif -->
    
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
                <td>{{ $match->team1 ? $match->team1->name : 'Équipe supprimée' }}</td>
                <td>{{ $match->team2 ? $match->team2->name : 'Équipe supprimée' }}</td>
                <td>{{ $match->score_team_1 }}</td>
                <td>{{ $match->score_team_2 }}</td>
                <td>
                    <a href="{{ route('employee.matches.show', $match->id) }}" class="btn btn-info">Voir journal du match</a>
                    @if(auth()->user()->role === 'employee')
                        <a href="{{ route('employee.matches.edit', $match->id) }}" class="btn btn-warning">Lancer le match</a>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <form action="{{ route('employee.matches.destroy', $match->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
