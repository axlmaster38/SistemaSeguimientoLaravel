<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNormatividadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(session('rol_usuario'), ['Administrador', 'Operador'], true);
    }

    public function rules(): array
    {
        $normatividadId = $this->route('normatividad')?->id;

        return [
            'no_acuerdo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('normatividades', 'no_acuerdo')->ignore($normatividadId),
            ],
            'descripcion' => ['nullable', 'string'],
            'fecha_norma' => ['nullable', 'date'],
        ];
    }
}
