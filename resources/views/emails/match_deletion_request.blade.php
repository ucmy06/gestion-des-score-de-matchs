<!-- resources/views/emails/match_deletion_request.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Demande de Suppression de Match</title>
</head>
<body>
    <p>Bonjour,</p>

    <p>Un employé a demandé la suppression du match avec les détails suivants :</p>
    <p><strong>ID :</strong> {{ $match->id }}</p>
    <p><strong>Équipe 1 :</strong> {{ $match->team1 ? $match->team1->name : 'N/A' }}</p>
    <p><strong>Équipe 2 :</strong> {{ $match->team2 ? $match->team2->name : 'N/A' }}</p>
    <p><strong>Score Équipe 1 :</strong> {{ $match->score_team_1 }}</p>
    <p><strong>Score Équipe 2 :</strong> {{ $match->score_team_2 }}</p>

    <p>Demandé par : {{ $user->name }} ({{ $user->email }})</p>

    <p><a href="{{ route('admin.matches.destroy', $match->id) }}" style="background-color: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Confirmer la suppression</a></p>

    <p>Merci,</p>
    <p>Votre application de gestion de matchs</p>
</body>
</html>
