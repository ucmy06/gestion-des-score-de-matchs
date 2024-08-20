<?php

namespace App\Http\Controllers\Employee;

use App\Models\Log;
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
        $request->validate([
            'score_team_1' => 'required|integer',
            'score_team_2' => 'required|integer',
            'match_duration' => 'nullable|integer', // Validation ajoutée pour la durée
            'end_time' => 'nullable|date', // Validation ajoutée pour l'heure de fin
        ]);

        $match->update([
            'score_team_1' => $request->input('score_team_1'),
            'score_team_2' => $request->input('score_team_2'),
            'duration' => $request->input('match_duration'),
            'end_time' => $request->input('end_time'), // Mise à jour de l'heure de fin
        ]);

        // Enregistrez les modifications dans le journal
        Log::create([
            'user_id' => auth()->id(),
            'match_id' => $match->id,
            'action' => 'Mise à jour des scores et de l\'heure de fin',
            'details' => 'Score Équipe 1: ' . $request->input('score_team_1') . ', Score Équipe 2: ' . $request->input('score_team_2') . ', Heure de fin: ' . $request->input('end_time'),
        ]);

        // Diffusez l'événement ScoreUpdated
        event(new ScoreUpdated($match));

        return redirect()->route('employee.matches.index')->with('success', 'Match mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_1_id' => 'required|exists:teams,id',
            'team_2_id' => 'required|exists:teams,id',
            'score_team_1' => 'required|integer',
            'score_team_2' => 'required|integer',
            'match_duration' => 'nullable|integer', // Validation pour la durée du match
            'end_time' => 'nullable|date', // Validation pour l'heure de fin
        ]);

        $match = Matches::create([
            'team_1_id' => $request->team_1_id,
            'team_2_id' => $request->team_2_id,
            'score_team_1' => $request->score_team_1,
            'score_team_2' => $request->score_team_2,
            'created_by' => auth()->id(),
            'duration' => $request->match_duration,
            'end_time' => $request->end_time, // Enregistrement de l'heure de fin
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'match_id' => $match->id,
            'action' => 'Match créé: Équipe 1 - ' . $match->score_team_1 . ', Équipe 2 - ' . $match->score_team_2,
        ]);

        return redirect()->route('employee.matches.index')->with('success', 'Match créé avec succès.');
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
}
