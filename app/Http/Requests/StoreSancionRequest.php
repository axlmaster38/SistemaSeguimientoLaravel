<?php

namespace App\Http\Requests;

use App\Models\PeriodoAcademico;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSancionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'tipo_sancion' => ['required', 'string', 'max:40'],
            'descripcion' => ['nullable', 'string'],
            'numero_periodos' => ['required', 'integer', 'min:1'],
            'periodo_inicial_sancion_id' => ['nullable', 'integer', 'exists:periodos_academicos,id'],
            'periodo_final_sancion_id' => ['nullable', 'integer', 'exists:periodos_academicos,id'],
            'estado_sancion' => ['required', 'string', 'max:20'],
            'decision_id' => [
                'required',
                'integer',
                Rule::exists('decisiones', 'id')->where('estado_registro', 'Activo'),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $inicio = $this->input('periodo_inicial_sancion_id');
            $fin = $this->input('periodo_final_sancion_id');

            if (! $inicio || ! $fin) {
                return;
            }

            $periodos = PeriodoAcademico::orderBy('anio')->orderBy('periodo')->pluck('id')->values();
            $posInicio = $periodos->search((int) $inicio);
            $posFin = $periodos->search((int) $fin);

            if ($posInicio === false || $posFin === false || $posFin < $posInicio) {
                $validator->errors()->add('periodo_final_sancion_id', 'El periodo final debe ser igual o posterior al periodo inicial.');
                return;
            }

            $cantidad = $posFin - $posInicio + 1;
            if ((int) $this->input('numero_periodos') !== $cantidad) {
                $validator->errors()->add('numero_periodos', "El numero de periodos debe ser {$cantidad} para el intervalo seleccionado.");
            }
        });
    }
}
