<?php

namespace Database\Seeders;

use App\Models\PeriodoAcademico;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class PeriodoAcademicoSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = Usuario::where('usuario', 'admin')->value('id');

        if (! $adminId) {
            $this->call(UsuarioSeeder::class);
            $adminId = Usuario::where('usuario', 'admin')->value('id');
        }

        $periodos = [
            [
                        'codigo' => 2031,
                        'periodo' => '16-1',
                        'anio' => 2025,
                        'fecha_inicio' => '2025-02-03 00:00:00',
                        'fecha_fin' => '2025-06-08 00:00:00',
                        'fecha_registro' => '2025-07-25 18:01:10',
                        'fecha_actualiza' => '2025-07-30 09:09:12',
                    ],
            [
                        'codigo' => 2032,
                        'periodo' => '16-2',
                        'anio' => 2025,
                        'fecha_inicio' => '2025-04-01 00:00:00',
                        'fecha_fin' => '2025-08-04 00:00:00',
                        'fecha_registro' => '2025-07-25 18:01:55',
                        'fecha_actualiza' => '2025-07-30 09:09:41',
                    ],
            [
                        'codigo' => 2033,
                        'periodo' => '8-3',
                        'anio' => 2025,
                        'fecha_inicio' => '2025-06-09 00:00:00',
                        'fecha_fin' => '2025-08-17 00:00:00',
                        'fecha_registro' => '2025-07-30 09:10:52',
                        'fecha_actualiza' => '2025-07-30 09:10:52',
                    ],
            [
                        'codigo' => 2034,
                        'periodo' => '16-4',
                        'anio' => 2025,
                        'fecha_inicio' => '2025-08-19 00:00:00',
                        'fecha_fin' => '2025-12-22 00:00:00',
                        'fecha_registro' => '2025-07-30 09:11:23',
                        'fecha_actualiza' => '2025-07-30 09:11:23',
                    ],
            [
                        'codigo' => 2035,
                        'periodo' => '16-5',
                        'anio' => 2025,
                        'fecha_inicio' => '2025-10-14 00:00:00',
                        'fecha_fin' => '2026-02-24 00:00:00',
                        'fecha_registro' => '2025-07-30 09:12:34',
                        'fecha_actualiza' => '2025-07-30 09:12:34',
                    ],
            [
                        'codigo' => 3001,
                        'periodo' => '16-1',
                        'anio' => 2026,
                        'fecha_inicio' => '2026-02-03 00:00:00',
                        'fecha_fin' => '2026-06-03 00:00:00',
                        'fecha_registro' => '2025-07-31 10:22:15',
                        'fecha_actualiza' => '2025-07-31 10:22:15',
                    ],
            [
                        'codigo' => 3002,
                        'periodo' => '16-2',
                        'anio' => 2026,
                        'fecha_inicio' => '2026-04-01 00:00:00',
                        'fecha_fin' => '2026-08-04 00:00:00',
                        'fecha_registro' => '2025-07-31 10:23:15',
                        'fecha_actualiza' => '2025-07-31 10:23:15',
                    ],
            [
                        'codigo' => 3003,
                        'periodo' => '8-3',
                        'anio' => 2026,
                        'fecha_inicio' => '2026-06-09 00:00:00',
                        'fecha_fin' => '2026-08-17 00:00:00',
                        'fecha_registro' => '2025-07-31 10:24:54',
                        'fecha_actualiza' => '2025-07-31 10:24:54',
                    ],
            [
                        'codigo' => 3004,
                        'periodo' => '16-4',
                        'anio' => 2026,
                        'fecha_inicio' => '2026-08-19 00:00:00',
                        'fecha_fin' => '2026-12-22 00:00:00',
                        'fecha_registro' => '2025-07-31 10:25:50',
                        'fecha_actualiza' => '2025-07-31 10:26:51',
                    ],
            [
                        'codigo' => 3005,
                        'periodo' => '16-5',
                        'anio' => 2026,
                        'fecha_inicio' => '2026-10-14 00:00:00',
                        'fecha_fin' => '2027-02-24 00:00:00',
                        'fecha_registro' => '2025-07-31 10:26:42',
                        'fecha_actualiza' => '2025-07-31 10:26:42',
                    ]
        ];

        foreach ($periodos as $periodo) {
            PeriodoAcademico::updateOrCreate(
                [
                    'periodo' => $periodo['periodo'],
                    'anio' => $periodo['anio'],
                ],
                [
                    'codigo' => $periodo['codigo'],
                    'fecha_inicio' => $periodo['fecha_inicio'],
                    'fecha_fin' => $periodo['fecha_fin'],
                    'usuario_registra_id' => $adminId,
                    'usuario_actualiza_id' => null,
                    'fecha_registro' => $periodo['fecha_registro'],
                    'fecha_actualiza' => $periodo['fecha_actualiza'],
                ]
            );
        }
    }
}
