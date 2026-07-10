<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDecisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50'],
            'tipo_decision' => ['required', 'string', 'max:50'],
            'fecha_sesion' => ['required', 'date'],
            'resultado' => ['nullable', 'string'],
            'clasificacion_falta' => ['nullable', 'string', 'max:50'],
            'observaciones' => ['nullable', 'string'],
            'archivo' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'proceso_disciplinario_id' => [
                'required',
                'integer',
                Rule::exists('procesos_disciplinarios', 'id')->where('estado_registro', 'Activo'),
            ],
        ];
    }
}
