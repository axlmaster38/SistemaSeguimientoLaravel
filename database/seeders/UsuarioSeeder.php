<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['usuario' => 'admin'],
            [
                'identificacion' => '0000000001',
                'contrasena' => Hash::make('admin123'),
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'email' => 'admin@sistema.com',
                'telefono' => '0000000000',
                'rol' => 'Administrador',
                'estado' => 'Activo',
            ]
        );
    }
}
