<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session('rol_usuario') === 'Administrador';
    }

    public function rules(): array
    {
        $usuarioId = $this->route('usuario')?->id;

        return [
            'usuario' => [
                'required',
                'string',
                'max:30',
                Rule::unique('usuarios', 'usuario')->ignore($usuarioId),
            ],
            'nombre' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:254'],
            'contrasena' => ['nullable', 'string', 'min:8', 'confirmed'],
            'rol' => ['required', Rule::in(['Administrador', 'Operador'])],
            'estado' => ['required', Rule::in(['Activo', 'Inactivo'])],
        ];
    }
}
