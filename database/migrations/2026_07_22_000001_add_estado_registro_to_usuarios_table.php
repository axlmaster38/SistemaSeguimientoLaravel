<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table): void {
            if (! Schema::hasColumn('usuarios', 'estado_registro')) {
                $table->string('estado_registro', 20)
                    ->default('Activo')
                    ->after('estado');

                $table->index('estado_registro', 'usuarios_estado_registro_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table): void {
            if (Schema::hasColumn('usuarios', 'estado_registro')) {
                $table->dropIndex('usuarios_estado_registro_idx');
                $table->dropColumn('estado_registro');
            }
        });
    }
};
