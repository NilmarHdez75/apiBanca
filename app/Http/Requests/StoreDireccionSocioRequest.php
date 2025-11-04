<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDireccionSocioRequest extends FormRequest
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
            'socio_id' => 'required|exists:socios,id',
            'pais' => 'required|string|max:60',
            'estado' => 'required|string|max:60',
            'municipio' => 'required|string|max:60',
            'colonia' => 'required|string|max:100',
            'calle' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'num_exterior' => 'nullable|string|max:10',
            'num_interior' => 'nullable|string|max:10',
        ];
    }
}
