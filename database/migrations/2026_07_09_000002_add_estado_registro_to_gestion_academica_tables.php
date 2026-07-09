<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->string('estado_registro', 20)
                ->default('Activo')
                ->after('nombre')
                ->index('programas_estado_registro_idx');
        });

        Schema::table('zonas', function (Blueprint $table) {
            $table->string('estado_registro', 20)
                ->default('Activo')
                ->after('nombre')
                ->index('zonas_estado_registro_idx');
        });

        Schema::table('centros', function (Blueprint $table) {
            $table->string('estado_registro', 20)
                ->default('Activo')
                ->after('centro')
                ->index('centros_estado_registro_idx');
        });
    }

    public function down(): void
    {
        Schema::table('centros', function (Blueprint $table) {
            $table->dropIndex('centros_estado_registro_idx');
            $table->dropColumn('estado_registro');
        });

        Schema::table('zonas', function (Blueprint $table) {
            $table->dropIndex('zonas_estado_registro_idx');
            $table->dropColumn('estado_registro');
        });

        Schema::table('programas', function (Blueprint $table) {
            $table->dropIndex('programas_estado_registro_idx');
            $table->dropColumn('estado_registro');
        });
    }
};
