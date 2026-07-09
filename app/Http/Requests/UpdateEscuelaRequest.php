<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEscuelaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $escuelaId = $this->route('escuela')?->id;

        return [
            'sigla' => [
                'required',
                'string',
                'max:8',
                Rule::unique('escuelas', 'sigla')->ignore($escuelaId),
            ],
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('escuelas', 'nombre')->ignore($escuelaId),
            ],
        ];
    }
}
