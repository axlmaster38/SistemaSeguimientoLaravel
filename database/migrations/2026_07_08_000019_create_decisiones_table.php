<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decisiones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->default('null');
            $table->string('tipo_decision', 50);
            $table->timestamp('fecha_sesion')->default('2025-01-01 00:00:00');
            $table->text('resultado')->nullable();
            $table->string('clasificacion_falta', 50)->nullable()->default('null');
            $table->text('observaciones')->nullable();
            $table->string('archivo', 255);
            $table->foreignId('proceso_disciplinario_id')
                ->constrained('procesos_disciplinarios')
                ->restrictOnDelete();
            $table->foreignId('usuario_registra_id')
                ->constrained('usuarios')
                ->restrictOnDelete();
            $table->foreignId('usuario_actualiza_id')
                ->nullable()
                ->constrained('usuarios')
                ->restrictOnDelete();
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_actualiza')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decisiones');
    }
};
