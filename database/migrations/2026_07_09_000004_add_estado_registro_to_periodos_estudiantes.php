<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('periodos_academicos', function (Blueprint $table) {
            if (! Schema::hasColumn('periodos_academicos', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('fecha_fin')
                    ->index('periodos_estado_registro_idx');
            }
        });

        Schema::table('estudiantes', function (Blueprint $table) {
            if (! Schema::hasColumn('estudiantes', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('direccion')
                    ->index('estudiantes_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            if (Schema::hasColumn('estudiantes', 'estado_registro')) {
                $table->dropIndex('estudiantes_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });

        Schema::table('periodos_academicos', function (Blueprint $table) {
            if (Schema::hasColumn('periodos_academicos', 'estado_registro')) {
                $table->dropIndex('periodos_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
