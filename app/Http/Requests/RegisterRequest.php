<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'alpha', 'string', 'max:30'],
            'prenom' => ['required', 'alpha', 'string', 'max:30'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class),
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
            'nom' => ucfirst(strtolower($this->input('nom'))),
            'prenom' => ucfirst(strtolower($this->input('prenom'))),
        ]);
    }

}
