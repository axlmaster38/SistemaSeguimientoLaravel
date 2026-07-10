<?php

namespace App\Http\Requests;

use App\Models\Descargo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePruebaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50'],
            'tipo_prueba' => ['required', 'string', 'max:50'],
            'descripcion' => ['nullable', 'string'],
            'procedencia' => ['required', 'string', 'max:50'],
            'archivo' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'proceso_disciplinario_id' => [
                'nullable',
                'integer',
                Rule::exists('procesos_disciplinarios', 'id')->where('estado_registro', 'Activo'),
            ],
            'descargo_id' => [
                'nullable',
                'integer',
                Rule::exists('descargos', 'id')->where('estado_registro', 'Activo'),
            ],
            'apelacion_id' => ['nullable', 'integer', 'exists:apelaciones,id'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $procesoId = $this->input('proceso_disciplinario_id');
            $descargoId = $this->input('descargo_id');
            $apelacionId = $this->input('apelacion_id');

            if (! $procesoId && ! $descargoId && ! $apelacionId) {
                $validator->errors()->add('proceso_disciplinario_id', 'La prueba debe asociarse al menos a un proceso o descargo.');
                return;
            }

            if ($procesoId && $descargoId) {
                $descargo = Descargo::find($descargoId);

                if ($descargo && (int) $descargo->proceso_disciplinario_id !== (int) $procesoId) {
                    $validator->errors()->add('descargo_id', 'El descargo seleccionado no pertenece al proceso indicado.');
                }
            }
        });
    }
}
