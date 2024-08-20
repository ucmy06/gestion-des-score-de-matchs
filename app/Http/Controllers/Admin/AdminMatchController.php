<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;

class AdminMatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $matches = Matches::with([ 'creator','team1', 'team2'])->get(); // Inclure 'creator' si nécessaire
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
            'score_team_1' => 'required|integer', // Validation mise à jour pour accepter les scores négatifs
            'score_team_2' => 'required|integer', // Validation mise à jour pour accepter les scores négatifs
            'match_date' => 'nullable|date',
            // 'status' => 'required|string' // Validation ajoutée pour le status

        ]);

        Matches::create([
            'team_1_id' => $request->input('team_1_id'),
            'team_2_id' => $request->input('team_2_id'),
            'score_team_1' => $request->input('score_team_1'),
            'score_team_2' => $request->input('score_team_2'),
            'match_date' => $request->input('match_date') ? \Carbon\Carbon::parse($request->input('match_date')) : now(),
            'created_by' => auth()->id(),
            // 'status' => $request->input('status'), // Ajoutez la gestion du status

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

    public function update(Request $request, string $id)
    {
        $request->validate([
            'team_1_id' => 'required|exists:teams,id',
            'team_2_id' => 'required|exists:teams,id',
            'score_team_1' => 'required|integer',
            'score_team_2' => 'required|integer',
            'match_date' => 'nullable|date',
            // 'status' => 'required|string|max:255', // Validation du statut
        ]);
    
        $match = Matches::findOrFail($id);
        $match->update([
            'team_1_id' => $request->input('team_1_id'),
            'team_2_id' => $request->input('team_2_id'),
            'score_team_1' => $request->input('score_team_1'),
            'score_team_2' => $request->input('score_team_2'),
            'match_date' => $request->input('match_date') ? \Carbon\Carbon::parse($request->input('match_date')) : now(),
            // 'status' => $request->input('status'), // Mise à jour du statut
        ]);
    
        return redirect()->route('admin.matches.index')->with('success', 'Match mis à jour avec succès.');
    }
    

    public function destroy(string $id)
    {
        $match = Matches::findOrFail($id);
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Match supprimé avec succès.');
    }
}
