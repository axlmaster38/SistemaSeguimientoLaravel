<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notificaciones', function (Blueprint $table) {
            if (! Schema::hasColumn('notificaciones', 'estado_registro')) {
                $table->string('estado_registro', 20)->default('Activo')->after('archivo')->index('notificaciones_estado_reg_idx');
            }
        });

        Schema::table('apelaciones', function (Blueprint $table) {
            if (! Schema::hasColumn('apelaciones', 'estado_registro')) {
                $table->string('estado_registro', 20)->default('Activo')->after('tipo_apelacion')->index('apelaciones_estado_reg_idx');
            }
        });

        DB::table('notificaciones')
            ->where('instancia', 'Primera NotificaciÃ³n')
            ->update(['instancia' => 'Primera Notificación']);
    }

    public function down(): void
    {
        Schema::table('notificaciones', function (Blueprint $table) {
            if (Schema::hasColumn('notificaciones', 'estado_registro')) {
                $table->dropIndex('notificaciones_estado_reg_idx');
                $table->dropColumn('estado_registro');
            }
        });

        Schema::table('apelaciones', function (Blueprint $table) {
            if (Schema::hasColumn('apelaciones', 'estado_registro')) {
                $table->dropIndex('apelaciones_estado_reg_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
