<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNormatividadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(session('rol_usuario'), ['Administrador', 'Operador'], true);
    }

    public function rules(): array
    {
        return [
            'no_acuerdo' => ['required', 'string', 'max:100', 'unique:normatividades,no_acuerdo'],
            'descripcion' => ['nullable', 'string'],
            'fecha_norma' => ['nullable', 'date'],
        ];
    }
}
