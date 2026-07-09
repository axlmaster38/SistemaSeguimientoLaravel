<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procesos_disciplinarios', function (Blueprint $table) {
            if (! Schema::hasColumn('procesos_disciplinarios', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('proceso_antiguo')
                    ->index('procesos_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('procesos_disciplinarios', function (Blueprint $table) {
            if (Schema::hasColumn('procesos_disciplinarios', 'estado_registro')) {
                $table->dropIndex('procesos_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
