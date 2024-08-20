<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        // Retourne la vue du tableau de bord pour l'employé
        return view('employee.dashboard');
    }

    // Autres méthodes pour la gestion des matchs
}
