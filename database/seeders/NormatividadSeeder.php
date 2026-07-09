<?php

namespace Database\Seeders;

use App\Models\Normatividad;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class NormatividadSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = Usuario::where('usuario', 'admin')->value('id');

        if (! $adminId) {
            $this->call(UsuarioSeeder::class);
            $adminId = Usuario::where('usuario', 'admin')->value('id');
        }

        $normatividades = [
            [
                        'no_acuerdo' => '4354',
                        'descripcion' => 'descripc Normatividad',
                        'fecha_norma' => '2025-10-14 00:00:00',
                        'fecha_registro' => '2025-10-24 10:16:26',
                        'fecha_actualiza' => '2025-10-24 10:16:26',
                    ]
        ];

        foreach ($normatividades as $normatividad) {
            Normatividad::updateOrCreate(
                ['no_acuerdo' => $normatividad['no_acuerdo']],
                [
                    'descripcion' => $normatividad['descripcion'],
                    'fecha_norma' => $normatividad['fecha_norma'],
                    'usuario_registra_id' => $adminId,
                    'usuario_actualiza_id' => null,
                    'fecha_registro' => $normatividad['fecha_registro'],
                    'fecha_actualiza' => $normatividad['fecha_actualiza'],
                ]
            );
        }
    }
}
