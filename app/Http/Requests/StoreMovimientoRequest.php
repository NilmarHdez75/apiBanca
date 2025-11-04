<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoRequest extends FormRequest
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
            'cuenta_id' => 'required|exists:cuentas,id',
            'tipo_movimiento' => 'required|in:Depósito,Retiro',
            'monto' => 'required|numeric|min:1',
            'descripcion' => 'nullable|string|max:255',
            'fecha' => 'required|date',
        ];
    }
}
