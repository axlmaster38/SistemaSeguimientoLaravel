<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDenunciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estudiante_id' => ['required', 'integer', 'exists:estudiantes,id'],
            'estado_denuncia' => ['required', 'string', 'max:50'],
            'fecha_creacion' => ['nullable', 'date'],
            'descripcion' => ['nullable', 'string'],
            'justificacion' => ['nullable', 'string'],
            'denuncia_antigua' => ['nullable', 'boolean'],
        ];
    }
}
