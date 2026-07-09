<?php

namespace Database\Seeders;

use App\Models\Centro;
use App\Models\Zona;
use Illuminate\Database\Seeder;

class CentroSeeder extends Seeder
{
    public function run(): void
    {
        $centros = [
            [
                        'centro' => 'Acacias',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'Aguachica',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Arbeláez',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Barrancabermeja',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Boavita',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Bucaramanga',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Cali',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'Cartagena',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Chipaque',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Chiquinquirá',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Corozal',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Cubará',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Cúcuta',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Curumaní',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Dosquebradas - Eje cafero',
                        'zona_nombre' => 'Zona Occidente',
                    ],
            [
                        'centro' => 'Duitama',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'EL Banco',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Facatativa',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Florencia',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Fusagasugá',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Gachetá',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Garagoa',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Girardot',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Ibagué',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'José Acevedo y Gomez',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'La Dorada',
                        'zona_nombre' => 'Zona Occidente',
                    ],
            [
                        'centro' => 'La Guajira',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'La Plata',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'LA TEBAIDA',
                        'zona_nombre' => 'Zona Occidente',
                    ],
            [
                        'centro' => 'Leticia',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'libano',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Málaga',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Mariquita',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Medellin',
                        'zona_nombre' => 'Zona Occidente',
                    ],
            [
                        'centro' => 'Neiva',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Ocaña',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Palmira',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'Pamplona',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Pasto',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'PATIA (EL BORDO)',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'Pitalito',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Plato',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Popayán',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'Puerto Asis',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Puerto carreño',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'Puerto Colombia',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Puerto Inírida',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'Puerto Leguizamo',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Quibdó',
                        'zona_nombre' => 'Zona Occidente',
                    ],
            [
                        'centro' => 'Quiron - Cumaral',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'Rioacha',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Sahagún',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'San José de Guaviare',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'San Vicente del Caguan',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Santa Marta',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Santander de quilichao',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'SECCIONAL UNIÓN EUROPEA',
                        'zona_nombre' => 'SECCIONAL UNIÓN EUROPEA',
                    ],
            [
                        'centro' => 'Soacha',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ],
            [
                        'centro' => 'Soata',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Socha',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Sogamoso',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Tumaco',
                        'zona_nombre' => 'Zona Centro Sur',
                    ],
            [
                        'centro' => 'Tunja',
                        'zona_nombre' => 'Zona Centro Boyacá',
                    ],
            [
                        'centro' => 'Turbo',
                        'zona_nombre' => 'Zona Occidente',
                    ],
            [
                        'centro' => 'Valle del Guamuez',
                        'zona_nombre' => 'Zona Sur',
                    ],
            [
                        'centro' => 'Valledupar',
                        'zona_nombre' => 'Zona Caribe',
                    ],
            [
                        'centro' => 'Velez',
                        'zona_nombre' => 'Zona CentroOriente',
                    ],
            [
                        'centro' => 'Yopal',
                        'zona_nombre' => 'Zona Amazonía Orinoquía',
                    ],
            [
                        'centro' => 'Zipaquirá',
                        'zona_nombre' => 'Zona Centro Bogotá Cundinamarca',
                    ]
        ];

        foreach ($centros as $centro) {
            $zonaId = Zona::where('nombre', $centro['zona_nombre'])->value('id');

            if (! $zonaId) {
                continue;
            }

            Centro::updateOrCreate(
                [
                    'centro' => $centro['centro'],
                    'zona_id' => $zonaId,
                ],
                ['estado_registro' => 'Activo']
            );
        }
    }
}
