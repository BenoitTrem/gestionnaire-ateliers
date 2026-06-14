<?php
/**
 * @author Benoit Tremblay.
 */

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AtelierRequest extends FormRequest
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
        $rules = [
            'nom' => 'required|string|max:30|min:1',
            'animateurs' => 'nullable|array',
            'animateurs.*' => 'exists:animateurs,id',
            'description' => 'required|string|max:150|min:1',
            'campus_id' => 'nullable|numeric|exists:campuses,id',
            'local_id' => 'nullable|numeric|exists:locals,id',
            'url_inscription' => 'nullable|url',
            'heure_debut' => 'required|date_format:H:i',
            'duree_minutes' => 'required|integer|min:30|max:300',
            'date' => [
                'required',
                'date',
                'after:' . Carbon::parse(config('app.edition.debut_semaine'))->subDay(),
                'before:' . Carbon::parse(config('app.edition.fin_semaine'))->addDay(),
            ],
        ];

        if ($this->input('heure_debut') === '23:00') {
            $rules['duree_minutes'] = 'required|integer|min:30|max:60';
        }
        if ($this->input('heure_debut') === '22:00') {
            $rules['duree_minutes'] = 'required|integer|min:30|max:120';
        }

        return $rules;
    }
}
