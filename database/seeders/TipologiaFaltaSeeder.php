<?php

namespace Database\Seeders;

use App\Models\TipologiaFalta;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class TipologiaFaltaSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = Usuario::where('usuario', 'admin')->value('id');

        if (! $adminId) {
            $this->call(UsuarioSeeder::class);
            $adminId = Usuario::where('usuario', 'admin')->value('id');
        }

        $tipologias = [
            [
                        'nombre' => 'Falsificación en documento',
                        'descripcion' => 'El estudiante presenta documentos falsos',
                        'fecha_registro' => '2025-07-25 19:35:49',
                        'fecha_actualiza' => '2025-07-30 08:44:22',
                    ],
            [
                        'nombre' => 'Conexiones sospechosas',
                        'descripcion' => 'el estudiante presenta conexiones sospechosas debido a inconsistencias con la IP',
                        'fecha_registro' => '2025-07-30 08:45:15',
                        'fecha_actualiza' => '2025-07-30 08:45:15',
                    ],
            [
                        'nombre' => 'Ofrecimiento de ayudas académicas',
                        'descripcion' => 'El estudiante ofrece o pertenece a ayudas académicas donde realizan trabajos a cambio de dinero',
                        'fecha_registro' => '2025-07-30 08:46:21',
                        'fecha_actualiza' => '2025-07-30 08:46:21',
                    ],
            [
                        'nombre' => 'Recibe ayudas académicas',
                        'descripcion' => 'El estudiante presenta trabajos presentados por otras personas u organizaciones dedicadas a realizar trabajos a cambio de dinero',
                        'fecha_registro' => '2025-07-30 08:47:13',
                        'fecha_actualiza' => '2025-07-30 08:47:13',
                    ],
            [
                        'nombre' => 'geolocalización con IP recurrentes y multitud de estudiantes',
                        'descripcion' => 'Informe de geolocalización con IP recurrentes y multitud de estudiantes',
                        'fecha_registro' => '2025-07-30 08:48:30',
                        'fecha_actualiza' => '2025-07-30 08:48:30',
                    ],
            [
                        'nombre' => 'Actos discriminatorios',
                        'descripcion' => 'Actos discriminatorios en contra de alguno de los integrantes de la comunidad universitaria, por razones de etnia, opinión, sexo, culto o condición social',
                        'fecha_registro' => '2025-07-30 08:48:55',
                        'fecha_actualiza' => '2025-07-30 08:48:55',
                    ],
            [
                        'nombre' => 'Fraude en actividades evaluativas o académicas',
                        'descripcion' => 'El estudiante presenta actividades académicas fraudulentas',
                        'fecha_registro' => '2025-07-30 08:49:37',
                        'fecha_actualiza' => '2025-07-30 08:49:37',
                    ]
        ];

        foreach ($tipologias as $tipologia) {
            TipologiaFalta::updateOrCreate(
                ['nombre' => $tipologia['nombre']],
                [
                    'descripcion' => $tipologia['descripcion'],
                    'usuario_registra_id' => $adminId,
                    'usuario_actualiza_id' => null,
                    'fecha_registro' => $tipologia['fecha_registro'],
                    'fecha_actualiza' => $tipologia['fecha_actualiza'],
                ]
            );
        }
    }
}
