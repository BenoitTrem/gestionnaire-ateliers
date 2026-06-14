<?php
/**
 * @author Benoit Tremblay.
 * @author John Sebastian Zuleta Franco (autorisations)
 */
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;




class ProfileController extends Controller
{

    /**
     * Affiche la liste des users
     * @author John Sebastian Zuleta Franco
     *
     * @return View
     */
    public function index(Request $request): View
    {

        Gate::authorize('viewAny', User::class);

        $query = User::query();

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


        // Organisateur voit users + admins + organisateurs
        if (Gate::check('organisateur') && !Gate::check('estAdmin')) {
            $users = $query->orderBy('nom', 'asc')->whereIn('role', [1,2,3])->paginate(10);
        }
        // Admin voit uniquement les users
        elseif (Gate::check('estAdmin')) {
            $users = $query->orderBy('nom', 'asc')->where('role', 3)->paginate(10);
        }

        return view('profile.index', [
            'users' => $users,
        ]);
    }




    /**
     * Affiche la liste des users
     * @author John Sebastian Zuleta Franco
     *
     * @return View
     */

    //tri par rôle
    public function filtrerParRole() : View
    {
        Gate::authorize('viewAny', User::class);

        // Récupérer l'ordre (ascendant ou descendant)
        $order = request()->get('order', 'asc');  // Par défaut 'asc'

        // Organisateur voit users + admins + organisateurs
        if (Gate::check('organisateur') && !Gate::check('estAdmin')) {
            $users = User::orderBy('role', $order)
            ->whereIn('role', [1, 2, 3])
                ->paginate(10);
        }
        // Admin voit uniquement les users
        elseif (Gate::check('estAdmin')) {
            $users = User::orderBy('role', $order)
            ->where('role', 3)
                ->paginate(10);
        }

        return view('profile.index', [
            'users' => $users,
        ]);
    }



    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Permet de modifier le role
     * @author John Sebastian Zuleta Franco
     */

    public function updateRole(Request $request)
    {
        Gate::authorize('updateRole', User::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|integer|in:3,2', // admin ou user uniquement
        ]);

        $user = User::findOrFail($request->user_id);

        // Interdiction de modifier un organisateur
        if ($user->role === 1) {
            return redirect()->back()->withErrors(['message' => 'Impossible de modifier un organisateur.']);
        }

        // ADMIN : peut seulement promouvoir un utilisateur (3 → 2)
        if (Gate::check('estAdmin') && !Gate::check('organisateur')) {
            if ($user->role !== 1 || $request->role != 2) {
                return redirect()->back()->withErrors(['message' => 'Vous ne pouvez que promouvoir un utilisateur.']);
            }
        }

        if (Gate::check('organisateur')) {
            if (!in_array($user->role, [3, 2]) || !in_array($request->role, [2, 3])) {
                return redirect()->back()->withErrors(['message' => 'Modification non autorisée.']);
            }
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with([
            'user_modifier' => true,
            'nom_utilisateur' => $user->prenom . ' ' . $user->nom,
        ]);
    }



}
