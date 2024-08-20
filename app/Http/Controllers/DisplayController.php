<?php

namespace App\Http\Controllers;

use App\Events\ScoreUpdated;
use Illuminate\Http\Request;
use App\Models\Matches;

class DisplayController extends Controller
{
    public function index()
    {
        // Récupère tous les matchs pour l'affichage général
        $matches = Matches::with('team1', 'team2')->get();

        return view('display.index', compact('matches'));
    }

    public function launch($id)
    {
        $match = Matches::with('team1', 'team2')->find($id);

        if (!$match) {
            abort(404, 'Match not found');
        }

        // Stocker l'heure de début du match dans la session
        session()->put('startTime', now());

        // Stocker l'ID du match dans la session
        session()->put('currentMatchId', $id);

        // Rediriger vers la page d'affichage du match
        return redirect()->route('display.show');
    }

    public function show()
    {
        $matchId = session('currentMatchId');
        if (!$matchId) {
            return redirect()->route('display.index')->with('error', 'Aucun match sélectionné.');
        }

        $match = Matches::with('team1', 'team2')->find($matchId);

        if (!$match) {
            return redirect()->route('display.index')->with('error', 'Match non trouvé.');
        }

        // Récupérer l'heure de début stockée dans la session
        $startTime = session('startTime');
        $matchDuration = $match->duration;

        // Passer les données du match à la vue
        return view('display.index', compact('match', 'startTime', 'matchDuration'));
    }

    public function updateScore(Request $request, $id)
    {
        $match = Matches::find($id);

        if (!$match) {
            return redirect()->route('display.index')->with('error', 'Match non trouvé.');
        }

        // Mise à jour des scores (supposons que les scores soient envoyés dans la requête)
        $match->score_team_1 = $request->input('score_team_1');
        $match->score_team_2 = $request->input('score_team_2');
        $match->save();

        // Déclencher l'événement ScoreUpdated
        event(new ScoreUpdated($match));

        // Rediriger ou retourner une réponse
        return redirect()->route('display.show');
    }
}
