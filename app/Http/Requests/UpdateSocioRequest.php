<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocioRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'sucursal_id' => 'sometimes|exists:sucursales,id',
            'apellido_paterno' => 'sometimes|string|max:100',
            'apellido_materno' => 'sometimes|string|max:100',
            'telefono' => 'sometimes|string|max:20',
            'is_active' => 'boolean',
        ];
    }
}
