<?php

namespace App\Http\Requests;

use App\Models\ProcesoDisciplinario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProcesoDisciplinarioRequest extends FormRequest
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
            $procesoId = $this->route('proceso')?->id;

            if (! $this->filled('denuncia_id')) {
                return;
            }

            $existeProcesoActivo = ProcesoDisciplinario::where('denuncia_id', $this->integer('denuncia_id'))
                ->where('estado_registro', 'Activo')
                ->whereKeyNot($procesoId)
                ->exists();

            if ($existeProcesoActivo) {
                $validator->errors()->add('denuncia_id', 'La denuncia ya tiene otro proceso disciplinario activo.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'denuncia_id.exists' => 'Solo se pueden asociar denuncias activas.',
        ];
    }
}
