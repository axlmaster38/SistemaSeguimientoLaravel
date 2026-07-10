<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDescargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['nullable', 'string'],
            'proceso_disciplinario_id' => [
                'required',
                'integer',
                Rule::exists('procesos_disciplinarios', 'id')->where('estado_registro', 'Activo'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'proceso_disciplinario_id.exists' => 'Solo se pueden asociar procesos activos.',
        ];
    }
}
