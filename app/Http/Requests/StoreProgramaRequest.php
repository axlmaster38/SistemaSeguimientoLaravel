<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_pro' => ['required', 'string', 'max:12', 'unique:programas,codigo_pro'],
            'nombre' => ['required', 'string', 'max:30', 'unique:programas,nombre'],
            'escuela_id' => ['required', 'integer', 'exists:escuelas,id'],
        ];
    }
}
