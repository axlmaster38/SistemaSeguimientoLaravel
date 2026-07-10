<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApelacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'motivo' => ['nullable', 'string'],
            'tipo_apelacion' => [
                'required',
                'string',
                'max:50',
                Rule::in([
                    'Recurso de reposición',
                    'Recurso de reposición en subsidio de apelación',
                    'Apelación',
                ]),
            ],
            'proceso_disciplinario_id' => [
                'required',
                'integer',
                Rule::exists('procesos_disciplinarios', 'id')->where('estado_registro', 'Activo'),
            ],
        ];
    }
}
