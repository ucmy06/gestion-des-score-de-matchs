@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gérer les matchs</h2>

    <!-- Affichage des détails du match -->
    <div class="match-details">
        <h3>Match: {{ $match->team1->name }} vs {{ $match->team2->name }}</h3>
        <p>Date: {{ $match->match_date->format('d/m/Y H:i') }}</p>
        <p>Score: {{ $match->score_team_1 }} - {{ $match->score_team_2 }}</p>

        <!-- Compte à rebours -->
        <div id="countdown" data-countdown="{{ $match->countdown }}"></div>
    </div>

    <!-- Formulaire pour mettre à jour le score ou autres actions -->
    <form method="POST" action="{{ route('matches.update', $match->id) }}">
        @csrf
        @method('PUT')

        <!-- Exemple de champ pour mettre à jour le score -->
        <div class="form-group">
            <label for="score_team_1">Score de l'équipe 1</label>
            <input type="number" id="score_team_1" name="score_team_1" class="form-control" value="{{ $match->score_team_1 }}" required>
        </div>

        <div class="form-group">
            <label for="score_team_2">Score de l'équipe 2</label>
            <input type="number" id="score_team_2" name="score_team_2" class="form-control" value="{{ $match->score_team_2 }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let countdownElement = document.getElementById('countdown');
    let countdownTime = parseInt(countdownElement.getAttribute('data-countdown'));
    
    function updateCountdown() {
        let minutes = Math.floor(countdownTime / 60);
        let seconds = countdownTime % 60;
        countdownElement.innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        countdownTime--;

        if (countdownTime < 0) {
            countdownElement.innerText = '00:00';
            clearInterval(countdownInterval);
        }
    }

    let countdownInterval = setInterval(updateCountdown, 1000);
});
</script>
@endsection
