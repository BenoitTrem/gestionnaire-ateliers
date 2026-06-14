<?php
/**
 * @author Benoit Tremblay
 * @author John Sebastian Zuleta Franco (autorisations)
 */
namespace App\Http\Controllers;

use App\Models\Atelier;
use App\Models\Campus;
use App\Models\Local;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocalRequest;
use App\Http\Requests\UpdateLocalRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LocalController extends Controller
{
    /**
     * Affiche une liste des locaux, triés par disponibilité.
     *
     * Cette méthode récupère les locaux en les triant par disponibilité et campus.
     *
     * @return View La vue affichant les locaux.
     */
    public function index(): View|RedirectResponse
    {
        Gate::authorize('viewAny', Local::class);
        try{

            $query = Local::query();

            if (request('campus_id')) {
                $query->where('campus_id', request('campus_id'));
            }

            if (!is_null(request('disponibilite'))) {
                $query->where('disponibilite', request('disponibilite'));
            }

            $locaux = $query
                ->orderBy('disponibilite', 'desc')
                ->orderBy('capacite', 'desc')
                ->paginate(10)
                ->withQueryString();

            $liste_campus = Campus::all();

            return view('locaux.local', [
                'locaux' => $locaux,
                'liste_campus' => $liste_campus,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }




    /**
     * Affiche le formulaire de création d'un nouveau local.
     *
     * @return \Illuminate\View\View La vue du formulaire de création de local.
     */
    public function create(): View|RedirectResponse
    {
        Gate::authorize('create', Local::class);
        try{

            $campuses = Campus::all();
            return view('locaux.creer_local', [
                    'locaux' => Local::orderBy('capacite', 'asc')->get(),
                ],compact('campuses'));
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }

    /**
     * Enregistre un nouveau local dans la base de données.
     *
     * @param LocalRequest $request La requête contenant les données validées du nouveau local.
     * @return RedirectResponse Redirection vers l’index des locaux avec un message de succès.
     */
    public function store(LocalRequest $request): RedirectResponse
    {
        Gate::authorize('create', Local::class);
        try{

            $local = new Local();
            $local->numeroLocal = $request->numeroLocal;
            $local->campus_id = $request->campus_id;
            $local->capacite = $request->capacite;
            $local->disponibilite = $request->has('disponibilite') ? 1 : 0;

            $local->save();

            return redirect()->route('locaux.index')->with([
                'local_creer' => true,
                'numero_local' => $local->numeroLocal,
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ajout du local.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Local $local)
    {
        //
    }

    /**
     * Affiche le formulaire pour la modification d’un local spécifique.
     *
     * @param Local $local Le local à modifier.
     * @return View La vue du formulaire de modification d'un local.
     */
    public function edit(Local $local): View|RedirectResponse
    {
        Gate::authorize('update', $local);
        try{


            return view('locaux.modifier_local', [
                'local' => $local,
                'campuses' => Campus::all(),
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de l\'ouverture de la page.');
        }
    }

    /**
     * Met à jour un local existant dans la base de données.
     *
     * @param UpdateLocalRequest $request La requête contenant les données validées à mettre à jour.
     * @param Local $local Le local à modifier.
     * @return RedirectResponse Redirection vers l’index des locaux avec un message de succès.
     */
    public function update(UpdateLocalRequest $request, Local $local): RedirectResponse
    {
        Gate::authorize('update', $local);
        try{

            $local->update([
                'numeroLocal' => $request->numeroLocal,
                'campus_id' => $request->campus_id,
                'capacite' => $request->capacite,
                'disponibilite' =>  $request->has('disponibilite') ? 1 : 0
            ]);

            return redirect()->route('locaux.index')->with([
                'local_modifier' => true,
                'numero_local' => $local->numeroLocal
            ]);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message', 'Une erreur est survenue lors de la modification du local.');
        }
    }

    /**
     * Supprime un local de la base de données.
     *
     * Elle empêche la suppression si le local est actuellement lié à un atelier.
     * Si le local est utilisé, elle redirige avec un message d’erreur.
     *
     * @param Local $local Le local à supprimer.
     * @return RedirectResponse Redirection vers l’index des locaux avec un message de succès.
     */
    public function destroy(Local $local): RedirectResponse
    {
        Gate::authorize('delete', $local);
        try{

            $local->supprimer();

            session()->flash('local_supprime', 'Le local a été supprimé avec succès!');

            return redirect()->route('locaux.index')->with('success', 'Local supprimé avec succès.');
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors de la suppression du local.');
        }
    }


    /**
     * Filtre les locaux par campus lorsqu'on crée un nouvel atelier.
     *
     * Affiche les locaux filtrer pas le choix de campus que l'utilisateur va avoir choisi.
     *
     * @param Campus $campusId Le id du campus.
     * @return JsonResponse les locaux.
     */
    public function getLocauxParCampus($campusId): JsonResponse|RedirectResponse
    {
        Gate::authorize('viewAny', Atelier::class);
        try{
            $locaux = Local::where('campus_id', $campusId)->where('disponibilite', 1)->get();

            return response()->json($locaux);
        } catch (Exception) {
            return redirect()->route('erreur.page')->with('erreur_message','Une erreur est survenue lors du filtrage du campus.');
        }
    }

}
