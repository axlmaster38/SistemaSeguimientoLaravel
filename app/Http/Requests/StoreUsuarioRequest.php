<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session('rol_usuario') === 'Administrador';
    }

    public function rules(): array
    {
        return [
            'usuario' => ['required', 'string', 'max:30', 'unique:usuarios,usuario'],
            'nombre' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:254'],
            'contrasena' => ['required', 'string', 'min:8', 'confirmed'],
            'rol' => ['required', Rule::in(['Administrador', 'Operador'])],
            'estado' => ['required', Rule::in(['Activo', 'Inactivo'])],
        ];
    }
}
