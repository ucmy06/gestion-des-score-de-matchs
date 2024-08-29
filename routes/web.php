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
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
    Route::prefix('admin')->name('admin.')->group(function () {
    // Routes pour les fonctionnalités des employés
    Route::post('/matches/launch/{id}', [AdminMatchController::class, 'launch'])->name('matches.launch');
    Route::put('/admin/matches/{match}', [AdminMatchController::class, 'update'])->name('admin.matches.update');
    Route::post('/matches', [AdminMatchController::class, 'store'])->name('matches.store');
    Route::post('/matches/{match}/request-delete', [AdminMatchController::class, 'requestDelete'])->name('matches.request_delete');
    Route::get('/matches/{match}/edit-logo', [AdminMatchController::class, 'editLogo'])->name('matches.editLogo');
    Route::put('/matches/{match}/update-logo', [AdminMatchController::class, 'updateLogo'])->name('matches.updateLogo');
    Route::post('/admin/matches/{match}/start_timer', [AdminMatchController::class, 'startTimer'])->name('admin.matches.start_timer');
    Route::get('/matches/{id}/fullscreen', [AdminMatchController::class, 'fullscreen'])->name('matches.fullscreen');
    Route::post('/matches/{match}/start-timer-with-delay', [AdminMatchController::class, 'startTimerWithDelay'])->name('matches.startTimerWithDelay');
    Route::get('/matches/{id}/wait-time', [AdminMatchController::class, 'showWaitTime'])->name('matches.waitTime');
    Route::get('/admin/matches/{id}/scores', [AdminMatchController::class, 'getScores'])->name('admin.matches.scores');
    });
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
    Route::post('/employee/matches', [EmployeeMatchController::class, 'store'])->name('employee.matches.store');
    Route::post('employee/matches/{match}/request-delete', [EmployeeMatchController::class, 'requestDelete'])
    ->name('employee.matches.request_delete');
    Route::get('/employee/matches/{match}/edit-logo', [EmployeeMatchController::class, 'editLogo'])->name('employee.matches.editLogo');
    Route::put('/employee/matches/{match}/update-logo', [EmployeeMatchController::class, 'updateLogo'])->name('employee.matches.updateLogo');
    Route::post('/employee/matches/{match}/start_timer', [EmployeeMatchController::class, 'startTimer'])->name('employee.matches.start_timer');

    Route::get('/employee/matches/{id}/fullscreen', [EmployeeMatchController::class, 'fullscreen'])->name('employee.matches.fullscreen');

    Route::post('/matches/{match}/start-timer-with-delay', [EmployeeMatchController::class, 'startTimerWithDelay'])->name('employee.matches.startTimerWithDelay');
    Route::get('/matches/{id}/wait-time', [EmployeeMatchController::class, 'showWaitTime'])->name('employee.matches.waitTime');
    Route::get('/match/{id}/scores', [EmployeeMatchController::class, 'getScores']);
// routes/web.php



});




// Route pour la page d'accueil après connexion
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// // Route pour le temps d'attente
// Route::get('/wait-time', function () {
//     $remainingWaitTime = 300; // Example: 5 minutes in seconds
//     return view('display.wait_time', compact('remainingWaitTime'));
// })->name('wait_time');


// Route for displaying the match (this should match the route name used in your Blade file)
Route::get('/display/match/{id}', [DisplayController::class, 'show'])->name('match.display');



// Route pour le panneau d'affichage

Route::get('/display', [DisplayController::class, 'index'])->name('display.index');
Route::get('/display/{id}/launch', [DisplayController::class, 'launch'])->name('display.match');
Route::get('/display/show', [DisplayController::class, 'show'])->name('display.show');
Route::get('/wait-time/{matchId}', [EmployeeMatchController::class, 'showWaitTime'])->name('wait_time');

// Route pour le panneau de contrôle
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/control-panel', [ControlPanelController::class, 'index'])->name('control-panel.index');
});

// Routes pour la gestion du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Afficher le formulaire de demande de réinitialisation de mot de passe
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Envoyer l'email avec le lien de réinitialisation de mot de passe
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Afficher le formulaire de réinitialisation de mot de passe
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
// Soumettre le formulaire de réinitialisation de mot de passe
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
    ->name('password.update');
});
