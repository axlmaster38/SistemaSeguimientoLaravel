<?php

namespace App\Http\Requests;

use App\Models\Sancion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string'],
            'tipo_notificacion' => ['required', 'string', 'max:50', Rule::in(['Sancion', 'Proceso'])],
            'instancia' => ['required', 'string', 'max:50', Rule::in(['Primera Notificación', 'Segunda Notificación'])],
            'archivo' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'proceso_disciplinario_id' => [
                'nullable',
                'integer',
                Rule::exists('procesos_disciplinarios', 'id')->where('estado_registro', 'Activo'),
            ],
            'sancion_id' => [
                'nullable',
                'integer',
                Rule::exists('sanciones', 'id')->where('estado_registro', 'Activo'),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $tipo = $this->input('tipo_notificacion');
            $procesoId = $this->input('proceso_disciplinario_id');
            $sancionId = $this->input('sancion_id');

            if ($tipo === 'Proceso' && ! $procesoId) {
                $validator->errors()->add('proceso_disciplinario_id', 'Debe seleccionar un proceso para una notificación de proceso.');
            }

            if ($tipo === 'Sancion' && ! $sancionId) {
                $validator->errors()->add('sancion_id', 'Debe seleccionar una sanción para una notificación de sanción.');
            }

            if ($procesoId && $sancionId) {
                $sancion = Sancion::with('decision')->find($sancionId);

                if ($sancion && (int) $sancion->decision?->proceso_disciplinario_id !== (int) $procesoId) {
                    $validator->errors()->add('sancion_id', 'La sanción seleccionada no pertenece al proceso indicado.');
                }
            }
        });
    }
}
