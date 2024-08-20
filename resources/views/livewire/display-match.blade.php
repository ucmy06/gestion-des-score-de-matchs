<div>
    @if($match)
        <div id="match-details">
            <div id="teams-scores">
                <div id="team_1">
                    <h2>{{ $match->team1->name }}</h2>
                    <img src="{{ $match->team1->logo }}" alt="{{ $match->team1->name }}" width="100">
                    <h3>Score Équipe 1</h3>
                    <span id="score_team_1">{{ $match->score_team_1 }}</span>
                </div>
                <div id="team_2">
                    <h2>{{ $match->team2->name }}</h2>
                    <img src="{{ $match->team2->logo }}" alt="{{ $match->team2->name }}" width="100">
                    <h3>Score Équipe 2</h3>
                    <span id="score_team_2">{{ $match->score_team_2 }}</span>
                </div>
            </div>

            <div id="timer">
                <h3>Chronomètre: <span id="countdown">00:00</span></h3>
            </div>
        </div>
    @else
        <p>Aucun match sélectionné.</p>
    @endif
</div>
