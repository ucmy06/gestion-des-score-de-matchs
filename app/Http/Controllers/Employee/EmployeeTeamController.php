<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class EmployeeTeamController extends Controller
{
    // Afficher la liste des équipes
    public function index()
{
    // Fetch the teams from the database
    $teams = Team::all(); // Adjust this query according to your needs

    // Pass the teams variable to the view
    return view('employee.teams.index', compact('teams'));
}


    // Afficher le formulaire pour créer une nouvelle équipe
    public function create()
    {
        return view('employee.teams.create');
    }

    // Stocker une nouvelle équipe dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = new Team();
        $team->name = $request->input('name');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('team_logos', 'public');
            $team->logo = $logoPath;
        }

        $team->save();

        return redirect()->route('employee.teams.index')->with('success', 'Team created successfully.');
    }

    // Afficher les détails d'une équipe
    public function show(Team $team)
    {
        return view('employee.teams.show', compact('team'));
    }

    // Afficher le formulaire pour éditer une équipe
    public function edit(Team $team)
    {
        return view('employee.teams.edit', compact('team'));
    }

    // Mettre à jour les informations d'une équipe
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team->name = $request->input('name');

        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si nécessaire
            if ($team->logo && file_exists(storage_path('app/public/' . $team->logo))) {
                unlink(storage_path('app/public/' . $team->logo));
            }
            $logoPath = $request->file('logo')->store('team_logos', 'public');
            $team->logo = $logoPath;
        }

        $team->save();

        return redirect()->route('employee.teams.index')->with('success', 'Team updated successfully.');
    }

    // Supprimer une équipe
    public function destroy(Team $team)
    {
        // Supprimer le logo si nécessaire
        if ($team->logo && file_exists(storage_path('app/public/' . $team->logo))) {
            unlink(storage_path('app/public/' . $team->logo));
        }

        $team->delete();

        return redirect()->route('employee.teams.index')->with('success', 'Team deleted successfully.');
    }
}