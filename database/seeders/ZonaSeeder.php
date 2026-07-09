<?php

namespace Database\Seeders;

use App\Models\Zona;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = [
            [
                        'nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'nombre' => 'Zona Caribe',
                    ],
            [
                        'nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'nombre' => 'Zona Centro Sur',
                    ],
            [
                        'nombre' => 'Zona CentroOriente',
                    ],
            [
                        'nombre' => 'Zona Occidente',
                    ],
            [
                        'nombre' => 'Zona Sur',
                    ],
            [
                        'nombre' => 'SECCIONAL UNIÓN EUROPEA',
                    ]
        ];

        foreach ($zonas as $zona) {
            Zona::updateOrCreate(
                ['nombre' => $zona['nombre']],
                ['estado_registro' => 'Activo']
            );
        }
    }
}
