<?php



// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home'); // Assurez-vous que 'home.blade.php' existe dans 'resources/views'
    }
}
