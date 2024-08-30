<?php

namespace App\Http\Controllers\Admin;
use App\Events\ScoreUpdated; // Assurez-vous que cette ligne est présente pour importer l'événement
use Illuminate\Support\Facades\Log; // Assurez-vous d'inclure cette ligne en haut de votre contrôleur
use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;

class AdminMatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $matches = Matches::with(['creator', 'team1', 'team2'])->get(); // Inclure 'creator' si nécessaire
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('admin.matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_1_id' => 'required|exists:teams,id',
            'team_2_id' => 'required|exists:teams,id',
            'score_team_1' => 'required|integer',
            'score_team_2' => 'required|integer',
            'match_date' => 'nullable|date',
            'wait_time' => 'nullable|integer|min:0', // Validation du temps d'attente
        ]);

        Matches::create([
            'team_1_id' => $request->input('team_1_id'),
            'team_2_id' => $request->input('team_2_id'),
            'score_team_1' => $request->input('score_team_1'),
            'score_team_2' => $request->input('score_team_2'),
            'match_date' => $request->input('match_date') ? \Carbon\Carbon::parse($request->input('match_date')) : now(),
            'created_by' => auth()->id(),
            'wait_time' => $request->input('wait_time'), // Ajouter le temps d'attente
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Match créé avec succès.');
    }

    public function show(string $id)
    {
        $match = Matches::with('creator')->findOrFail($id);
        $logs = $match->logs()->get();
        return view('admin.matches.show', compact('match', 'logs'));
    }
    
    public function edit(string $id)
    {
        $match = Matches::findOrFail($id);
        $teams = Team::all();
        return view('admin.matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, Matches $match)
{
    try {
        // Validation des données de la requête
        $request->validate([
            'score_team_1' => 'required|integer',
            'score_team_2' => 'required|integer',
            'match_duration' => 'nullable|integer',
            'end_time' => 'nullable|date',
            'wait_time' => 'nullable|integer',
        ]);

        // Calcul des points changés après la mise à jour
        $originalScoreTeam1 = $match->getOriginal('score_team_1');
        $originalScoreTeam2 = $match->getOriginal('score_team_2');
        $pointsChangedTeam1 = $request->input('score_team_1') - $originalScoreTeam1;
        $pointsChangedTeam2 = $request->input('score_team_2') - $originalScoreTeam2;

        // Mise à jour du match
        $match->update([
            'score_team_1' => $request->input('score_team_1'),
            'score_team_2' => $request->input('score_team_2'),
            'duration' => $request->input('match_duration'),
            'end_time' => $request->input('end_time'),
            'wait_time' => $request->input('wait_time'),
        ]);

        // Création des logs pour les changements
        if ($pointsChangedTeam1 != 0) {
            \App\Models\Log::create([
                'user_id' => auth()->id(),
                'match_id' => $match->id,
                'action' => 'Mise à jour des scores',
                'details' => 'Score Équipe 1 modifié de ' . $originalScoreTeam1 . ' à ' . $request->input('score_team_1'),
                'change_type' => $pointsChangedTeam1 > 0 ? 'increment' : 'decrement',
                'points_changed' => abs($pointsChangedTeam1),
                'changed_at' => now(),
            ]);
        }

        if ($pointsChangedTeam2 != 0) {
            \App\Models\Log::create([
                'user_id' => auth()->id(),
                'match_id' => $match->id,
                'action' => 'Mise à jour des scores',
                'details' => 'Score Équipe 2 modifié de ' . $originalScoreTeam2 . ' à ' . $request->input('score_team_2'),
                'change_type' => $pointsChangedTeam2 > 0 ? 'increment' : 'decrement',
                'points_changed' => abs($pointsChangedTeam2),
                'changed_at' => now(),
            ]);
        }

        // Déclenchement de l'événement
        event(new ScoreUpdated($match));

        // Redirection avec message de succès
        return redirect()->route('admin.matches.index')->with('success', 'Match mis à jour avec succès.');

    } catch (\Exception $e) {
        Log::error('Error updating match: ' . $e->getMessage());

        return redirect()->route('admin.matches.index')->with('error', 'Erreur lors de la mise à jour du match.');
    }
}

    


    public function destroy(string $id)
    {
        $match = Matches::findOrFail($id);
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Match supprimé avec succès.');
    }

    public function startTimer(Request $request, Matches $match)
    {
        $duration = $request->input('duration');
        $waitTime = $request->input('wait_time', 0); // Ajouter une valeur par défaut

        if ($waitTime > 0) {
            sleep($waitTime);
        }

        $match->update([
            'start_time' => now(),
            'duration' => $duration
        ]);

        return response()->json(['success' => true]);
    }

    public function showWaitTime($matchId)
    {
        $match = Matches::findOrFail($matchId);
        $remainingWaitTime = $match->wait_time;

        return view('display.wait_time', [
            'remainingWaitTime' => $remainingWaitTime,
            'match' => $match
        ]);
    }

    public function editLogo($matchId)
    {
        $match = Matches::findOrFail($matchId);
        return view('admin.matches.editLogo', compact('match'));
    }

    public function updateLogo(Request $request, $id)
    {
        $match = Matches::findOrFail($id);

        // Mettre à jour les noms des équipes
        $match->team1->name = $request->input('team1_name');
        $match->team2->name = $request->input('team2_name');

        // Mettre à jour les logos des équipes si de nouveaux fichiers sont téléchargés
        if ($request->hasFile('logo_equipe_gauche')) {
            $path = $request->file('logo_equipe_gauche')->store('logos', 'public');
            $match->team1->logo_path = $path;
        }

        if ($request->hasFile('logo_equipe_droite')) {
            $path = $request->file('logo_equipe_droite')->store('logos', 'public');
            $match->team2->logo_path = $path;
        }

        $match->team1->save();
        $match->team2->save();

        return redirect()->route('admin.matches.index')->with('success', 'Logos et noms des équipes mis à jour avec succès');
    }

    public function fullscreen($id)
    {
        $match = Matches::findOrFail($id);

        // Retourne la vue pour afficher le match en plein écran
        return view('admin.matches.fullscreen', compact('match'));
    }
}
