<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage du Match</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
            padding-top: 50px;
        }
        .text-center {
            text-align: center;
        }
        .img-fluid {
            max-height: 150px;
            margin-bottom: 10px;
        }
        #timer_display {
            font-size: 2rem;
            color: #fff;
            margin-top: 20px;
        }
        #wait_message {
            font-size: 1.5rem;
            color: #ff0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-5 text-center">
                <h3>{{ $match->team1->name }}</h3>
                <h4>Score</h4>
                <h5 id="score-team-1">{{ $match->score_team_1 }}</h5>
                <img src="{{ asset('storage/' . $match->team1->logo) }}" alt="Logo {{ $match->team1->name }}" class="img-fluid" id="logo-team-1">
            </div>

            <div class="col-md-2 text-center">
                <h2>Chronomètre</h2>
                <div id="wait_message" style="display: none;">Temps d'attente avant début du match</div>
                <div id="timer_display" data-duration="{{ $match->duration }}" data-start-time="{{ $startTime }}" data-wait-time="{{ $match->wait_time }}"></div>
            </div>

            <div class="col-md-5 text-center">
                <h3>{{ $match->team2->name }}</h3>
                <h4>Score</h4>
                <h5 id="score-team-2">{{ $match->score_team_2 }}</h5>
                <img src="{{ asset('storage/' . $match->team2->logo) }}" alt="Logo {{ $match->team2->name }}" class="img-fluid" id="logo-team-2">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@pusher/pusher-js@7.0.3/dist/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@laravel/echo@1.11.0/dist/echo.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var matchId = <?php echo json_encode($match->id); ?>;
            console.log('Match ID:', matchId);

            const timerDisplay = document.getElementById('timer_display');
            const waitMessage = document.getElementById('wait_message');
            const matchDuration = parseInt(timerDisplay.getAttribute('data-duration'), 10);
            const startTime = new Date(timerDisplay.getAttribute('data-start-time')).getTime();
            const waitTime = parseInt(timerDisplay.getAttribute('data-wait-time'), 10) || 0;
            let now = new Date().getTime();
            const elapsedTime = Math.floor((now - startTime) / 1000);
            let remainingWaitTime = Math.max(waitTime - elapsedTime, 0);
            let remainingMatchTime = Math.max(matchDuration - Math.max(elapsedTime - waitTime, 0), 0);

            function updateTimer(remaining) {
                let minutes = Math.floor(remaining / 60);
                let seconds = remaining % 60;

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.textContent = `${minutes}:${seconds}`;
            }

            function startMatchTimer() {
                const matchInterval = setInterval(() => {
                    if (remainingMatchTime <= 0) {
                        clearInterval(matchInterval);
                        return;
                    }
                    remainingMatchTime--;
                    updateTimer(remainingMatchTime);
                }, 1000);
            }

            function startWaitTimer() {
                waitMessage.style.display = 'block'; // Affiche le message d'attente
                const waitInterval = setInterval(() => {
                    if (remainingWaitTime <= 0) {
                        clearInterval(waitInterval);
                        waitMessage.style.display = 'none'; // Cache le message d'attente
                        startMatchTimer();
                        return;
                    }
                    remainingWaitTime--;
                    updateTimer(remainingWaitTime);
                }, 1000);
            }

            if (remainingWaitTime > 0) {
                updateTimer(remainingWaitTime);
                startWaitTimer();
            } else {
                updateTimer(remainingMatchTime);
                startMatchTimer();
            }

            // Actualiser la page toutes les secondes
            setInterval(() => {
                window.location.reload();
            }, 1500);

            // Laravel Echo pour la mise à jour en temps réel
            window.Echo.private(`match.${matchId}`)
                .listen('ScoreUpdated', (event) => {
                    console.log('ScoreUpdated event received:', event);
                    if (event.match.id === matchId) {
                        document.getElementById('score-team-1').textContent = event.match.score_team_1;
                        document.getElementById('score-team-2').textContent = event.match.score_team_2;
                    }
                });
        });
    </script>
</body>
</html>