<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('denuncias', function (Blueprint $table) {
            if (! Schema::hasColumn('denuncias', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('denuncia_antigua')
                    ->index('denuncias_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('denuncias', function (Blueprint $table) {
            if (Schema::hasColumn('denuncias', 'estado_registro')) {
                $table->dropIndex('denuncias_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
