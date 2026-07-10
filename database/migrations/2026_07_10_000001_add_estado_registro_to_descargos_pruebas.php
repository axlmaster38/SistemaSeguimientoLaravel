<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('descargos', function (Blueprint $table) {
            if (! Schema::hasColumn('descargos', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('descripcion')
                    ->index('descargos_estado_registro_idx');
            }
        });

        Schema::table('pruebas', function (Blueprint $table) {
            if (! Schema::hasColumn('pruebas', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('archivo')
                    ->index('pruebas_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pruebas', function (Blueprint $table) {
            if (Schema::hasColumn('pruebas', 'estado_registro')) {
                $table->dropIndex('pruebas_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });

        Schema::table('descargos', function (Blueprint $table) {
            if (Schema::hasColumn('descargos', 'estado_registro')) {
                $table->dropIndex('descargos_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
