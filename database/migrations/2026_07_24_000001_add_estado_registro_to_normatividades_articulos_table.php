<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('normatividades', function (Blueprint $table): void {
            if (! Schema::hasColumn('normatividades', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('fecha_actualiza');

                $table->index('estado_registro', 'norm_estado_registro_idx');
            }
        });

        Schema::table('articulos', function (Blueprint $table): void {
            if (! Schema::hasColumn('articulos', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('fecha_actualiza');

                $table->index('estado_registro', 'art_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table): void {
            if (Schema::hasColumn('articulos', 'estado_registro')) {
                $table->dropIndex('art_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });

        Schema::table('normatividades', function (Blueprint $table): void {
            if (Schema::hasColumn('normatividades', 'estado_registro')) {
                $table->dropIndex('norm_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
