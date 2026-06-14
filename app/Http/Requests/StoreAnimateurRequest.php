<?php



/**
 * @author John Sebastian Zuleta Franco
 */
namespace App\Http\Requests;

class StoreAnimateurRequest extends AnimateurRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Autorise la requête (ou utilise un contrôle plus précis)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Hérite automatiquement des règles définies dans AnimateurRequest.
     */
}
