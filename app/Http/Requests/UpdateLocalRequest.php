<?php


/**
 * @author John Sebastian Zuleta franco
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocalRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'numeroLocal' => [
                'required',
                'string',
                'max:10',
                Rule::unique('locals')->ignore($this->route('local')),
            ],
            'campus_id' => 'required|integer',
            'capacite' => 'required|integer|min:1',
            'disponibilite' => 'boolean',
        ];
    }
}

