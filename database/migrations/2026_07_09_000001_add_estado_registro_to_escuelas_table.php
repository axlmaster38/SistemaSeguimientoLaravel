<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escuelas', function (Blueprint $table) {
            $table->string('estado_registro', 20)
                ->default('Activo')
                ->after('nombre')
                ->index('escuelas_estado_registro_idx');
        });
    }

    public function down(): void
    {
        Schema::table('escuelas', function (Blueprint $table) {
            $table->dropIndex('escuelas_estado_registro_idx');
            $table->dropColumn('estado_registro');
        });
    }
};
