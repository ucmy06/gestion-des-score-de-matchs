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
                <div id="timer_display" data-duration="{{ $matchDuration }}" data-start-time="{{ $startTime }}"></div>
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
            // Récupération de l'ID du match avec PHP
            var matchId = <?php echo json_encode($match->id); ?>;
            console.log('Match ID:', matchId);

            const timerDisplay = document.getElementById('timer_display');
            const matchDuration = parseInt(timerDisplay.getAttribute('data-duration'), 10);
            const startTime = new Date(timerDisplay.getAttribute('data-start-time')).getTime();
            let now = new Date().getTime();
            const elapsedTime = Math.floor((now - startTime) / 1000);
            let remainingTime = Math.max(matchDuration - elapsedTime, 0);

            function updateTimer(remaining) {
                let minutes = Math.floor(remaining / 60);
                let seconds = remaining % 60;

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.textContent = `${minutes}:${seconds}`;
            }

            updateTimer(remainingTime);

            const timerInterval = setInterval(() => {
                if (remainingTime <= 0) {
                    clearInterval(timerInterval);
                    return;
                }
                remainingTime--;
                updateTimer(remainingTime);
            }, 1000);

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
