<?php
/**
 * @author Benoit Tremblay.
 *
 *
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'numeroLocal' => 'required|string|max:10|min:1|unique:locals,numeroLocal',
            'campus_id' => 'required|integer',
            'capacite' => 'required|integer|min:1|max:200',
            'disponibilite' => 'boolean',
        ];
    }
}
