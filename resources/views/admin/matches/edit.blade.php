@extends('layouts.app')

@section('content')
    <h1>Edit Match</h1>

    <form action="{{ route('admin.matches.update', $match->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="team_1_id">Team 1</label>
            <select name="team_1_id" id="team_1_id" class="form-control">
                @foreach ($teams as $team)
                    <option value="{{ $team->id }}" {{ $team->id == $match->team_1_id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="team_2_id">Team 2</label>
            <select name="team_2_id" id="team_2_id" class="form-control">
                @foreach ($teams as $team)
                    <option value="{{ $team->id }}" {{ $team->id == $match->team_2_id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="score_team_1">Score Team 1</label>
            <input type="number" name="score_team_1" id="score_team_1" class="form-control" value="{{ $match->score_team_1 }}">
        </div>

        <div class="form-group">
            <label for="score_team_2">Score Team 2</label>
            <input type="number" name="score_team_2" id="score_team_2" class="form-control" value="{{ $match->score_team_2 }}">
        </div>

        <div class="form-group">
</div>
<!-- <div class="form-group">
        <label for="status">Statut</label>
        <input type="text" name="status" id="status" class="form-control" value="{{ old('status', $match->status) }}" placeholder="Statut du match">
    </div> -->

        <button type="submit" class="btn btn-primary">lancer le match </button>
        <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary">Retour à la liste des matchs</a>
    </form>
         <!-- Bouton pour afficher le match -->
         <a href="{{ route('admin.matches.show', $match->id) }}" class="btn btn-primary">Afficher le Match</a>
        <a href="{{ route('display.match', $match->id) }}" target="_blank" class="btn btn-primary">Lancer l'affichage du match</a>

@endsection
