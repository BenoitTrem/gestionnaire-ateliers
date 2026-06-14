<?php
/**
 * @author Benoit Tremblay.
 */

namespace App\Http\Controllers;

use App\Models\Atelier;
use App\Models\Campus;
use App\Models\Horaire;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHoraireRequest;
use App\Http\Requests\UpdateHoraireRequest;
use App\Models\Local;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class HoraireController extends Controller
{
    /**
     * Affiche la liste des ressources pour la vue horaire.
     *
     * Cette méthode récupère tous les campus et les ateliers associés avec leurs relations,
     * formate les données des ateliers (heure, durée, animateur, etc.) pour les intégrer dans le FullCalendar.
     *
     * @return View La vue contenant le calendrier avec toutes les informations d'un atelier.
     *
     *  J'ai utilisé ChatGPT pour cette fonction, ma question était:
     *                      - Comment afficher ma page Horaire avec les erreurs que la page me donnait à cause du JavaScript pour le FullCalendar.
     */
    public function index(): View|RedirectResponse
    {
        Gate::authorize('viewAny', Horaire::class);
        try{
            $liste_campus = Campus::all();

            Atelier::with('campus', 'local')->get()
            ->map(function ($atelier) {
                $heureDebut = Carbon::parse($atelier->heure_debut);

                return [
                    'title' => $atelier->nom,
                    'start' => $atelier->date . 'T' . $heureDebut->format('H:i'),
                    'end' => $atelier->date . 'T' . $heureDebut->addMinutes($atelier->duree_minutes)->format('H:i'),
                    'description' => $atelier->description,
                    'campus' => optional($atelier->campus)->nom,
                    'local' => optional($atelier->local)->numeroLocal,
                    'capacite' => optional($atelier->local)->capacite,
                    'color' => '#e53e3e',
                    'extendedProps' => [
                        'animateur' => $atelier->animateurs,
                        'duree' => $atelier->duree_minutes,
                        'campus' => optional($atelier->campus)->nom,
                        'local' => optional($atelier->local)->numeroLocal,
                        'capacite' => optional($atelier->local)->capacite,
                        'url' => $atelier->url_inscription,
                    ],
                ];
            });
            return view('horaire.horaire',[
                'liste_campus' => $liste_campus,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHoraireRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Horaire $horaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horaire $horaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHoraireRequest $request, Horaire $horaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horaire $horaire)
    {
        //
    }
}
