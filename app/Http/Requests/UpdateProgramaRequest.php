<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $programaId = $this->route('programa')?->id;

        return [
            'codigo_pro' => [
                'required',
                'string',
                'max:12',
                Rule::unique('programas', 'codigo_pro')->ignore($programaId),
            ],
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'escuela_id' => ['required', 'integer', 'exists:escuelas,id'],
        ];
    }
}
