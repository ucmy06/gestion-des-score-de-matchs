@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Match</h1>

    <p>ID: {{ $match->id }}</p>
    <p>Équipe 1: {{ $match->team1 ? $match->team1->name : 'Non spécifiée' }}</p>
    <p>Équipe 2: {{ $match->team2 ? $match->team2->name : 'Non spécifiée' }}</p>
    <p>Score Équipe 1: {{ $match->score_team_1 }}</p>
    <p>Score Équipe 2: {{ $match->score_team_2 }}</p>
    <p>Date du Match: {{ $match->match_date ? \Carbon\Carbon::parse($match->match_date)->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
    <p>Date de Création: {{ $match->created_at ? $match->created_at->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
    <p>Date de Mise à Jour: {{ $match->updated_at ? $match->updated_at->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
    <p>Créé par: {{ $match->creator ? $match->creator->name : 'Non spécifié' }}</p>

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
            @forelse($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->user ? $log->user->name : 'Non spécifié' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : 'Non spécifiée' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Aucune action enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
