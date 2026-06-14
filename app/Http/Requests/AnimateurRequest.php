<?php


/**
 * @author John Sebastian Zuleta Franco
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AnimateurRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'prenom' => 'required|alpha|string|max:15',
            'nom' => 'required|alpha|string|max:15',
            'biographie' => 'nullable|string|max:150',
            'expertise' => 'nullable|string|max:150',
            'email' => [
                'required',
                'email',
                'max:40',
                Rule::unique('animateurs', 'email'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'prenom' => ucfirst(strtolower($this->input('prenom'))),
            'nom' => ucfirst(strtolower($this->input('nom'))),
        ]);
    }

}
