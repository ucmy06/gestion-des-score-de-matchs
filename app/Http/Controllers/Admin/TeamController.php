<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $team = new Team();
        $team->name = $request->name;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $team->logo = $logoPath;
        }

        $team->save();

        return redirect()->route('admin.teams.index')->with('success', 'Équipe ajoutée avec succès.');
    }

    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $team->name = $request->name;

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($team->logo && file_exists(storage_path('app/public/' . $team->logo))) {
                unlink(storage_path('app/public/' . $team->logo));
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $team->logo = $logoPath;
        }

        $team->save();

        return redirect()->route('admin.teams.index')->with('success', 'Équipe mise à jour avec succès.');
    }

    public function destroy(Team $team)
    {
        // Delete logo file if exists
        if ($team->logo && file_exists(storage_path('app/public/' . $team->logo))) {
            unlink(storage_path('app/public/' . $team->logo));
        }

        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Équipe supprimée avec succès.');
    }
}
