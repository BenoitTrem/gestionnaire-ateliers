<?php
/**
 * @author Benoit Tremblay
 * @author John Sebastian Zuleta Franco  (Autorisations)
 * /
 */

namespace App\Http\Controllers;

use App\Http\Requests\AtelierRequest;
//use App\Mail\InscriptionsMail;
use App\Mail\AtelierCourriel;
use App\Mail\DemoCourriel;
use App\Models\Animateur;
use App\Models\Atelier;
use App\Models\Campus;
use App\Models\Local;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;


class AtelierController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        //$this->authorizeResource(Atelier::class, 'atelier');
    }

    /**
     * Affiche une liste des ressources (ateliers) disponibles.
     * si un atelier est créé, un Email est envoyé à l'utilisateur avec l'atelier en paramètre.
     * @return View La vue affichant la liste des ateliers,
     */
    public function index(Request $request): view|RedirectResponse
    {
        Gate::authorize('viewAny', Atelier::class);
        try{

            $user = Auth::user();

            if ($user) {
                $inscriptions = $user->ateliers ? $user->ateliers->sortBy('date') : collect();
                $attente = $user->ateliers_attente ? $user->ateliers_attente : collect();
            } else {
                $inscriptions = collect();
                $attente = collect();
            }

            // si l'atelier est défini dans la session (indiquant qu'un nouvel atelier a été créé),
            // un Email est envoyé pour confirmé le nouvel atelier créé.

            // Je n'est pas mis l'enovie du Email dans la fonction store parce que sa cause parfois un bug où
            // la redirection ne fonctionnait pas.
            if (session('atelier_id')) {
                $atelier = Atelier::find(session('atelier_id'));

                if ($atelier) {
                    try{
                        Mail::to(Auth::user())->send(new AtelierCourriel($atelier));
                        session()->forget('atelier_id');
                    } catch (Exception) {
                        session()->flash('erreur_courriel', 'Erreur lors de l\'envoie du courriel');
                    }
                }
            }

            $query = Atelier::query();

            /**
             * @author John Sebastian Zuleta Franco
             * Nom en lower
             * pour rendre la recherche insensible à la casse.
             * Utiliser un paramètre lié pour éviter les injections SQL.
             */
            if ($request->filled('nom')) {
                $query->whereRaw('LOWER(nom) LIKE ?', ['%' . strtolower($request->nom) . '%']);
            }


            if ($request->filled('date')) {
                $query->whereDate('date', $request->date);
            }

            if ($request->filled('campus_id')) {
                $query->where('campus_id', $request->campus_id);
            }


            $ateliers = $query->orderBy('date', 'asc')
            ->orderBy('nom', 'asc')
            ->paginate(10, ['*'], 'ateliers');


            $campus = Campus::all();;
            $liste_campus = Campus::all();

            return view('ateliers.ateliers', [
                'ateliers' => $ateliers,
                'inscriptions' => $inscriptions,
                'attente' => $attente,
                'liste_campus' => $liste_campus,
                'campuses' => $campus,
                'request' => $request,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }

    /**
     * Affiche le formulaire de création d'un nouvel atelier.
     * @return View La vue du formulaire de création avec les données nécessaires (campus, animateurs, ateliers).
     */
    public function create(Atelier $atelier): View|RedirectResponse
    {
        Gate::authorize('create', Atelier::class);
        try {

            $campuses = Campus::all();
            $animateurs = Animateur::orderBy('nom', 'asc')->get();

            //$locals = Local::where('campus_id', $atelier->campus_id)->get();
            $locals = Local::all();

            return view('ateliers.creer_atelier', [
                'campuses' => $campuses,
                'animateurs' => $animateurs,
                'ateliers' => Atelier::orderBy('nom', 'asc')->get(),
                'locals' => $locals,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }


    /**
     * Enregistre un nouvel atelier dans la base de données avec ('atelier_creer', true).
     * Rend le local utilisé indisponible.
     * @param  AtelierRequest  $request  Les données validées du formulaire de création d'atelier.
     * @return RedirectResponse  Redirige vers la liste des ateliers avec un message de confirmation.
     */
    public function store(AtelierRequest $request): RedirectResponse
    {
        Gate::authorize('create', Atelier::class);
        try{

            try {
                $start = Carbon::parse($request->date . ' ' . $request->heure_debut);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['heure_debut' => 'Heure de début invalide.']);
            }
            $duration = (int) $request->duree_minutes;
            $end = $start->copy()->addMinutes($duration);
            $animateurIds = $request->animateurs ?? [];

            if (!empty($animateurIds)) {
                $conflictingAnimateur = Atelier::where('date', $request->date)
                    ->whereHas('animateurs', function ($query) use ($animateurIds) {
                        $query->whereIn('animateur_id', $animateurIds);
                    })
                    ->get()
                    ->first(function ($atelier) use ($start, $end) {
                        $atelierStart = Carbon::parse($atelier->date . ' ' . $atelier->heure_debut);
                        $atelierEnd = $atelierStart->copy()->addMinutes($atelier->duree_minutes);
                        return $start < $atelierEnd && $end > $atelierStart;
                    });

                if ($conflictingAnimateur) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['animateurs' => 'Un ou plusieurs animateurs sont déjà assignés à un atelier à cette date et heure.']);
                }
            }

            if ($request->filled('local_id')) {
                $conflictingAtelier = Atelier::where('local_id', $request->local_id)
                    ->where('date', $request->date)
                    ->get()
                    ->first(function ($atelier) use ($start, $end) {
                        $atelierStart = Carbon::parse($atelier->date . ' ' . $atelier->heure_debut);
                        $atelierEnd = $atelierStart->copy()->addMinutes($atelier->duree_minutes);
                        return $start < $atelierEnd && $end > $atelierStart;
                    });

                if ($conflictingAtelier) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['local_id' => 'Ce local est déjà réservé pour cette date et heure.']);
                }
            }


            $atelier = new Atelier();
            $atelier->nom = $request->nom;
            $atelier->description = $request->description;
            $atelier->local_id = $request->local_id;
            $atelier->campus_id = $request->campus_id;
            $atelier->url_inscription = $request->url_inscription ?? null;
            $atelier->date = $request->date;
            $atelier->heure_debut = $request->heure_debut;
            $atelier->duree_minutes = $request->duree_minutes;
            $atelier->statut = 'actif';

            $atelier->save();

            try{
                Mail::to(Auth::user())->send(new AtelierCourriel($atelier));
            } catch (Exception) {
                session()->flash('erreur_courriel', 'Erreur lors de l\'envoie du courriel');
            }


            if (!empty($animateurIds)) {
                $atelier->animateurs()->sync($animateurIds);
            }

            return redirect()->route('ateliers.index')
                ->with('success', 'Atelier créé avec succès.')
                ->with([
                'atelier_creer' => true,
                'nom_atelier' => $atelier->nom
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ajout de l\'atelier.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Atelier $atelier): View|RedirectResponse
    {
        Gate::authorize('viewAny', Atelier::class);
        try{
            return view('ateliers.details_atelier', [
                'atelier' => $atelier,
                'inscrits' => $atelier->participantsInscrits()->paginate(10, ['*'], 'inscrits'),
                'attente' => $atelier->participantsAttente()->paginate(10, ['*'], 'attente'),
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de de l\'affichage.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function imprimer(Atelier $atelier): View|RedirectResponse
    {
        Gate::authorize('viewAny', $atelier);
        try{
            return view('models.ateliers.imprimer', [
                'atelier' => $atelier,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\impression de l\'atelier.');
        }
    }

    /**
     * Affiche le formulaire de modification pour un atelier existant.
     * @param  Atelier  $atelier  L'atelier à modifier.
     * @return View  La vue du formulaire de modification avec les données nécessaires.
     */
    public function edit(Atelier $atelier): View|RedirectResponse
    {
        Gate::authorize('update', $atelier);
        try{

            $animateurs = Animateur::orderBy('nom', 'asc')->get();
            $campuses = Campus::all();

            $locals = Local::where('campus_id', $atelier->campus_id)->get();

            return view('ateliers.modifier_atelier', [
                'atelier' => $atelier,
                'animateurs' => $animateurs,
                'campus' => $campuses,
                'locals' => $locals,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }


    /**
     * Met à jour un atelier existant dans la base de données.
     * @param  AtelierRequest  $request  Les données validées du formulaire de modification.
     * @param  Atelier  $atelier  L'atelier à mettre à jour.
     * @return RedirectResponse  Redirige vers la liste des ateliers avec un message de confirmation.
     */
    public function update(AtelierRequest $request, Atelier $atelier): RedirectResponse
    {
        Gate::authorize('update', $atelier);
        try{

            $start = Carbon::parse($request->date . ' ' . $request->heure_debut);
            $duration = (int) $request->duree_minutes;
            $end = $start->copy()->addMinutes($duration);
            $animateurIds = $request->animateurs ?? [];

            $conflictingAnimateur = Atelier::where('date', $request->date)
                ->where('id', '!=', $atelier->id)
                ->whereHas('animateurs', function ($query) use ($animateurIds) {
                    $query->whereIn('animateur_id', $animateurIds);
                })
                ->get()
                ->first(function ($a) use ($start, $end) {
                    $atelierStart = Carbon::parse($a->date . ' ' . $a->heure_debut);
                    $atelierEnd = $atelierStart->copy()->addMinutes($a->duree_minutes);
                    return $start < $atelierEnd && $end > $atelierStart;
                });

            if ($conflictingAnimateur) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['animateurs' => 'Un ou plusieurs animateurs sont déjà assignés à un atelier à cette date et heure.']);
            }



            $conflictingAtelier = Atelier::where('local_id', $request->local_id)
                ->where('date', $request->date)
                ->where('id', '!=', $atelier->id)
                ->get()
                ->first(function ($a) use ($start, $end) {
                    $atelierStart = Carbon::parse($a->date . ' ' . $a->heure_debut);
                    $atelierEnd = $atelierStart->copy()->addMinutes($a->duree_minutes);
                    return $start < $atelierEnd && $end > $atelierStart;
                });
            if ($conflictingAtelier) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['local_id' => 'Ce local est déjà réservé pour cette date et heure.']);
            }

            $atelier->update($request->except('animateurs'));

            if ($request->has('animateurs')) {
                $atelier->animateurs()->sync($request->input('animateurs'));
            }

            return redirect()->route('ateliers.index')
                ->with('success', 'Atelier modifié avec succès.')
                ->with([
                    'atelier_modifier' => true,
                    'nom_atelier' => $atelier->nom
                ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de la modification de l\'atelier.');
        }
    }


    /**
     * Supprime un atelier de la base de données.
     * Rend disponible le local précédemment associé à l'atelier.
     * @param  Atelier  $atelier  L'atelier à supprimer.
     * @return RedirectResponse  Redirige vers la liste des ateliers avec un message de confirmation.
     */
    public function destroy(Atelier $atelier): RedirectResponse
    {
        Gate::authorize('delete', $atelier);
        try {

            if (!$atelier->campus || !$atelier->local) {
                return redirect()->route('ateliers.index')
                    ->with('erreur_message', 'L\'atelier est lié à un campus ou local inexistant.');
            }

            $atelier->supprimer();

            return redirect()->route('ateliers.index')->with('succes', "L'atelier a bien été retiré de la liste.");

        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de la suppression de l\'atelier');
        }
    }



    /**
     * Permet d'inscrire l'utilisateur en cours.
     */
    public function inscription(Atelier $atelier): RedirectResponse
    {
        Gate::allows('utilisateur');
        try{
            $atelier->inscription();

            return back()->with('message', "L'inscription a bien été effectuée.");
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de l\'inscription à l\'atelier');
        }
    }

    /**
     * Permet de désinscrire l'utilisateur en cours.
     */
    public function desinscription(Atelier $atelier, User $user = null): RedirectResponse
    {
        Gate::allows('utilisateur');


        try{
            if (!$user) {
                $user = User::find(Auth::id());
            }
            $atelier->desinscription($user);

            return back()->with('message', "L'inscription a bien été annulée.");
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de la désinscription à l\'atelier');
        }
    }

    /**
     * Permet d'envoyer un courriel à l'utilisateur.
     */
    public function courriel(Atelier $atelier): RedirectResponse
    {
        Gate::allows('utilisateur');
        try{
            $atelier->courriel();

            return back()->with('message', 'Un courriel de confirmation a été envoyé.');
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de l\'envoi de l\'email.');
        }
    }

    public function courrielInscriptions()
    {
        Gate::allows('utilisateur');
        try{
            $user = User::find(Auth::id());
            Mail::to($user)->send(new InscriptionsMail($user->ateliers));

            return back()->with('message', 'Un courriel de confirmation a été envoyé.');
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de l\'envoi de l\'email.');
        }
    }

    public function courrielRappel(Atelier $atelier)
    {
        Gate::authorize('envoieCourriel', $atelier);
        try{
            $atelier->courrielRappel();

            return back()->with('message', 'Le courriel de rappel a été envoyé aux participant.e.s inscrit.e.s.');
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de l\'envoi des l\'emails.');
        }
    }

    /**
     * Récupère la liste des ateliers, filtrée par campus si spécifié,
     * et la retourne au format JSON pour l'affichage dans le calendrier.
     * @param  Request  $request  La requête contenant un identifiant de campus.
     * @return JsonResponse  La liste des ateliers formatée pour l'affichage dans le calendrier (FullCalendar).
     *
     * J'ai utilisé ChatGPT pour une partie de cette fonction, ma question était:
     *                      - Comment récupérer les données d'un atelelier pour l'afficher dans le FullCalendar.
     */
    public function fetchAteliers(Request $request): JsonResponse|RedirectResponse
    {
        Gate::authorize('viewAny', Atelier::class);

        $validated = $request->validate([
            'campus' => ['nullable', 'integer', 'exists:campuses,id'],
        ]);

        try {
            $campus = $validated['campus'] ?? null;

            $campus = $request->campus ?? null;

            $query = Atelier::with('campus', 'local', 'animateurs');

            if ($campus) {
                $query->whereHas('campus', function ($query) use ($campus) {
                    $query->where('id', $campus);
                });
            }

            $ateliers = $query->get()->map(function ($atelier) {

                if (!$atelier->heure_debut || !$atelier->date) {
                    return null;
                }

                try {
                    $heureDebut = Carbon::parse($atelier->heure_debut);
                    $heureFin = $heureDebut->copy()->addMinutes($atelier->duree_minutes);
                    $start = Carbon::parse($atelier->date)->format('Y-m-d') . 'T' . $heureDebut->format('H:i');
                    $end = Carbon::parse($atelier->date)->format('Y-m-d') . 'T' . $heureFin->format('H:i');
                } catch (Exception $e) {
                    return null;
                }

                $animateurs = $atelier->animateurs?->map(function ($animateur) {
                    return [
                        'id' => $animateur->id,
                        'nom_complet' => $animateur->prenom . ' ' . $animateur->nom,
                    ];
                }) ?? collect();

                $_animateur = $atelier->animateurs->first();

                return [
                    'title' => $atelier->nom,
                    'start' => $start,
                    'end' => $end,
                    'description' => $atelier->description,
                    'color' => '#4A5568',
                    'extendedProps' => [
                        'animateurs' => $animateurs,
                        'animateur_id' => $_animateur?->id,
                        'animateur' => $_animateur ? $_animateur->prenom . ' ' . $_animateur->nom : 'N/A',
                        'duree' => $atelier->duree_minutes,
                        'campus' => optional($atelier->campus)->nom ?? 'N/A',
                        'local' => optional($atelier->local)->numeroLocal ?? 'N/A',
                        'capacite' => optional($atelier->local)->capacite ?? 'N/A',
                        'atelier_id' => $atelier->id,
                        'url' => $atelier->url ?? 'N/A',
                    ]
                ];
            })->filter();

            return response()->json($ateliers);

        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de la récupération des ateliers.');
        }
    }


}
