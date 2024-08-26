@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Match</h1>

    <form action="{{ route('admin.matches.update', $match->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Champs cachés pour les scores finaux et le temps d'attente -->
        <input type="hidden" id="final_score_team_1" name="score_team_1" value="{{ old('score_team_1', $match->score_team_1) }}">
        <input type="hidden" id="final_score_team_2" name="score_team_2" value="{{ old('score_team_2', $match->score_team_2) }}">
        <input type="hidden" id="match_duration" name="match_duration" value="{{ old('match_duration', $match->duration ?? 0) }}">
        <input type="hidden" id="wait_time" name="wait_time" value="{{ old('wait_time', $match->wait_time ?? 0) }}">

        <!-- Valeur d'incrémentation -->
        <div class="form-group">
            <label for="increment_value">Valeur d'Incrémentation</label>
            <input type="range" id="increment_value" name="increment_value" class="form-control" min="1" max="100" step="1" value="1">
            <output id="increment_display">1</output>
        </div>

        <!-- Score Équipe 1 -->
        <div class="form-group">
            <label for="score_team_1">Score Équipe 1</label>
            <input type="number" id="score_team_1_display" name="score_team_1_display" class="form-control" value="{{ old('score_team_1', $match->score_team_1) }}" readonly>
            <input type="hidden" id="score_team_1" name="score_team_1" value="{{ old('score_team_1', $match->score_team_1) }}">
            <button type="button" id="increase_score_team_1" class="btn btn-success">Incrémenter Score Équipe 1</button>
            <button type="button" id="decrease_score_team_1" class="btn btn-danger">Décrémenter Score Équipe 1</button>
        </div>

        <!-- Score Équipe 2 -->
        <div class="form-group">
            <label for="score_team_2">Score Équipe 2</label>
            <input type="number" id="score_team_2_display" name="score_team_2_display" class="form-control" value="{{ old('score_team_2', $match->score_team_2) }}" readonly>
            <input type="hidden" id="score_team_2" name="score_team_2" value="{{ old('score_team_2', $match->score_team_2) }}">
            <button type="button" id="increase_score_team_2" class="btn btn-success">Incrémenter Score Équipe 2</button>
            <button type="button" id="decrease_score_team_2" class="btn btn-danger">Décrémenter Score Équipe 2</button>
        </div>

        <!-- Temps d'attente -->
        <div class="form-group">
            <label for="wait_time">Temps d'Attente</label>
            <input type="number" id="wait_time" name="wait_time" class="form-control" value="{{ old('wait_time', $match->wait_time ?? 0) }}">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary">Retour à la liste des matchs</a>
    <a href="{{ route('admin.matches.show', $match->id) }}" class="btn btn-primary">Afficher le Match</a>

    <div class="timer-config">
        <h2>Configuration du Chronomètre</h2>
        <div>
            <label for="duree_impro_min">Minutes:</label>
            <input type="number" id="duree_impro_min" value="{{ old('duree_impro_min', floor($match->duration / 60)) }}">
            <label for="duree_impro_sec">Secondes:</label>
            <input type="number" id="duree_impro_sec" value="{{ old('duree_impro_sec', $match->duration % 60) }}">
            <button type="button" id="start_timer_impro" class="btn btn-primary">Démarrer Chronomètre</button>
        </div>
    </div>
</div>

@php
    $matchDuration = $match->duration ?? 0;
@endphp

<script src="{{ asset('js/fullscreen.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scoreTeam1Range = document.getElementById('score_team_1');
    const scoreTeam1Display = document.getElementById('score_team_1_display');
    const scoreTeam2Range = document.getElementById('score_team_2');
    const scoreTeam2Display = document.getElementById('score_team_2_display');
    const incrementValueRange = document.getElementById('increment_value');
    const incrementDisplay = document.getElementById('increment_display');
    const matchDurationInput = document.getElementById('match_duration');
    const waitTimeInput = document.getElementById('wait_time');

    function updateHiddenScores() {
        document.getElementById('final_score_team_1').value = scoreTeam1Range.value;
        document.getElementById('final_score_team_2').value = scoreTeam2Range.value;
    }

    function updateDisplay() {
        scoreTeam1Display.value = scoreTeam1Range.value;
        scoreTeam2Display.value = scoreTeam2Range.value;
    }

    function autoSave() {
        fetch("{{ route('admin.matches.update', $match->id) }}", {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                score_team_1: scoreTeam1Range.value,
                score_team_2: scoreTeam2Range.value,
                wait_time: waitTimeInput.value,
                match_duration: matchDurationInput.value
                
            })
        }).then(response => {
            if (response.ok) {
                console.log('Match saved');
            } else {
                console.error('Failed to save match');
            }
        });
    }

    document.getElementById('increase_score_team_1').addEventListener('click', function() {
        let incrementValue = parseInt(incrementValueRange.value);
        scoreTeam1Range.value = parseInt(scoreTeam1Range.value) + incrementValue;
        updateDisplay();
        updateHiddenScores();
        autoSave();
    });

    document.getElementById('decrease_score_team_1').addEventListener('click', function() {
        let decrementValue = parseInt(incrementValueRange.value);
        scoreTeam1Range.value = parseInt(scoreTeam1Range.value) - decrementValue;
        updateDisplay();
        updateHiddenScores();
        autoSave();
    });

    document.getElementById('increase_score_team_2').addEventListener('click', function() {
        let incrementValue = parseInt(incrementValueRange.value);
        scoreTeam2Range.value = parseInt(scoreTeam2Range.value) + incrementValue;
        updateDisplay();
        updateHiddenScores();
        autoSave();
    });

    document.getElementById('decrease_score_team_2').addEventListener('click', function() {
        let decrementValue = parseInt(incrementValueRange.value);
        scoreTeam2Range.value = parseInt(scoreTeam2Range.value) - decrementValue;
        updateDisplay();
        updateHiddenScores();
        autoSave();
    });

    incrementValueRange.addEventListener('input', function() {
        incrementDisplay.textContent = incrementValueRange.value;
    });

    // Configuration du chronomètre
    document.getElementById('start_timer_impro').addEventListener('click', function() {
        const minutes = parseInt(document.getElementById('duree_impro_min').value, 10) || 0;
        const seconds = parseInt(document.getElementById('duree_impro_sec').value, 10) || 0;
        const duration = minutes * 60 + seconds;

        matchDurationInput.value = duration;
    });
});
</script>
@endsection
