<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Retourne la vue du tableau de bord pour l'administrateur
        return view('admin.dashboard');
    }

    // Autres méthodes pour la gestion des utilisateurs
}
