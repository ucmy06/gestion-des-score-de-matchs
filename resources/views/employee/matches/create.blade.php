@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Ajouter un Match</h1>

    <form action="{{ route('employee.matches.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label for="team_1_id" class="form-label">Équipe 1</label>
            <select name="team_1_id" id="team_1_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="team_2_id" class="form-label">Équipe 2</label>
            <select name="team_2_id" id="team_2_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="score_team_1" class="form-label">Score Équipe 1</label>
            <input type="number" name="score_team_1" id="score_team_1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="score_team_2" class="form-label">Score Équipe 2</label>
            <input type="number" name="score_team_2" id="score_team_2" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="match_duration" class="form-label">Durée du match</label>
            <input type="number" name="match_duration" id="match_duration" class="form-control">
        </div>

        <div class="mb-3">
            <label for="wait_time" class="form-label">Temps d'attente (optionnel)</label>
            <input type="number" name="wait_time" id="wait_time" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>

</div>

@endsection
