<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('decisiones', function (Blueprint $table) {
            if (! Schema::hasColumn('decisiones', 'estado_registro')) {
                $table->string('estado_registro', 20)->default('Activo')->after('archivo')->index('decisiones_estado_registro_idx');
            }
        });

        Schema::table('sanciones', function (Blueprint $table) {
            if (! Schema::hasColumn('sanciones', 'estado_registro')) {
                $table->string('estado_registro', 20)->default('Activo')->after('estado_sancion')->index('sanciones_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sanciones', function (Blueprint $table) {
            if (Schema::hasColumn('sanciones', 'estado_registro')) {
                $table->dropIndex('sanciones_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });

        Schema::table('decisiones', function (Blueprint $table) {
            if (Schema::hasColumn('decisiones', 'estado_registro')) {
                $table->dropIndex('decisiones_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
