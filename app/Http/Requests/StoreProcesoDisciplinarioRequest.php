<?php

namespace App\Http\Requests;

use App\Models\ProcesoDisciplinario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProcesoDisciplinarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'denuncia_id' => [
                'required',
                'integer',
                Rule::exists('denuncias', 'id')->where('estado_registro', 'Activo'),
            ],
            'fecha_apertura' => ['nullable', 'date'],
            'estado_proceso' => ['required', 'string', 'max:50'],
            'proceso_antiguo' => ['nullable', 'boolean'],
            'tipologias_faltas' => ['required', 'array', 'min:1'],
            'tipologias_faltas.*' => ['integer', 'exists:tipologias_faltas,id'],
            'articulos' => ['required', 'array', 'min:1'],
            'articulos.*' => ['integer', 'exists:articulos,id'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if (! $this->filled('denuncia_id')) {
                return;
            }

            $existeProcesoActivo = ProcesoDisciplinario::where('denuncia_id', $this->integer('denuncia_id'))
                ->where('estado_registro', 'Activo')
                ->exists();

            if ($existeProcesoActivo) {
                $validator->errors()->add('denuncia_id', 'La denuncia ya tiene un proceso disciplinario activo.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'denuncia_id.exists' => 'Solo se pueden crear procesos para denuncias activas.',
        ];
    }
}
