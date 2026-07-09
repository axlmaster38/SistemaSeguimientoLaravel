<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCentroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'centro' => ['required', 'string', 'max:30'],
            'zona_id' => ['required', 'integer', 'exists:zonas,id'],
        ];
    }
}
