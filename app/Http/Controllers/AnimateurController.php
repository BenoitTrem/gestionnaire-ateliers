<?php


/**
 * @author John Sebastian Zuleta Franco
 */

namespace App\Http\Controllers;

use App\Http\Requests\AnimateurRequest;
use App\Models\Animateur;
use Illuminate\Support\Facades\Gate;
use App\Models\Atelier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAnimateurRequest;
use App\Http\Requests\UpdateAnimateurRequest;

class AnimateurController extends Controller
{
    /**
     * Affiche la liste des animateurs.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Animateur::class);


        $query = Animateur::query();

        /**
         * @author John Sebastian Zuleta Franco
         * J'ai fait deux verifications pour nom et prenom ainsi que toute en lower
         * pour rendre la recherche insensible à la casse.
         * Utiliser un paramètre lié pour éviter les injections SQL.
         */
        if ($request->filled('nom')) {
            $query->where(function($query) use ($request) {
                $query->whereRaw('LOWER(nom) LIKE ?', ['%' . strtolower($request->nom) . '%'])
                    ->orWhereRaw('LOWER(prenom) LIKE ?', ['%' . strtolower($request->nom) . '%']);
            });
        }



        $animateurs = $query->orderBy('nom', 'asc')
                            ->orderBy('prenom', 'asc')
                            ->paginate(10, ['*'], 'index');

        return view('animateurs.index', [
            'animateurs' => $animateurs,
        ]);
    }

    /**
     * Affiche le formulaire de création d'un animateur.
     *
     * @return View
     */
    public function create(): View
    {
        Gate::authorize('create', Animateur::class);

        return view('animateurs.create', [
            'animateur' => new Animateur(),
        ]);
    }

    /**
     * Stocke un nouvel animateur dans la base de données.
     *et retourne vers la vue index
     * @param StoreAnimateurRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnimateurRequest $request): RedirectResponse
    {

        Gate::authorize('create', Animateur::class);

        $animateur = new Animateur();
        $animateur->prenom = $request->prenom;
        $animateur->nom = $request->nom;
        $animateur->biographie = $request->biographie;
        $animateur->expertise = $request->expertise;
        $animateur->email = $request->email;

        $animateur->save();

        return redirect()->route('animateurs.index')->with([
            'animateur_creer' => true,
            'nom_animateur' => $animateur->nom,
        ]);
    }

    /**
     * Affiche les détails d'un animateur.
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        Gate::authorize('viewAny', Animateur::class);
        $animateur = Animateur::with('ateliers')->findOrFail($id);
        return view('animateurs.show', compact('animateur'));
    }

    /**
     * Affiche le formulaire de modification d'un animateur.
     *
     * @param Animateur $animateur
     * @return View
     */
    public function edit(Animateur $animateur): View
    {
        Gate::authorize('update', $animateur);



        return view('animateurs.edit', [
            'animateur' => $animateur,
        ]);
    }

    /**
     * Met à jour un animateur existant et retourne vers la vue index.
     *
     * @param UpdateAnimateurRequest $request
     * @param Animateur $animateur
     * @return RedirectResponse
     */
    public function update(UpdateAnimateurRequest $request, Animateur $animateur): RedirectResponse
    {
        Gate::authorize('update', $animateur);

        $data = $request->validated();

        $animateur->modifier($data);

        return redirect()->route('animateurs.index')->with([
            'animateur_modifier' => true,
            'prenom_animateur' => $animateur->prenom,
            'nom_animateur' => $animateur->nom,
        ]);
    }


    /**
     * Supprime un animateur ainsi que ses conférences associées (ateliers),
     * et retourne vers la vue index avec un message approprié.
     * @param Animateur $animateur
     * @return RedirectResponse
     */
    public function destroy(Animateur $animateur): RedirectResponse
    {
        Gate::authorize('delete', $animateur);

        $nbAteliers = $animateur->ateliers()->count();



        $animateur->delete();

        $message = "Animateur supprimé avec succès.";
        if ($nbAteliers > 0) {
            $message = " L'Animateur est supprimé et ses {$nbAteliers} atelier(s) ont été désassociés.";
        }

        session()->flash('animateur_supprime', $message);

        return redirect()->route('animateurs.index')->with('success', $message);
    }

    /**
     * Ajoute un atelier à un animateur s'il n'est pas déjà lié.
     *
     * @param Animateur $animateur L'animateur à lier à l'atelier.
     * @param Atelier $atelier L'atelier à ajouter à l'animateur.
     * @return RedirectResponse Redirige vers la liste des ateliers avec un message de succès si l'ajout a eu lieu,
     *                          sinon redirige simplement sans message.
     */
    public function atelier_ajout(Animateur $animateur, Atelier $atelier): RedirectResponse
    {
        Gate::authorize('atelier_ajout', [$animateur, $atelier]);

        if (!$animateur->ateliers()->where('atelier_id', $atelier->id)->exists()) {
            $animateur->ateliers()->attach($atelier);
            return redirect()->route('ateliers.index')
                ->with('success', 'Animateur lié à atelier via Url/Route avec succès.')
                ->with([
                    'atelier_ajout_route' => true,
                    'nom_atelier' => $atelier->nom,
                    'nom_animateur' => $animateur->nom
                ]);
        } else {
            return redirect()->route('ateliers.index');
        }
    }



    /**
     * @author Benoit Tremblay
     * Fonction pour récupéré les animateurs pour les afficher dans le calendrier
     */
    public function fetchAnimateurInfo(Request $request)
    {
        $animateurId = $request->input('animateur_id');

        $animateur = Animateur::find($animateurId);

        return response()->json([
            'prenom' => $animateur->prenom,
            'nom' => $animateur->nom,
            'bio' => $animateur->biographie,
            'expertise' => $animateur->expertise,
        ]);

    }

}
