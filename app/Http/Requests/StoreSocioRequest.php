<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocioRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'numero_socio' => 'required|string|unique:socios,numero_socio|max:20',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'genero' => 'required|in:M,F',
            'fecha_nacimiento' => 'required|date',
            'curp' => 'required|string|max:18|unique:socios,curp',
            'rfc' => 'required|string|max:13|unique:socios,rfc',
            'ine' => 'required|string|max:20|unique:socios,ine',
            'telefono' => 'nullable|string|max:20',
        ];
    }
}
