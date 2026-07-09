<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateZonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $zonaId = $this->route('zona')?->id;

        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('zonas', 'nombre')->ignore($zonaId),
            ],
        ];
    }
}
