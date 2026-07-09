<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $estudianteId = $this->route('estudiante')?->id;

        return [
            'codigo_estu' => [
                'required',
                'string',
                'max:20',
                Rule::unique('estudiantes', 'codigo_estu')->ignore($estudianteId),
            ],
            'nombre' => ['required', 'string', 'max:30'],
            'apellido' => ['required', 'string', 'max:30'],
            'estado_academico' => ['required', 'string', 'max:30'],
            'email_institucional' => ['required', 'email', 'max:254'],
            'email_personal' => ['required', 'email', 'max:254'],
            'email_alternativo' => ['nullable', 'email', 'max:254'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'direccion' => ['nullable', 'string', 'max:200'],
            'centro_id' => ['required', 'integer', 'exists:centros,id'],
            'programa_id' => ['required', 'integer', 'exists:programas,id'],
        ];
    }
}
