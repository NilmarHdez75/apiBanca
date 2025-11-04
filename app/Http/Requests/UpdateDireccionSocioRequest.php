<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDireccionSocioRequest extends FormRequest
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
            'pais' => 'sometimes|string|max:60',
            'estado' => 'sometimes|string|max:60',
            'municipio' => 'sometimes|string|max:60',
            'colonia' => 'sometimes|string|max:100',
            'calle' => 'sometimes|string|max:100',
            'codigo_postal' => 'sometimes|string|max:10',
            'num_exterior' => 'nullable|string|max:10',
            'num_interior' => 'nullable|string|max:10',
        ];
    }
}
