@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier le Match</h1>

    <form action="{{ route('employee.matches.update', $match->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Champs cachés pour les scores finaux et le temps d'attente -->
        <input type="hidden" id="final_score_team_1" name="score_team_1" value="{{ old('score_team_1', $match->score_team_1) }}">
        <input type="hidden" id="final_score_team_2" name="score_team_2" value="{{ old('score_team_2', $match->score_team_2) }}">
        <input type="hidden" id="match_duration" name="match_duration" value="{{ old('match_duration', $match->duration ?? 0) }}">
        <input type="hidden" id="wait_time" name="wait_time" value="{{ old('wait_time', $match->wait_time ?? 0) }}">

        <!-- Tableau pour les équipes -->
        <table class="table-wide border-separate border-spacing-6 mb-6 table-spacing">
            <tbody>
                <tr>
                    <!-- Score Équipe 1 (à gauche) -->
                    <td class="bg-gray-200 rounded p-4 border border-gray-300">
                        <h2 class="text-xl font-semibold mb-4">Équipe 1</h2>
                        <label for="score_team_1_display" class="block text-sm mb-2">Score</label>
                        <input type="number" id="score_team_1_display" name="score_team_1_display" class="form-control w-full" value="{{ old('score_team_1', $match->score_team_1) }}" readonly>
                        <input type="hidden" id="score_team_1" name="score_team_1" value="{{ old('score_team_1', $match->score_team_1) }}">
                        <button type="button" id="increase_score_team_1" class="btn btn-success mt-2">Incrémenter Score</button>
                        <button type="button" id="decrease_score_team_1" class="btn btn-danger mt-2">Décrémenter Score</button>
                    </td>

                    <!-- Score Équipe 2 (à droite) -->
                    <td class="bg-gray-200 rounded p-4 border border-gray-300">
                        <h2 class="text-xl font-semibold mb-4 text-right">Équipe 2</h2>
                        <label for="score_team_2_display" class="block text-sm mb-2">Score</label>
                        <input type="number" id="score_team_2_display" name="score_team_2_display" class="form-control w-full" value="{{ old('score_team_2', $match->score_team_2) }}" readonly>
                        <input type="hidden" id="score_team_2" name="score_team_2" value="{{ old('score_team_2', $match->score_team_2) }}">
                        <button type="button" id="increase_score_team_2" class="btn btn-success mt-2">Incrémenter Score</button>
                        <button type="button" id="decrease_score_team_2" class="btn btn-danger mt-2">Décrémenter Score</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Tableau pour le temps d'attente, la valeur d'incrémentation et le chronomètre -->
        <table class="table-wide border-separate border-spacing-6 increment-table">
            <tbody>
                <tr>
                    <!-- Temps d'Attente (à gauche) -->
                    <td class="w-1/3 bg-gray-200 rounded p-4 border border-gray-300">
                        <h2 class="text-xl font-semibold mb-4">Temps d'Attente</h2>
                        <div class="form-group mb-6">
                            <div class="flex flex-col items-center mb-2 w-full">
                                <label for="wait_time_min" class="mb-1">Minutes:</label>
                                <input type="number" id="wait_time_min" class="form-control w-full" value="{{ old('wait_time_min', floor($match->wait_time / 60)) }}" min="0">
                            </div>
                            <div class="flex flex-col items-center w-full">
                                <label for="wait_time_sec" class="mb-1">Secondes:</label>
                                <input type="number" id="wait_time_sec" class="form-control w-full" value="{{ old('wait_time_sec', $match->wait_time % 60) }}" min="0">
                            </div>
                            <button type="button" id="save_wait_time" class="btn btn-primary mt-4">Enregistrer</button>
                        </div>
                    </td>

                    <!-- Valeur d'Incrémentation (au centre) -->
                    <td class="w-1/3 bg-gray-200 rounded p-4 border border-gray-300">
                        <h2 class="text-xl font-semibold mb-4 text-center">Valeur d'Incrémentation</h2>
                        <div class="form-group mb-6">
                            <input type="range" id="increment_value" name="increment_value" class="form-control w-full" min="1" max="100" step="1" value="1">
                            <output id="increment_display" class="block mt-2 text-center">1</output>
                        </div>
                    </td>

                    <!-- Chronomètre (à droite) -->
                    <td class="w-1/3 bg-gray-200 rounded p-4 border border-gray-300">
                        <h2 class="text-xl font-semibold mb-4 text-center">Chronomètre</h2>
                        <div class="form-group">
                            <div class="flex flex-col items-center mb-2 w-full">
                                <label for="duree_impro_min" class="mb-1">Minutes:</label>
                                <input type="number" id="duree_impro_min" class="form-control w-full" value="{{ old('duree_impro_min', floor($match->duration / 60)) }}" min="0">
                            </div>
                            <div class="flex flex-col items-center w-full">
                                <label for="duree_impro_sec" class="mb-1">Secondes:</label>
                                <input type="number" id="duree_impro_sec" class="form-control w-full" value="{{ old('duree_impro_sec', $match->duration % 60) }}" min="0">
                            </div>
                            <button type="button" id="start_timer_impro" class="btn btn-primary mt-4">Enregistrer</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary mt-4">Enregistrer</button>
    </form>

    <!-- Conteneur des boutons -->
    <div class="button-group mt-6">
        <a href="{{ route('employee.matches.index') }}" class="btn btn-secondary">Retour à la liste des matchs</a>
        <a href="{{ route('employee.matches.show', $match->id) }}" class="btn btn-primary">Afficher le Match</a>
        <a href="{{ route('display.match', $match->id) }}" id="fullscreen_button" class="btn btn-primary">Lancer l'affichage du match</a>
        <a href="{{ route('wait_time', ['matchId' => $match->id]) }}" id="fullscreen_button" class="btn btn-success">Lancer l'affichage en premier plan</a>
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
    const waitTimeMinInput = document.getElementById('wait_time_min');
    const waitTimeSecInput = document.getElementById('wait_time_sec');
    const startTimerImproButton = document.getElementById('start_timer_impro');
    const saveWaitTimeButton = document.getElementById('save_wait_time');

    function updateHiddenScores() {
        document.getElementById('final_score_team_1').value = scoreTeam1Range.value;
        document.getElementById('final_score_team_2').value = scoreTeam2Range.value;
    }

    function updateDisplay() {
        scoreTeam1Display.value = scoreTeam1Range.value;
        scoreTeam2Display.value = scoreTeam2Range.value;
    }

    function autoSave() {
        fetch("{{ route('employee.matches.update', $match->id) }}", {
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

    saveWaitTimeButton.addEventListener('click', function() {
        let waitTimeMinutes = parseInt(waitTimeMinInput.value) || 0;
        let waitTimeSeconds = parseInt(waitTimeSecInput.value) || 0;
        waitTimeInput.value = waitTimeMinutes * 60 + waitTimeSeconds;
        autoSave();
    });

    startTimerImproButton.addEventListener('click', function() {
        let durationMinutes = parseInt(document.getElementById('duree_impro_min').value) || 0;
        let durationSeconds = parseInt(document.getElementById('duree_impro_sec').value) || 0;
        matchDurationInput.value = durationMinutes * 60 + durationSeconds;
        autoSave();
    });
});
</script>
<style>

    /* CSS pour les tableaux */
.table-wide {
    width: 100%;
    max-width: 1200px; /* Ajustez la largeur maximale selon vos besoins */
    margin: 0 auto; /* Centre la table */
}

.table-wide td {
    padding: 16px; /* Ajustez l'espacement des cellules si nécessaire */
}

.table-spacing td {
    padding: 16px;
    margin: 0 10px; /* Espace entre les cellules */
}

/* Ajustement spécifique pour la valeur d'incrémentation */
.increment-table td {
    width: 30%; /* Réduit la largeur pour créer plus d'espace */
}

.increment-table .form-group {
    margin-bottom: 1rem;
}
    /* CSS pour les champs de score */
    .form-control {
        background-color: #f5f5f5;
        border-radius: 4px;
    }
    
    .button-group {
        display: flex;
        justify-content: center; /* Align buttons horizontally in the center */
        margin-top: auto; /* Push the button group to the bottom */
        gap: 10px; /* Space between buttons */
    }

    .button-group .btn {
        font-size: 0.9rem;
        padding: 8px 12px;
    }

    .btn-success {
        background-color: green;
        color: white;
        border: none;
    }
    
    .btn-danger {
        background-color: red;
        color: white;
        border: none;
    }
    
    .btn-primary {
        background-color: blue;
        color: white;
        border: none;
    }
    
    .btn-secondary {
        background-color: grey;
        color: white;
        border: none;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }

    .form-control {
        background-color: #f5f5f5;
        border-radius: 4px;
    }

    .btn-success, .btn-danger, .btn-primary, .btn-secondary {
        color: white;
        border-radius: 4px;
        width: 100%;
    }

    h2 {
        margin-bottom: 15px;
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .ml-2 {
        margin-left: 8px;
    }

    .mt-2 {
        margin-top: 8px;
    }

    .mt-4 {
        margin-top: 16px;
    }
</style>
@endsection