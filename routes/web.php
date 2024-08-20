<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Employee\EmployeeTeamController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMatchController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AdminEmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Employee\EmployeeMatchController;
use App\Http\Controllers\Admin\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Ici, vous pouvez enregistrer les routes web pour votre application. Ces
| routes sont chargées par le RouteServiceProvider et toutes seront
| assignées au groupe de middleware "web". Faites quelque chose de génial !
|
*/

// Route d'accueil
Route::get('/', [WelcomeController::class, 'index']);

// Routes de vérification d'email
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('verification.resend');

// Authentification Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes pour les administrateurs
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', AdminController::class);

    // Routes pour la gestion des employés
    Route::resource('employees', AdminEmployeeController::class);

    // Routes pour les matchs admin
    Route::resource('matches', AdminMatchController::class);

    // Routes pour les équipes
    Route::resource('teams', TeamController::class);
});

// Routes pour les employés
Route::middleware(['auth', 'checkRole:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::resource('teams', EmployeeTeamController::class);
    Route::resource('matches', EmployeeMatchController::class);
    Route::post('/matches/launch/{id}', function ($id) {
        session(['currentMatchId' => $id]);
        return redirect()->route('display.match', $id);
    })->name('employee.matches.launch');
    Route::put('/employee/matches/{match}', [EmployeeMatchController::class, 'update'])->name('employee.matches.update');

    Route::get('/employee/matches/{match}/edit-logo', [EmployeeMatchController::class, 'editLogo'])->name('employee.matches.editLogo');
    Route::put('/employee/matches/{match}/update-logo', [EmployeeMatchController::class, 'updateLogo'])->name('employee.matches.updateLogo');


});

// Route pour la page d'accueil après connexion
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Route pour le panneau d'affichage

Route::get('/display', [DisplayController::class, 'index'])->name('display.index');
Route::get('/display/{id}/launch', [DisplayController::class, 'launch'])->name('display.match');
Route::get('/display/show', [DisplayController::class, 'show'])->name('display.show');

// Route pour le panneau de contrôle
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/control-panel', [ControlPanelController::class, 'index'])->name('control-panel.index');
});

// Routes pour la gestion du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('password.update');
});
