@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Match</h1>
    <form action="{{ route('admin.matches.store') }}" method="POST">
    @csrf
    <div>
        <label for="team_1_id">Team 1</label>
        <select name="team_1_id" id="team_1_id">
            @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="team_2_id">Team 2</label>
        <select name="team_2_id" id="team_2_id">
            @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="score_team_1">Score Team 1</label>
        <input type="number" name="score_team_1" id="score_team_1">
    </div>
    <div>
        <label for="score_team_2">Score Team 2</label>
        <input type="number" name="score_team_2" id="score_team_2">
    </div>
    <div>
        <label for="match_duration">Durée du match</label>
        <input type="number" name="match_duration" id="match_duration" class="form-control">
    </div>
    <div>
        <label for="wait_time">Temps d'attente (optionnel)</label>
        <input type="number" name="wait_time" id="wait_time" class="form-control">
    </div>
    <button type="submit">Creer Match</button>
</form>

</div>
@endsection
