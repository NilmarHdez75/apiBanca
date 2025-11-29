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

            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'sexo' => 'required|in:M,F',
            'fecha_nacimiento' => 'required|date|before:today',
            'nacionalidad' => 'required|string|max:50',
            'curp' => 'nullable|string|size:18|unique:socios,curp',
            'rfc' => 'nullable|string|max:13|unique:socios,rfc',
            'ine' => 'nullable|string|max:20|unique:socios,ine',

            'telefono' => 'nullable|string|max:15',

            'sucursal_id' => 'required|exists:sucursales,id',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Debe especificarse un usuario asociado.',
            'user_id.exists' => 'El usuario asociado no existe.',
            'sexo.in' => 'El valor de sexo debe ser M o F.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'curp.size' => 'La CURP debe tener 18 caracteres.',
            'curp.unique' => 'Esta CURP ya está registrada.',
            'rfc.unique' => 'Este RFC ya está registrado.',
            'ine.unique' => 'Este número de INE ya está registrado.',
            'sucursal_id.exists' => 'La sucursal seleccionada no existe.',
        ];
    }
}
