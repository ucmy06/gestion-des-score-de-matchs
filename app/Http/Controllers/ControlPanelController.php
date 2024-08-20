<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Team;

class ControlPanelController extends Controller
{
    public function index()
    {
        // Récupérer toutes les équipes et les matchs pour l'administration
        $teams = Team::all();
        $matches = Matches::with('team1', 'team2')->get();

        return view('control-panel.index', compact('teams', 'matches'));
    }

    // Ajoute d'autres méthodes pour gérer les actions du panneau de contrôle
}
