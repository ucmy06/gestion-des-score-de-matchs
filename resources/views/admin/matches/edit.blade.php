@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier le Match</h1>
    <form action="{{ route('admin.matches.update', $match->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Conteneur pour structurer la page -->
        <div class="flex justify-between space-x-6">
            <!-- Score Équipe 1 -->
            <div class="w-1/2 bg-gray-200 rounded p-4">
                <h2 class="text-xl font-semibold mb-4">Équipe 1</h2>
                <label for="score_team_1_display" class="block text-sm mb-2">Score</label>
                <input type="number" id="score_team_1_display" name="score_team_1_display" class="form-control w-full bg-gray-100 rounded p-2" value="{{ old('score_team_1', $match->score_team_1) }}" readonly>
                <input type="hidden" id="score_team_1" name="score_team_1" value="{{ old('score_team_1', $match->score_team_1) }}">
                <button type="button" id="increase_score_team_1" class="btn btn-success w-full mt-2">Incrémenter Score</button>
                <button type="button" id="decrease_score_team_1" class="btn btn-danger w-full mt-2">Décrémenter Score</button>
            </div>

            <!-- Score Équipe 2 -->
            <div class="w-1/2 bg-gray-200 rounded p-4">
                <h2 class="text-xl font-semibold mb-4 text-right">Équipe 2</h2>
                <label for="score_team_2_display" class="block text-sm mb-2">Score</label>
                <input type="number" id="score_team_2_display" name="score_team_2_display" class="form-control w-full bg-gray-100 rounded p-2" value="{{ old('score_team_2', $match->score_team_2) }}" readonly>
                <input type="hidden" id="score_team_2" name="score_team_2" value="{{ old('score_team_2', $match->score_team_2) }}">
                <button type="button" id="increase_score_team_2" class="btn btn-success w-full mt-2">Incrémenter Score</button>
                <button type="button" id="decrease_score_team_2" class="btn btn-danger w-full mt-2">Décrémenter Score</button>
            </div>
        </div>

        <!-- Chronomètre, Incrémentation et Temps d'Attente -->
        <div class="flex justify-between mt-6">
            <!-- Temps d'Attente à gauche -->
            <div class="w-1/2 bg-gray-200 rounded p-4 flex flex-col items-center">
                <div class="form-group mb-6 w-full">
                    <label for="wait_time" class="block text-sm mb-2 text-center">Temps d'Attente</label>
                    <div class="flex flex-col items-center">
                        <div class="flex flex-col items-center mb-2 w-full">
                            <label for="wait_time_min" class="mb-1">Minutes:</label>
                            <input type="number" id="wait_time_min" class="form-control w-full bg-gray-100 rounded p-2" value="{{ old('wait_time_min', floor($match->wait_time / 60)) }}" min="0">
                        </div>
                        <div class="flex flex-col items-center w-full">
                            <label for="wait_time_sec" class="mb-1">Secondes:</label>
                            <input type="number" id="wait_time_sec" class="form-control w-full bg-gray-100 rounded p-2" value="{{ old('wait_time_sec', $match->wait_time % 60) }}" min="0">
                        </div>
                        <button type="button" id="save_wait_time" class="btn btn-primary mt-4 w-full">Enregistrer</button>
                    </div>
                </div>
            </div>

            <!-- Incrémentation au centre -->
            <div class="w-1/2 bg-gray-200 rounded p-4 flex flex-col items-center">
                <!-- Valeur d'incrémentation -->
                <div class="form-group mb-6 w-full">
                    <label for="increment_value" class="block text-sm mb-2 text-center">Valeur d'Incrémentation</label>
                    <input type="range" id="increment_value" name="increment_value" class="form-control w-full bg-gray-100 rounded p-2" min="1" max="100" step="1" value="1">
                    <output id="increment_display" class="block mt-2 text-center">1</output>
                </div>
            </div>

            <!-- Chronomètre à droite -->
            <div class="w-1/2 bg-gray-200 rounded p-4 flex flex-col items-center">
                <div class="form-group w-full">
                    <h2 class="text-xl font-semibold mb-4 text-center">Chronomètre</h2>
                    <div class="flex flex-col items-center">
                        <div class="flex flex-col items-center mb-2 w-full">
                            <label for="duree_impro_min" class="mb-1">Minutes:</label>
                            <input type="number" id="duree_impro_min" class="form-control w-full bg-gray-100 rounded p-2" value="{{ old('duree_impro_min', floor($match->duration / 60)) }}" min="0">
                        </div>
                        <div class="flex flex-col items-center w-full">
                            <label for="duree_impro_sec" class="mb-1">Secondes:</label>
                            <input type="number" id="duree_impro_sec" class="form-control w-full bg-gray-100 rounded p-2" value="{{ old('duree_impro_sec', $match->duration % 60) }}" min="0">
                        </div>
                        <button type="button" id="start_timer_impro" class="btn btn-primary mt-4 w-full">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Enregistrer</button>
    </form>

    <!-- Conteneur des boutons -->
    <div class="button-group mt-6 flex justify-center space-x-4">
        <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary">Retour à la liste des matchs</a>
        <a href="{{ route('admin.matches.show', $match->id) }}" class="btn btn-primary">Afficher le Match</a>
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
        scoreTeam1Range.value = Math.max(0, parseInt(scoreTeam1Range.value) - decrementValue);
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
        scoreTeam2Range.value = Math.max(0, parseInt(scoreTeam2Range.value) - decrementValue);
        updateDisplay();
        updateHiddenScores();
        autoSave();
    });

    startTimerImproButton.addEventListener('click', function() {
        let minutes = parseInt(document.getElementById('duree_impro_min').value);
        let seconds = parseInt(document.getElementById('duree_impro_sec').value);
        matchDurationInput.value = (minutes * 60) + seconds;
        autoSave();
    });

    saveWaitTimeButton.addEventListener('click', function() {
        let minutes = parseInt(waitTimeMinInput.value);
        let seconds = parseInt(waitTimeSecInput.value);
        waitTimeInput.value = (minutes * 60) + seconds;
        autoSave();
    });

    incrementValueRange.addEventListener('input', function() {
        incrementDisplay.innerText = incrementValueRange.value;
    });
});
</script>



<style>

    /* CSS pour les champs de score */
    .form-control {
        background-color: #f5f5f5;
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

.button-group .btn:last-child {
    margin-right: 0;
}
    .btn-success {
        background-color: green;
        color: white;
    }
    
    .btn-danger {
        background-color: red;
        color: white;
    }
    
    .btn-primary {
        background-color: blue;
        color: white;
    }
    
    .btn-secondary {
        background-color: grey;
        color: white;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }

   /* Alignement horizontal des éléments */
   .container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-group {
    margin-bottom: 1rem;
    width: 30%;
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
