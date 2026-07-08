<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodos_academicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('codigo')->nullable()->index();
            $table->string('periodo', 10);
            $table->unsignedSmallInteger('anio');
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->foreignId('usuario_registra_id')
                ->constrained('usuarios')
                ->restrictOnDelete();
            $table->foreignId('usuario_actualiza_id')
                ->nullable()
                ->constrained('usuarios')
                ->restrictOnDelete();
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_actualiza')->nullable();

            $table->unique(['periodo', 'anio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodos_academicos');
    }
};
