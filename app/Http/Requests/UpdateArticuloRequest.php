<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticuloRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(session('rol_usuario'), ['Administrador', 'Operador'], true);
    }

    public function rules(): array
    {
        $articuloId = $this->route('articulo')?->id;

        return [
            'no_articulo' => [
                'required',
                'string',
                'max:12',
                Rule::unique('articulos', 'no_articulo')
                    ->ignore($articuloId)
                    ->where(fn ($query) => $query->where('normatividad_id', $this->input('normatividad_id'))),
            ],
            'descripcion' => ['nullable', 'string'],
            'capitulo' => ['required', 'string', 'max:30'],
            'literal' => ['nullable', 'string'],
            'normatividad_id' => ['required', 'exists:normatividades,id'],
        ];
    }
}
