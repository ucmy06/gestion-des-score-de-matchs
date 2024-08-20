@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Match</h1>

    <p>ID: {{ $match->id }}</p>
    <p>Équipe 1: {{ $match->team1 ? $match->team1->name : 'Non spécifiée' }}</p>
    <p>Équipe 2: {{ $match->team2 ? $match->team2->name : 'Non spécifiée' }}</p>
    <p>Score Équipe 1: {{ $match->score_team_1 }}</p>
    <p>Score Équipe 2: {{ $match->score_team_2 }}</p>

    <h3>Journal des Actions</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->user->name }}</td>
                <td>
                    @if($log->change_type === 'increment')
                        L'équipe {{ $log->match->team1->name }} a marqué {{ $log->points_changed }} point(s) à {{ $log->changed_at->format('d/m/Y H:i') }}
                    @elseif($log->change_type === 'decrement')
                        L'équipe {{ $log->match->team2->name }} a reçu une pénalité de {{ $log->points_changed }} point(s) à {{ $log->changed_at->format('d/m/Y H:i') }}
                    @else
                        {{ $log->action }}
                    @endif
                </td>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    
    </table>
    
</div>
@endsection
