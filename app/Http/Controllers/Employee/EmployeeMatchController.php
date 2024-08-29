<?php

namespace App\Http\Controllers\Employee;
use Illuminate\Support\Facades\Log; // Assurez-vous d'inclure cette ligne en haut de votre contrôleur
use App\Models\Team;
use App\Models\Matches;
use App\Events\ScoreUpdated; // Assurez-vous que cette ligne est présente pour importer l'événement
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeMatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:employee');
    }

    public function index()
    {
        $matches = auth()->user()->role === 'admin'
            ? Matches::with(['creator', 'team1', 'team2'])->get()
            : Matches::with(['team1', 'team2'])
                    ->where('created_by', auth()->id())
                    ->get();

        // Si vous avez un ID de match en session, récupérez-le
        $currentMatchId = session('currentMatchId');

        return view('employee.matches.index', compact('matches', 'currentMatchId'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('employee.matches.create', compact('teams'));
    }

    public function show(string $id)
    {
        $match = Matches::with('creator')->findOrFail($id);
        $logs = $match->logs()->get();
        return view('employee.matches.show', compact('match', 'logs'));
    }

    public function edit(Matches $match)
    {
        $teams = Team::all();
        return view('employee.matches.edit', compact('match', 'teams'));
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

                    // Ajouter des logs pour déboguer
        Log::info('Updating match', [
            'match_id' => $match->id,
            'input_data' => $request->all()
        ]);

            // Mise à jour du match
            $match->update([
                'score_team_1' => $request->input('score_team_1'),
                'score_team_2' => $request->input('score_team_2'),
                'duration' => $request->input('match_duration'),
                'end_time' => $request->input('end_time'),
                'wait_time' => $request->input('wait_time'),

            ]);
    
            // Création d'un log
            \App\Models\Log::create([
                'user_id' => auth()->id(),
                'match_id' => $match->id,
                'action' => 'Mise à jour des scores et de l\'heure de fin',
                'details' => 'Score Équipe 1: ' . $request->input('score_team_1') . ', Score Équipe 2: ' . $request->input('score_team_2') . ', Heure de fin: ' . $request->input('end_time'),
            ]);
    
            // Déclenchement de l'événement
            event(new ScoreUpdated($match));
    
            // Redirection avec message de succès
            return redirect()->route('employee.matches.index')->with('success', 'Match mis à jour avec succès.');
    
        
        } catch (\Exception $e) {
            Log::error('Error updating match: ' . $e->getMessage());

            return redirect()->route('employee.matches.index')->with('error', 'Erreur lors de la mise à jour du match.');
        }
    }
    

    public function store(Request $request)
{
    $request->validate([
        'team_1_id' => 'required|exists:teams,id',
        'team_2_id' => 'required|exists:teams,id',
        'score_team_1' => 'required|integer',
        'score_team_2' => 'required|integer',
        'match_duration' => 'nullable|integer',
        'end_time' => 'nullable|date',
        'wait_time' => 'nullable|integer',  // Modifier ici
    ]);

    try {
        $match = Matches::create([
            'team_1_id' => $request->team_1_id,
            'team_2_id' => $request->team_2_id,
            'score_team_1' => $request->score_team_1,
            'score_team_2' => $request->score_team_2,
            'created_by' => auth()->id(),
            'duration' => $request->match_duration,
            'end_time' => $request->end_time,
            'wait_time' => $request->wait_time,  // Modifier ici
        ]);
        Log::info('Match créé:', [
            'user_id' => auth()->id(),
            'match_id' => $match->id,
            'action' => 'Match créé: Équipe 1 - ' . $match->score_team_1 . ', Équipe 2 - ' . $match->score_team_2,
        ]);

        return redirect()->route('employee.matches.index')->with('success', 'Match créé avec succès.');
    } catch (\Exception $e) {
        Log::error('Error creating match: ' . $e->getMessage());

        return redirect()->route('employee.matches.index')->with('error', 'Erreur lors de la création du match.');
    }
}


    public function launch($id)
    {
        $match = Matches::find($id);

        if (!$match) {
            return redirect()->route('employee.matches.index')->with('error', 'Match non trouvé');
        }

        return redirect()->route('employee.matches.edit', $id)->with([
            'success' => 'Match lancé avec succès. Vous pouvez maintenant éditer les scores.',
            'currentMatchId' => $id
        ]);
    }

    public function editLogo($matchId)
    {
        $match = Matches::findOrFail($matchId);
        return view('employee.matches.editLogo', compact('match'));
    }

    public function startTimer(Request $request, Matches $match)
{
    $duration = $request->input('duration');
    $match->update([
        'start_time' => now(),
        'duration' => $duration
    ]);

    return response()->json(['success' => true]);
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

        return redirect()->route('employee.matches.index')->with('success', 'Match mis à jour avec succès');
    }

    public function fullscreen($id)
{
    $match = Matches::findOrFail($id);

    // Retourne la vue pour afficher le match en plein écran
    return view('matches.fullscreen', compact('match'));
}

public function startTimerWithDelay(Request $request, Matches $match)
{
    // Valider le temps d'attente pour s'assurer qu'il s'agit d'un entier positif
    $request->validate([
        'wait_time' => 'nullable|integer|min:0',
    ]);

    try {
        // Calculer le temps d'attente en secondes
        $waitTime = $match->wait_time ?? 0;

        // Démarrer le chronomètre après le temps d'attente
        if ($waitTime > 0) {
            sleep($waitTime);
        }

        // Lancer le chronomètre après l'attente
        $match->start_timer = now();
        $match->save();

        return response()->json(['status' => 'Timer started after waiting ' . $waitTime . ' seconds']);
    } catch (\Exception $e) {
        Log::error('Error starting timer with delay: ' . $e->getMessage());

        return response()->json(['error' => 'Failed to start the timer.'], 500);
    }
}


public function showWaitTime($matchId)
{
    // Retrieve the match by its ID
    $match = Matches::findOrFail($matchId);
    
    // Calculate the remaining wait time
    $remainingWaitTime = $match->wait_time; // Adjust this as needed

    // Return the view with the remaining wait time and match
    return view('display.wait_time', [
        'remainingWaitTime' => $remainingWaitTime,
        'match' => $match
    ]);
}
public function getScores($id)
{
    $match = Matches::with('team1', 'team2')->findOrFail($id);
    
    return response()->json([
        'score_team_1' => $match->score_team_1,
        'score_team_2' => $match->score_team_2,
    ]);
}


}