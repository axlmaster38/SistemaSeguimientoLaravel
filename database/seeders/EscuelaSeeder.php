<?php

namespace Database\Seeders;

use App\Models\Escuela;
use Illuminate\Database\Seeder;

class EscuelaSeeder extends Seeder
{
    public function run(): void
    {
        $escuelas = [
            [
                        'sigla' => 'ECACEN',
                        'nombre' => 'Escuela de Ciencias Administrativas, Contables, Económicas y de Negocios',
                    ],
            [
                        'sigla' => 'ECAPMA',
                        'nombre' => 'Escuela de Ciencias Agrícolas, Pecuarias y del Medio Ambiente',
                    ],
            [
                        'sigla' => 'ECBTI',
                        'nombre' => 'Escuela de Ciencias Básicas, Tecnología e Ingeniería',
                    ],
            [
                        'sigla' => 'ECEDU',
                        'nombre' => 'Escuela de Ciencias de la Educación',
                    ],
            [
                        'sigla' => 'ECISA',
                        'nombre' => 'Escuela de Ciencias de la Salud',
                    ],
            [
                        'sigla' => 'ECJP',
                        'nombre' => 'Escuela de Ciencias Jurídicas y Políticas',
                    ],
            [
                        'sigla' => 'ECSAH',
                        'nombre' => 'Escuela de Ciencias Sociales, Artes y Humanidades',
                    ],
            [
                        'sigla' => 'INVIL',
                        'nombre' => 'Instituto Virtual de Lenguas',
                    ],
            [
                        'sigla' => 'SINEC',
                        'nombre' => 'Sistema Nacional de Educación Continua',
                    ],
            [
                        'sigla' => 'SINEP',
                        'nombre' => 'Sistema Nacional de Educación Permanente',
                    ]
        ];

        foreach ($escuelas as $escuela) {
            Escuela::updateOrCreate(
                ['sigla' => $escuela['sigla']],
                [
                    'nombre' => $escuela['nombre'],
                    'estado_registro' => 'Activo',
                ]
            );
        }
    }
}
