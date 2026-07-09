<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDenunciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estudiante_id' => [
                'required',
                'integer',
                Rule::exists('estudiantes', 'id')->where('estado_registro', 'Activo'),
            ],
            'estado_denuncia' => ['required', 'string', 'max:50'],
            'fecha_creacion' => ['nullable', 'date'],
            'descripcion' => ['nullable', 'string'],
            'justificacion' => ['nullable', 'string'],
            'denuncia_antigua' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'estudiante_id.exists' => 'Solo se pueden crear denuncias para estudiantes activos.',
        ];
    }
}
