<?php

namespace Database\Seeders;

use App\Models\Articulo;
use App\Models\Normatividad;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = Usuario::where('usuario', 'admin')->value('id');

        if (! $adminId) {
            $this->call(UsuarioSeeder::class);
            $adminId = Usuario::where('usuario', 'admin')->value('id');
        }

        $articulos = [
            [
                        'no_articulo' => '12',
                        'descripcion' => 'desc ar',
                        'capitulo' => '3',
                        'literal' => 'literal 1.. desc..',
                        'normatividad_no_acuerdo' => '4354',
                        'fecha_registro' => '2025-10-24 10:16:58',
                        'fecha_actualiza' => '2025-10-24 10:16:58',
                    ]
        ];

        foreach ($articulos as $articulo) {
            $normatividadId = Normatividad::where('no_acuerdo', $articulo['normatividad_no_acuerdo'])->value('id');

            if (! $normatividadId) {
                continue;
            }

            Articulo::updateOrCreate(
                [
                    'no_articulo' => $articulo['no_articulo'],
                    'normatividad_id' => $normatividadId,
                ],
                [
                    'descripcion' => $articulo['descripcion'],
                    'capitulo' => $articulo['capitulo'],
                    'literal' => $articulo['literal'],
                    'usuario_registra_id' => $adminId,
                    'usuario_actualiza_id' => null,
                    'fecha_registro' => $articulo['fecha_registro'],
                    'fecha_actualiza' => $articulo['fecha_actualiza'],
                ]
            );
        }
    }
}
