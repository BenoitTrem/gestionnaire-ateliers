<?php

/**
 * @author John Sebastian Zuleta Franco  , Benoit Tremblay
 */

use App\Http\Controllers\AnimateurController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Local;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/erreur', function () {
    return view('errors.erreurPersonnalise');
})->name('erreur.page');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/profile/overview', [ProfileController::class,'index'])->name('profile.index');

    Route::get('/filtrer-nom', [ProfileController::class, 'filtrerParNom'])->name('profile.filtrerNom');
    Route::get('/filtrer-role', [ProfileController::class, 'filtrerParRole'])->name('profile.filtrerRole');

    Route::resource('ateliers', AtelierController::class)->except('index');

    Route::put('/profile/update-role', [ProfileController::class, 'updateRole'])->name('profile.updateRole');

    Route::resource('locaux', LocalController::class)->parameters([
        'locaux' => 'local'
    ]);
    Route::resource('animateurs', AnimateurController::class)->except('index');
    Route::resource('locaux', LocalController::class)->except('index');
    Route::resource('horaires', HoraireController::class)->except('index');

    Route::get('/locals-by-campus/{campus}', [LocalController::class, 'getLocauxParCampus'])->name('locals.byCampus');

    Route::get('/fetch-ateliers', [AtelierController::class, 'fetchAteliers']);
    Route::get('/fetch-animateur-info', [AnimateurController::class, 'fetchAnimateurInfo']);

    Route::get('/animateurs/{animateur}/atelier_ajout/{atelier}', [AnimateurController::class, 'atelier_ajout']);
    Route::get('/animateurs/{animateur}/', [AnimateurController::class, 'show']);
});


Route::resource('animateurs', AnimateurController::class)->only(['index']);
Route::resource('locaux', LocalController::class)->only(['index']);
Route::resource('ateliers', AtelierController::class)->only(['index']);
Route::resource('horaires', HoraireController::class)->only(['index']);

require __DIR__.'/auth.php';
