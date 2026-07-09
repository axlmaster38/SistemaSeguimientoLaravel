<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEscuelaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sigla' => ['required', 'string', 'max:8', 'unique:escuelas,sigla'],
            'nombre' => ['required', 'string', 'max:100', 'unique:escuelas,nombre'],
        ];
    }
}
