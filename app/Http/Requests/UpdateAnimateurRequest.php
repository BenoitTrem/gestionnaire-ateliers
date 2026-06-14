<?php



/**
 * @author John Sebastian Zuleta Franco
 */


namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateAnimateurRequest extends AnimateurRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Hérite des règles définies dans AnimateurRequest.
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|alpha|string|max:15',
            'prenom' => 'required|alpha|string|max:15',
            'biographie' => 'nullable|string',
            'expertise' => 'nullable|string',
            'email' => [
                'required',
                'email',
               Rule::unique('animateurs')->ignore($this->route('animateur')),
            ],
        ];
    }

    /**
     * Permet de appliquer la transformation automatiquement
     * @author John Sebastian Zuleta Franco
     * prepareForValidation source : https://laravel.com/docs/12.x/validation
     *ucfirst pour mettre premiere lettre en majuscule
     */

    protected function prepareForValidation(): void
    {
        $this->merge([
            'prenom' => ucfirst(strtolower($this->input('prenom'))),
            'nom' => ucfirst(strtolower($this->input('nom'))),
        ]);
    }
}
