<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temps d'Attente</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        #wait_timer {
            font-size: 3rem;
        }
    </style>
</head>
<body>
    <div id="wait_timer" data-wait-time="{{ $remainingWaitTime }}"></div>
    @isset($waitTime)
    data-wait-time="{{ $waitTime }}"
    @endisset
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const waitTimer = document.getElementById('wait_timer');
            let waitTime = parseInt(waitTimer.getAttribute('data-wait-time'), 10);
            
            function updateTimer(remaining) {
                let minutes = Math.floor(remaining / 60);
                let seconds = remaining % 60;

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                waitTimer.textContent = `${minutes}:${seconds}`;
            }

            updateTimer(waitTime);

            const timerInterval = setInterval(() => {
                if (waitTime <= 0) {
                    clearInterval(timerInterval);
                    window.location.href = "{{ route('match.display', ['id' => $match->id]) }}";
                    return;
                }
                waitTime--;
                updateTimer(waitTime);
            }, 1000);
        });
    </script>
</body>
</html>
