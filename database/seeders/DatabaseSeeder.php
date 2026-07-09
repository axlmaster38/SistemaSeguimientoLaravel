<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            EscuelaSeeder::class,
            ZonaSeeder::class,
            CentroSeeder::class,
            ProgramaSeeder::class,
            TipologiaFaltaSeeder::class,
            PeriodoAcademicoSeeder::class,
            NormatividadSeeder::class,
            ArticuloSeeder::class,
        ]);
    }
}
